<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailKelompokDosenModel extends Model
{
    protected $table = 'dosen_kelompok_detail';
    protected $primaryKey = 'detKelompokDosenId';
    protected $allowedFields = ['detKelompokDosenKelompokId', 'detKelompokDopingId'];
    protected $returnType = 'object';
}
