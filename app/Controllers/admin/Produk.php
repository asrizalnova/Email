<?php

namespace App\Controllers\admin;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    // surat keluar
    public function index()
{
    // Pengecekan apakah pengguna sudah login atau belum
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
    }

    $produkModel = new ProdukModel();
    $all_data_produk = $produkModel->orderBy('id_SK', 'DESC')->findAll(); // Ordered by id_SK descending

    return view('admin/produk/index', [
        'all_data_produk' => $all_data_produk
    ]);
}

    

    public function tambah()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        $produk_model = new ProdukModel();
        $all_data_produk = $produk_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/produk/tambah', [
            'all_data_produk' => $all_data_produk,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
{
    set_time_limit(0); // Menonaktifkan batas waktu eksekusi
    // Pengecekan apakah pengguna sudah login atau belum
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
    }
    date_default_timezone_set('Asia/Jakarta');
    $file_foto = $this->request->getFile('surat_keluar');
    $currentDateTime = date('dmYHis');
    $nama_produk_in = $this->request->getVar("nama_produk_in");
    $nama_produk_en = $this->request->getVar("nama_produk_en");
    $deskripsi_produk_en = $this->request->getVar("deskripsi_produk_en");
    
    // Set status to "telah_dikirim"
    $status = 'baru di tambahkan';

    if (!$this->validate([
        'surat_keluar' => [
            'rules' => 'uploaded[surat_keluar]|ext_in[surat_keluar,pdf,docx]|max_size[surat_keluar,20240]',
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
        $newFileName = "{$nama_produk_en}{$nama_produk_in}{$currentDateTime}.{$file_foto->getExtension()}";
        $file_foto->move('asset-user/images', $newFileName);

        $produkModel = new ProdukModel();
        $data = [
            'instansi_ditujukan' => $nama_produk_in,
            'keperluan' => $nama_produk_en,
            'deskripsi_produk_en' => $deskripsi_produk_en,
            'surat_keluar' => $newFileName,
            'status' => $status // Simpan nilai status ke dalam database
        ];
        $produkModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/produk/index'));
    }
}

    
    
    public function edit($id_SK)
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        $produk_model = new ProdukModel();
        $produkData = $produk_model->find($id_SK);
        $validation = \Config\Services::validation();

        return view('admin/produk/edit', [
            'produkData' => $produkData,
            'validation' => $validation
        ]);
    }

  
    public function proses_edit($id_SK = null)
{
    if (!$id_SK) {
        return redirect()->back();
    }

    $produkModel = new ProdukModel();
    $produkData = $produkModel->find($id_SK);

    $nama_produk_in = $this->request->getVar("nama_produk_in");
    $nama_produk_en = $this->request->getVar("nama_produk_en");
    $file_foto = $this->request->getFile('surat_keluar');

    // Check if new 'surat_keluar' file is uploaded
    if ($this->request->getFile('surat_keluar')->isValid()) {
        // Delete the old 'surat_keluar' file if it exists
        $oldFilePath = 'asset-user/images/' . $produkData->surat_keluar;
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        // Generate new file name
        $currentDateTime = date('dmYHis');
        $newFileName = "{$nama_produk_en}{$nama_produk_in}{$currentDateTime}.{$file_foto->getExtension()}";

        $file_foto->move('asset-user/images', $newFileName);
    } else {
        // If no new 'surat_keluar' file is uploaded, keep the old filename
        $newFileName = $produkData->surat_keluar;
    }

    // Update the product data
    $data = [
        'surat_keluar' => $newFileName,
        'instansi_ditujukan' => $nama_produk_in,
        'keperluan' => $nama_produk_en,
        'deskripsi_produk_in' => $this->request->getPost("deskripsi_produk_in"),
        'deskripsi_produk_en' => $this->request->getPost("deskripsi_produk_en"),
    ];

    // Update the product data in the database
    $produkModel->where('id_SK', $id_SK)->set($data)->update();

    session()->setFlashdata('success', 'Berkas berhasil diperbarui');
    return redirect()->to(base_url('admin/produk/index'));
}



public function delete($id_SK = false)
{
    // Pengecekan apakah pengguna sudah login atau belum
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
    }
    $produkModel = new ProdukModel();

    $data = $produkModel->find($id_SK);

    unlink('asset-user/images/' . $data->surat_keluar);

    if ($produkModel->delete($id_SK)) {
        session()->setFlashdata('success', 'Data berhasil dihapus');
    } else {
        session()->setFlashdata('error', 'Gagal menghapus data');
    }

    return redirect()->to(base_url('admin/produk/index'));
}

    public function email()
{
    if ($this->request->getMethod() == 'post') {
        $id_SK = $this->request->getVar('id_SK');
        $email_tujuan = $this->request->getVar('email_tujuan');
        $subject = $this->request->getVar('subject');
        $isi_pesan = $this->request->getVar('isi_pesan');
        $existing_file = $this->request->getVar('existing_file');

        $email = \Config\Services::email();
        $email->setTo($email_tujuan);
        $email->setFrom('ahonganakbaik@gmail.com', 'Sekre bos');

        $email->setSubject($subject);
        $email->setMessage($isi_pesan);

        // Lampirkan file yang sudah ada
        if ($existing_file) {
            $filePath = FCPATH . 'asset-user/images/' . $existing_file;
            if (file_exists($filePath)) {
                $email->attach($filePath);
            }
        }

        if ($email->send()) {
            // Update status to "sudah dikirim"
            $produkModel = new ProdukModel();
            $produkModel->update($id_SK, ['status' => 'sudah dikirim']);

            // Berhasil
            session()->setFlashdata('success', 'Email berhasil dikirim');
        } else {
            // Gagal
            session()->setFlashdata('error', 'Gagal mengirim email');
        }

        return redirect()->to(base_url('admin/produk/index'));
    }
}

public function send_email()
{
    if ($this->request->getMethod() == 'post') {
        $email_tujuan = $this->request->getVar('email_tujuan');
        $subject = $this->request->getVar('subject');
        $isi_pesan = $this->request->getVar('isi_pesan');

        $email = \Config\Services::email();
        $email->setTo($email_tujuan);
        $email->setFrom('ramonsgx12@gmail.com', 'sekre pt elecomp');

        $email->setSubject($subject);
        $email->setMessage($isi_pesan);

        

        if ($email->send()) {
            // Success
            session()->setFlashdata('success', 'Email berhasil dikirim');
        } else {
            // Error
            session()->setFlashdata('error', 'Gagal mengirim email');
        }

        return redirect()->to(base_url('admin/produk/index'));
    }
}


}