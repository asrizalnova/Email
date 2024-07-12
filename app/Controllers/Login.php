<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProfilModel;

class Login extends BaseController
{
    public function __construct()
    {
        helper(['form']);
    }
    
    public function index()
    {
        // Pengecekan jika pengguna sudah login
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('admin/dashboard')); // Ubah 'vw_home' sesuai dengan halaman yang diinginkan setelah login
        }

        // Proses login jika pengguna belum login
        return view('admin/login/index');
    }

    public function process()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $sessError = [
                'errUsername' => $validation->getError('username'),
                'errPassword' => $validation->getError('password'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(site_url('/login/index'));
        } else {
            $modelLogin = new ProfilModel();
            $cekUserLogin = $modelLogin->where('username', $username)->first();

            if ($cekUserLogin === null) {
                $sessError = [
                    'errUsername' => 'Username Anda Salah'
                ];
                session()->setFlashdata($sessError);
                return redirect()->to(site_url('/login/index'));
            } else {
                $passwordUser = $cekUserLogin['password'];

                if (password_verify($password, $passwordUser)) {
                    // Password benar, lakukan tindakan selanjutnya
                    $id_user = $cekUserLogin['id_user'];
                    $idlevel = $cekUserLogin['useridlevel'];
                    $simpan_session = [
                        'id_user' => $id_user,
                        'namauser' => $cekUserLogin['username'],
                        'idlevel' => $idlevel,
                        'logged_in' => TRUE
                    ];
                    session()->set($simpan_session);
                    return redirect()->to(site_url('admin/dashboard'));
                } else {
                    // Password salah, set pesan kesalahan dan arahkan kembali ke halaman login
                    $sessError = [
                        'errPassword' => 'Password Anda Salah'
                    ];
                    session()->setFlashdata($sessError);
                    return redirect()->to(site_url('/login/index'));
                }
            }
        }
    }

    function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
