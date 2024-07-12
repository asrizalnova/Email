<?php

namespace App\Controllers\admin;

use App\Models\DivisiUtamaModel;
use App\Models\DivisiDuaModel;
use App\Models\DivisiTigaModel;

use App\Models\PengajuanModel;
use App\Models\SliderModel;

class Divisi extends BaseController
{
    public function awal()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Tentukan divisi berdasarkan session idlevel
        $divisi = '';
        if (session()->idlevel == 4) {
            $divisi = 'Divisi Marketing';
        } elseif (session()->idlevel == 5) {
            $divisi = 'Divisi Human Resource';
        } elseif (session()->idlevel == 6) {
            $divisi = 'Divisi Umum';
        }

        return view('admin/divisi/awal', ['divisi' => $divisi]);
    }
    public function index()
{
    // Pengecekan apakah pengguna sudah login atau belum
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
    }
    
    $divisiUtamaModel = new DivisiUtamaModel();
    // $divisiDuaModel = new DivisiDuaModel();
    // $divisiTigaModel = new DivisiTigaModel();
    
    // Mengambil data dari ketiga model
    $all_data_divisi_utama = $divisiUtamaModel->orderBy('waktu', 'DESC')->findAll();
    // $all_data_divisi_dua = $divisiDuaModel->findAll();
    // $all_data_divisi_tiga = $divisiTigaModel->findAll();
    
    // Menggabungkan data dari ketiga model menjadi satu array
    // $all_data_divisi = array_merge($all_data_divisi_utama, $all_data_divisi_dua, $all_data_divisi_tiga);
    
    $validation = \Config\Services::validation();
    
    return view('admin/divisi/index', [
        'all_data_divisi_utama' => $all_data_divisi_utama, // Mengirimkan data divisi ke view
        'validation' => $validation
    ]);
}

    public function divisi02()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    
    $divisiDuaModel = new DivisiDuaModel();
    $all_data_divisi_dua = $divisiDuaModel->orderBy('id_divisi02', 'DESC')->findAll();
    
    $validation = \Config\Services::validation();
    
    return view('admin/divisi/lihat', [
        'all_data_divisi_dua' => $all_data_divisi_dua,
        'validation' => $validation
    ]);
}

public function divisi03()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    
    $divisiTigaModel = new DivisiTigaModel();
    
    $all_data_divisi_tiga = $divisiTigaModel->orderBy('id_divisi03', 'DESC')->findAll();
    
    $validation = \Config\Services::validation();
    
    return view('admin/divisi/view', [
        'all_data_divisi_tiga' => $all_data_divisi_tiga,
        'validation' => $validation
    ]);
}



public function generate_redeem_code()
{
    // Generate a random redeem code (You can customize this code generation logic)
    $redeem_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8)); // Example code generation
    
    return $redeem_code;
}
    
public function Pengajuan()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    
    $pengajuanModel = new PengajuanModel();
    $all_data_Pengajuan =  $pengajuanModel ->findAll();
    $redeem_code = $this->generate_redeem_code();
    
    $validation = \Config\Services::validation();
    
    return view('admin/divisi/pengajuan', [
        'all_data_Pengajuan' => $all_data_Pengajuan,
        'validation' => $validation,
        'redeem_code' => $redeem_code 
    ]);
}
public function tambah()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    
    $pengajuanModel = new PengajuanModel();
    $all_data_Pengajuan =  $pengajuanModel ->findAll();
    $redeem_code = $this->generate_redeem_code();
    
    $validation = \Config\Services::validation();
    
    return view('admin/divisi/tambah', [
        'all_data_Pengajuan' => $all_data_Pengajuan,
        'validation' => $validation,
        'redeem_code' => $redeem_code 
    ]);
}
public function proses_pengajuan()
{
    $instansi_pengirim = $this->request->getVar("instansi_pengirim");
    $keperluan = $this->request->getVar("keperluan");
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
        $newFileName = "{$instansi_pengirim}_{$currentDateTime}.{$file_foto->getExtension()}";
        $file_foto->move('asset-user/images', $newFileName);

        $redeem_code = $this->generate_redeem_code();

        $pengajuanModel = new PengajuanModel();
        $data = [
            'instansi_pengirim' => $instansi_pengirim,
            'keperluan' => $keperluan,
            'surat' => $newFileName,
            'status' => $status,
            'code' => $redeem_code,
            'komentar' => $komentar
        ];
        $pengajuanModel->save($data);

        session()->setFlashdata('success', 'Berkas berhasil ditambahkan.');

        return redirect()->to(base_url('admin/divisi/pengajuan'));
    }
}

public function Ajukan($id_req)
{
    // Pengecekan apakah pengguna sudah login atau belum
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
    }

    // Temukan data slider berdasarkan ID
    $sliderModel = new PengajuanModel();
    $sliderData = $sliderModel->find($id_req);

    // Simpan data ke tabel pimpinan
    $pimpinanModel = new SliderModel(); // Model untuk tabel pimpinan
    $pimpinanData = [
        'instansi_pengirim' => $sliderData->instansi_pengirim,
        'keperluan' => $sliderData->keperluan,
        'status' => $sliderData->status,
        'komentar' => $sliderData->komentar,
        'surat' => $sliderData->surat,
        'code' => $sliderData->code
    ];
    $pimpinanModel->save($pimpinanData);

    // Simpan pesan ke dalam session
    session()->setFlashdata('success', 'Surat berhasil dinaikkan ke sekretaris, Silahkan menunggu informasi selanjutnya.');

    // Redirect ke halaman pengajuan setelah proses selesai
    return redirect()->to(base_url('admin/divisi/pengajuan'));
}



}
