<?php

namespace App\Controllers\admin;

use App\Models\DivisiTigaModel;
use App\Models\SliderModel;
use App\Models\DivisiUtamaModel;
use App\Models\DivisiDuaModel;
use App\Models\PimpinanModel;



class Slider extends BaseController
{
    public function index()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        $slider_model = new SliderModel();
        $all_data_slider = $slider_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/slider/index', [
            'all_data_slider' => $all_data_slider,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        $slider_model = new SliderModel();
        $all_data_slider = $slider_model->findAll();
        $validation = \Config\Services::validation();
    
        // Generate redeem code
        $redeem_code = $this->generate_redeem_code();
 
        return view('admin/slider/tambah', [
            'all_data_slider' => $all_data_slider,
            'validation' => $validation,
            'redeem_code' => $redeem_code 
        ]);
    }

    public function proses_tambah()
    {
        $nama_produk_in = $this->request->getVar("nama_produk_in");
        $nama_produk_en = $this->request->getVar("nama_produk_en");
        $status = $this->request->getVar("status");
        $komentar = $this->request->getVar("komentar");
    
        date_default_timezone_set('Asia/Jakarta');
        $file_foto = $this->request->getFile('surat');
        $currentDateTime = date('dmYHis');
        
        $status = "Telah Dikirim Ke Pimpinan"; // Tetapkan nilai status secara langsung
    
        if (!$this->validate([
            'surat' => [
                'rules' => 'uploaded[surat]|ext_in[surat,pdf,docx]|max_size[surat,20240]',
                'errors' => [
                    'uploaded' => 'Pilih file surat terlebih dahulu',
                    'ext_in' => 'File yang anda pilih harus berupa PDF atau DOCX',
                    'max_size' => 'Ukuran file tidak boleh melebihi 20 MB'
                ]
            ]
    
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        } else {
            $newFileName = "{$nama_produk_in}_{$currentDateTime}.{$file_foto->getExtension()}";
            $file_foto->move('asset-user/images', $newFileName);
    
            $redeem_code = $this->generate_redeem_code();
    
            $sliderModel = new SliderModel();
            $data = [
                'instansi_pengirim' => $nama_produk_in,
                'keperluan' => $nama_produk_en,
                'surat' => $newFileName,
                'status' => $status,
                'code' => $redeem_code,
                'komentar'=>$komentar
            ];
            $sliderModel->save($data);
            if ($sliderModel->save($data)) {
                session()->setFlashdata('success', 'Berkas berhasil ditambahkan.');
                return redirect()->to(base_url('admin/slider/index'));
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan berkas.');
                return redirect()->back()->withInput();
            }
    
        }
    }
    
    
    
    
    
    public function generate_redeem_code()
{
    // Generate a random redeem code (You can customize this code generation logic)
    $redeem_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8)); // Example code generation
    
    return $redeem_code;
}
    
    
public function edit($id_slider)
{
    // Check if the user is logged in
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }

    // Load the SliderModel and fetch data by id
    $slider_model = new SliderModel();
    $sliderData = $slider_model->find($id_slider);
    $validation = \Config\Services::validation();

    // Pass the data to the view
    return view('admin/slider/edit', [
        'sliderData' => $sliderData,
        'validation' => $validation
    ]);
}


