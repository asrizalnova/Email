<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table = 'tbl_suratmasuk';
    protected $primaryKey = 'id_SM';
    protected $returnType = 'object';
    protected $allowedFields = ['instansi_pengirim', 'keperluan', 'status', 'surat', 'waktu', 'code','komentar'];

    public function searchSurat($keyword)
{
    $this->db->query("SET sql_mode = ''");
    return $this->where('code', $keyword)->findAll();
}


}
