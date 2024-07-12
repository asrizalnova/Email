<?php

namespace App\Models;

use CodeIgniter\Model;

class PimpinanModel extends Model
{
    protected $table = 'pimpinan';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['instansi_ditujukan', 'keterangan', 'status', 'waktu', 'file', 'signature','komentar', 'tanggapan'];
}


