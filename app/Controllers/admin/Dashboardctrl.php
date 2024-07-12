<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\ProfilModel;
use App\Models\SliderModel;

class Dashboardctrl extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); // Ubah 'login' sesuai dengan halaman login kamu
        }
        $produkModel = new ProdukModel();
        $aktivitasModel = new ProfilModel();
        $sliderModel = new SliderModel();

        $data['productCount'] = $produkModel->countAll();
        $data['aktivitasCount'] = $aktivitasModel->countAll();
        $data['sliderCount'] = $sliderModel->countAll();

        return view('admin/dashboard/index', $data);
    }
}