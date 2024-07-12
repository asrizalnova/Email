<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table = "tbl_user";
    protected $primaryKey = "id_user";

    protected $allowedFields = [
        'id_user', 'username', 'password', 'useridlevel'
    ];

   
}
