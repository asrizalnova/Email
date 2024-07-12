<?php

namespace App\Models;

use CodeIgniter\Model;

class AktivitasModel extends Model
{
    // protected $table = 'tbl_suratKeluar';
    // protected $primaryKey = 'id_SK';
    // protected $returnType = 'object';
    // protected $allowedFields = ['instansi_ditunjukan', 'keperluan', 'ditunjukan', 'surat_keluar', 'waktu'];

    // public function getAktivitasById($idAktivitas)
    // {
    //     return $this->where('id_aktivitas', $idAktivitas)->first();
    // }

    protected $table = 'tbl_suratMasuk';
    protected $primaryKey = 'id_SM';
    protected $returnType = 'object';
    protected $allowedFields = ['instansi_pengirim', 'ditujukan', 'surat', 'waktu'];

}
