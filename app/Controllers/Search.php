<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SliderModel;

class Search extends BaseController
{
    private $sliderModel;

    public function __construct()
    {
        $this->sliderModel = new SliderModel();
    }

    public function index()
    {
        // Code to display the admin home page
        return view('home/index'); // Example view being used
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $data['results'] = $this->sliderModel->searchSurat($keyword);
        $data['keyword'] = $keyword;

        return view('home/result', $data);
    }
}
