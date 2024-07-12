<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SendEmail extends BaseController
{
    public function index()
    {
        if ($this->request->getMethod() == 'post') {

            $email_tujuan = $this->request->getVar('email_tujuan');
            $subject = $this->request->getVar('subject');
            $isi_pesan = $this->request->getVar('isi_pesan');

            $email = service('email');
            $email->setTo($email_tujuan);
            $email->setFrom('ahonganakbaik@gmail.com', 'Sekre bos');

            $email->setSubject($subject);
            $email->setMessage($isi_pesan);

            if ($email->send()) {
                //sukses bos
                echo 'email mu sukses bolo';
            }else {
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }
        }
        return view('admin/email');
    }
}
