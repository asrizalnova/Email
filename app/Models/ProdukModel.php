<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    // protected $table = 'tbl_suratMasuk';
    // protected $primaryKey = 'id_SM';
    // protected $returnType = 'object';
    // protected $allowedFields = ['instansi_pengirim', 'ditujukan', 'surat', 'waktu'];

    protected $table = 'tbl_suratKeluar';
    protected $primaryKey = 'id_SK';
    protected $returnType = 'object';
    protected $allowedFields = ['instansi_ditujukan', 'keperluan', 'status', 'surat_keluar', 'waktu'];

}
