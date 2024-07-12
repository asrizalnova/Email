<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterPimpinan implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // cek login 
        if (session()->get('idlevel') === null) {
            return redirect()->to('/login/index');
        }

        // cek apakah yang login useridlevel 3
        if (session()->get('idlevel') == 3) {
            $uri = $request->getUri()->getPath();
            $restrictedRoutes = [
                'admin/divisi',
                'admin/slider',
                'admin/produk',
                'admin/aktivitas'
            ];

            foreach ($restrictedRoutes as $route) {
                if (strpos($uri, $route) !== false) {
                    return redirect()->to('admin/pimpinan');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // untuk pimpinan tetap di admin/pimpinan
        if (session()->get('idlevel') == 3) {
            $uri = $request->getUri()->getPath();
            $allowedRoutes = [
                'admin/pimpinan',
                'admin/dashboard'
            ];

            $isAllowed = false;
            foreach ($allowedRoutes as $route) {
                if (strpos($uri, $route) !== false) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                return redirect()->to('admin/pimpinan');
            }
        }
    }
}
