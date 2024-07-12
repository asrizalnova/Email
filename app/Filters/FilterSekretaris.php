<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterSekretaris implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in and their level
        if (session()->get('idlevel') === null){
            return redirect()->to('/login/index');
        }
        
        // Check if the user is a sekretaris (assuming idlevel 2 is sekretaris)
        if (session()->get('idlevel') == 2) {
            // Redirect away from admin/divisi and admin/pimpinan
            $uri = service('uri');
            if (strpos($uri->getPath(), 'admin/divisi') !== false || strpos($uri->getPath(), 'admin/pimpinan') !== false) {
                return redirect()->to('admin/slider');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
         // untuk pimpinan tetap di admin/pimpinan
         if (session()->get('idlevel') == 2) {
            $uri = $request->getUri()->getPath();
            $allowedRoutes = [
                'admin/slider',
                'admin/produk'
            ];

            $isAllowed = false;
            foreach ($allowedRoutes as $route) {
                if (strpos($uri, $route) !== false) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                return redirect()->to('admin/slider');
            }
        }
    }
}
