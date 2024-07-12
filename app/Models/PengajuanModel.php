<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table = 'tbl_pengajuan';
    protected $primaryKey = 'id_req';
    protected $returnType = 'object';
    protected $allowedFields = ['instansi_pengirim', 'keperluan', 'status', 'surat', 'waktu', 'code','komentar'];




}
