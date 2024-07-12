<?php

namespace App\Controllers\admin;

use App\Models\ProfilModel;

class Profil extends BaseController
{
    public function index()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        $profil_model = new ProfilModel();
        $all_data_profil = $profil_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/user/index', [
            'all_data_profil' => $all_data_profil,
            'validation' => $validation
        ]);
    }

    

    public function delete($id = false)
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        $profilModel = new ProfilModel();

        $data = $profilModel->find($id);

        unlink('asset-user/images/' . $data->foto_produk);

        $profilModel->delete($id);

        return redirect()->to(base_url('admin/profil/index'));
    }
}
