<?php

namespace App\Models;

use CodeIgniter\Model;

class DivisiTigaModel extends Model
{
    protected $table = 'tbl_divisi03';
    protected $primaryKey = 'id_divisi03';
    protected $returnType = 'object';
    protected $allowedFields = ['instansi_pengirim','keperluan','status','surat','waktu','code'];
}