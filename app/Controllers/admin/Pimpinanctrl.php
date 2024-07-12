<?php

namespace App\Controllers\admin;

use App\Controllers\admin\BaseController;
use App\Models\PimpinanModel;
use App\Models\DivisiTigaModel;
use App\Models\DivisiUtamaModel;
use App\Models\DivisiDuaModel;

class Pimpinanctrl extends BaseController
{
    protected $pimpinanModel;

    public function __construct()
    {
        $this->pimpinanModel = new PimpinanModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }
        
        $all_data_pimpinan = $this->pimpinanModel->findAll();
        
        $validation = \Config\Services::validation();
        
        return view('admin/divisi/pimpinan', [
            'all_data_pimpinan' => $all_data_pimpinan,
            'validation' => $validation
        ]);
    }

    public function saveSignature()
{
    if ($this->request->getMethod() !== 'post') {
        return redirect()->to(base_url('admin/pimpinan'));
    }

    $id = $this->request->getPost('id');
    $signatureDataUrl = $this->request->getPost('signature');

    $validationRules = [
        'id' => 'required|integer',
        'signature' => 'required'
    ];

    if (!$this->validate($validationRules)) {
        return redirect()->back()->with('error', $this->validator->getErrors());
    }

    $uploadPath = ROOTPATH . 'public/asset-user/images/';
    $fileName = 'signature_' . $id . '.png';

    $imageData = str_replace('data:image/png;base64,', '', $signatureDataUrl);
    $imageData = base64_decode($imageData);

    $pathToFile = $uploadPath . $fileName;
    if (!file_put_contents($pathToFile, $imageData)) {
        return redirect()->back()->with('error', 'Gagal menyimpan tanda tangan di lokal.');
    }

    $data = [
        'signature' => 'asset-user/images/' . $fileName,
        'status' => 'Diterima oleh Atasan'
    ];

    $this->pimpinanModel->update($id, $data);

    return redirect()->back()->with('success', 'Tanda tangan berhasil disimpan.');
}

    public function reject()
    {
        if ($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');

            $data = [
                'status' => 'Ditolak oleh Atasan'
            ];

            $this->pimpinanModel->update($id, $data);

            return redirect()->back()->with('success', 'Surat telah ditolak.');
        }
    }

    

    public function reset()
    {
        if ($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');

            $data = [
                'status' => null,
                'signature' => null
            ];

            // Reset tanggapan juga
            $this->pimpinanModel->update($id, $data);
            $this->pimpinanModel->update($id, ['tanggapan' => null]);

            return redirect()->back()->with('success', 'Keputusan berhasil direset.');
        }
    }
    public function saveResponse()
    {
        if ($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            $response = $this->request->getPost('tanggapan');

            // Simpan tanggapan ke dalam database atau storage yang Anda tentukan
            $model = new PimpinanModel();
            $model->update($id, ['tanggapan' => $response]);

            return redirect()->back()->with('success', 'Tanggapan berhasil disimpan.');
        }
    }



    public function status()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    
    $all_data_pimpinan = $this->pimpinanModel->findAll();
    
    // Reverse the array to display newest first
    $all_data_pimpinan = array_reverse($all_data_pimpinan);
    
    $validation = \Config\Services::validation();
    
    return view('admin/slider/status', [
        'all_data_pimpinan' => $all_data_pimpinan,
        'validation' => $validation
    ]);
}


    public function disposisi($id) {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        
        // Temukan data slider berdasarkan ID
        $pimpinanData = $this->pimpinanModel->find($id);

        $divisiUtamaModel = new DivisiUtamaModel();
        $divisiData = [
            'instansi_pengirim' => $pimpinanData->instansi_ditujukan,
            'keperluan' => $pimpinanData->keterangan,
            'surat' => $pimpinanData->file,
            'status' => $pimpinanData->status,
        ];
        $divisiUtamaModel->save($divisiData);
    
        // Kirim email notifikasi
        $email = service('email');
        $email_tujuan = 'asrizal7889@gmail.com'; // Ganti dengan alamat email tujuan disposisi
        $subject = 'Data telah didisposisikan';
        $isi_pesan = 'Data telah didisposisikan ke divisi Marketing.';
    
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
    
        // Setelah data disimpan, Anda mungkin ingin menghapus data dari tabel slider, jika diperlukan.
        // $sliderModel->delete($id_SM);
    
        // Setelah proses disposisi selesai, redirect pengguna ke halaman tertentu, misalnya halaman slider index.
        return redirect()->to(base_url('admin/slider/index'));
    }

    public function divisi02($id)
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        
        // Temukan data slider berdasarkan ID
        $pimpinanData = $this->pimpinanModel->find($id);
        $signature = $this->request->getPost('signature');

        $divisi02 = new DivisiDuaModel();
        $divisiData = [
            'instansi_pengirim' => $pimpinanData->instansi_ditujukan,
            'keperluan' => $pimpinanData->keterangan,
            'surat' => $pimpinanData->file,
            'status' => $pimpinanData->status,
           
            'signature' => $signature
        ];
        $divisi02->save($divisiData);

        // Kirim email notifikasi
        $email = service('email');
        $email_tujuan = 'asrizal7889@gmail.com'; // Ganti dengan alamat email tujuan disposisi
        $subject = 'Data telah didisposisikan';
        $isi_pesan = 'Data telah didisposisikan ke divisi HR.';
     
        $email->setTo($email_tujuan);
        $email->setFrom('ahonganakbaik@gmail.com', 'cek');
        $email->setSubject($subject);
        $email->setMessage($isi_pesan);
     
        if ($email->send()) {
            // Email berhasil dikirim
            session()->setFlashdata('success', 'Data berhasil didisposisikan ke divisi dua dan email notifikasi berhasil dikirim');
        } else {
            // Email gagal dikirim
            session()->setFlashdata('warning', 'Data berhasil didisposisikan ke divisi dua tetapi email notifikasi gagal dikirim');
        }

        // Redirect ke halaman slider index setelah proses selesai
        return redirect()->to(base_url('admin/slider/index'));
    }

    public function divisi03($id) {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        
        // Temukan data slider berdasarkan ID
        $pimpinanData = $this->pimpinanModel->find($id);

        $divisi03 = new DivisiTigaModel();
        $divisiData = [
            'instansi_pengirim' => $pimpinanData->instansi_ditujukan,
            'keperluan' => $pimpinanData->keterangan,
            'surat' => $pimpinanData->file,
            'status' => $pimpinanData->status,
          
        
        ];
        $divisi03->save($divisiData);

        $email = service('email');
        $email_tujuan = 'asrizal7889@gmail.com'; // Ganti dengan alamat email tujuan disposisi
        $subject = 'Data telah didisposisikan';
        $isi_pesan = 'Data telah didisposisikan ke divisi Umum.';
    
        $email->setTo($email_tujuan);
        $email->setFrom('ahonganakbaik@gmail.com', 'rizal');
        $email->setSubject($subject);
        $email->setMessage($isi_pesan);
    
        if ($email->send()) {
            // Email berhasil dikirim
            session()->setFlashdata('success', 'Data berhasil didisposisikan ke divisi tiga dan email notifikasi berhasil dikirim');
        } else {
            // Email gagal dikirim
            session()->setFlashdata('warning', 'Data berhasil didisposisikan ke divisi tiga tetapi email notifikasi gagal dikirim');
        }
    
        // Setelah data disimpan, Anda mungkin ingin menghapus data dari tabel slider, jika diperlukan.
        // $sliderModel->delete($id_SM);
    
        // Setelah proses disposisi selesai, redirect pengguna ke halaman tertentu, misalnya halaman slider index.
        return redirect()->to(base_url('admin/slider/index'));
    }
    private function sendEmailNotification($to, $subject, $message)
    {
        $email = service('email');
        $email->setTo($to);
        $email->setFrom('ahonganakbaik@gmail.com', 'sekre');
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            session()->setFlashdata('success', 'Email notifikasi berhasil dikirim');
        } else {
            session()->setFlashdata('warning', 'Email notifikasi gagal dikirim');
        }
    }

   

   
}