public function proses_edit($id_slider = null)
{
    // Check if slider ID is provided
    if (!$id_slider) {
        return redirect()->back();
    }

    // Load SliderModel and fetch existing slider data
    $sliderModel = new SliderModel();
    $sliderData = $sliderModel->find($id_slider);

    // Validate form inputs (if necessary)
    // Handle file upload (if necessary)

    // Determine the new file name if a new file is uploaded
    $newFileName = $sliderData->surat; // Default to current file if no new file uploaded

    if ($this->request->getFile('surat')->isValid()) {
        // Delete the old file if a new one is uploaded
        $oldFilePath = 'asset-user/images/' . $sliderData->surat;
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        // Upload the new file
        $file_foto = $this->request->getFile('surat');
        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = date('dmYHis');
        $newFileName = "{$currentDateTime}." . $file_foto->getExtension();
        $file_foto->move('asset-user/images', $newFileName);
    }

    // Retain the existing status if not updated
    $status = $sliderData->status;

    // Prepare updated data
    $data = [
        'surat' => $newFileName,
        'instansi_pengirim' => $this->request->getVar("nama_produk_in"),
        'keperluan' => $this->request->getVar("nama_produk_en"),
        'status' => $status, // Keep the existing status
        'deskripsi_produk_in' => $this->request->getPost("deskripsi_produk_in"),
        'deskripsi_produk_en' => $this->request->getPost("deskripsi_produk_en"),
        'komentar' => $this->request->getVar("komentar") // Add komentar field to update data
    ];

    // Perform update
    $sliderModel->where('id_SM', $id_slider)->set($data)->update();

    // Set flash message and redirect
    session()->setFlashdata('success', 'Berkas berhasil diperbarui');
    return redirect()->to(base_url('admin/slider/index'));
}

   
    public function cariByRedeemKode()
    {
        // Menerima kode redeem dari input form
        $redeem_code = $this->request->getGet('redeem_code');
    
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
    
        // Mencari data slider berdasarkan redeem kode
        $sliderModel = new SliderModel();
        $sliderData = $sliderModel->where('code', $redeem_code)->first();
    
        if (!$sliderData) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to(base_url('admin/slider/index'));
        }
    
        // Menampilkan status pada data yang sesuai
        session()->setFlashdata('success', 'Data ditemukan. Status: ' . $sliderData->status);
        return redirect()->to(base_url('admin/slider/index'));
    }
    public function salinKePimpinan($id_SM)
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }

        // Temukan data slider berdasarkan ID
        $sliderModel = new SliderModel();
        $sliderData = $sliderModel->find($id_SM);

        // Simpan data ke tabel pimpinan
        $pimpinanModel = new PimpinanModel(); // Model untuk tabel pimpinan
        $pimpinanData = [
            'instansi_ditujukan' => $sliderData->instansi_pengirim,
            'keterangan' => $sliderData->keperluan,
            'status' => $sliderData->status,
            'komentar'=>$sliderData->komentar,
            'file' => $sliderData->surat,
        ];
        $pimpinanModel->save($pimpinanData);

        $email = service('email');
        $email_tujuan = 'asrizal7889@gmail.com'; // Ganti dengan alamat email tujuan disposisi
        $subject = 'Surat masuk baru';
        $isi_pesan = 'Permisi ada surat masuk baru';
    
        $email->setTo($email_tujuan);
        $email->setFrom('ahonganakbaik@gmail.com', 'sekre');
        $email->setSubject($subject);
        $email->setMessage($isi_pesan);
    
        if ($email->send()) {
            // Email berhasil dikirim
            session()->setFlashdata('success', 'Data berhasil didisposisikan dan email notifikasi berhasil dikirim');
        } else {
            // Email gagal dikirim
            session()->setFlashdata('warning', 'Data berhasil didisposisikan tetapi email notifikasi gagal dikirim');
        }
    

      
        // Redirect ke halaman slider index setelah proses selesai
        return redirect()->to(base_url('admin/slider/index'));
    }
    

    
    
// }

public function baca($id_SM)
{
    // Pengecekan apakah pengguna sudah login atau belum
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
    }

    $sliderModel = new SliderModel();
    $sliderData = $sliderModel->find($id_SM);

    // Perbarui status menjadi "sudah dibaca pimpinan"
    $data = [
        'status' => 'Sudah Dibaca Pimpinan'
    ];
    $sliderModel->update($id_SM, $data);

    // Mengunduh file surat
    $filePath = 'asset-user/images/' . $sliderData->surat;
    $this->response->download($filePath, null)->setFileName($sliderData->surat);

    // Kode JavaScript untuk memicu unduhan otomatis
    echo '<script>
            setTimeout(function() {
                var link = document.createElement("a");
                link.download = "' . $sliderData->surat . '";
                link.href = "' . base_url('admin/slider/baca/') . $id_SM . '";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }, 1000); // Memulai unduhan otomatis setelah 1 detik (1000 milidetik)
          </script>';

    // Redirect kembali ke halaman sebelumnya setelah beberapa detik
    echo '<script>
            setTimeout(function() {
                window.history.back();
            }, 1000); // Redirect kembali ke halaman sebelumnya setelah 3 detik (3000 milidetik)
          </script>';
}

public function delete($id_SM)
{
    // Pengecekan apakah pengguna sudah login atau belum
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
    }

    // Temukan data slider berdasarkan ID
    $sliderModel = new SliderModel();
    $sliderData = $sliderModel->find($id_SM);

    // Jika data tidak ditemukan, kembalikan dengan pesan kesalahan
    if (!$sliderData) {
        session()->setFlashdata('error', 'Data tidak ditemukan.');
        return redirect()->to(base_url('admin/slider/index'));
    }

    // Hapus file surat dari folder 'asset-user/images'
    $filePath = 'asset-user/images/' . $sliderData->surat;
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Hapus data dari database
    $sliderModel->delete($id_SM);

    // Redirect ke halaman index dengan pesan sukses
    session()->setFlashdata('success', 'Data berhasil dihapus.');
    return redirect()->to(base_url('admin/slider/index'));
}


}


