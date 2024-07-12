<?php

namespace App\Models;

use CodeIgniter\Model;

class DivisiUtamaModel extends Model
{
    protected $table = 'tbl_divisi01';
    protected $primaryKey = 'id_divisi01';
    protected $returnType = 'object';
    protected $allowedFields = ['instansi_pengirim','keperluan','status','surat','waktu','code'];
}
