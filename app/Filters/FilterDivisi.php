<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterDivisi implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('idlevel') === null){
            return redirect()->to('/login/index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->get('idlevel') == 4 || session()->get('idlevel') == 5 || session()->get('idlevel') == 6){
            return redirect()->to('admin/divisi/awal');
        }
    }
}
