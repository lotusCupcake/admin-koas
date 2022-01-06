<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKelompokModel extends Model
{
    protected $table = 'kelompok';
    protected $primaryKey = 'kelompokId';
    protected $allowedFields = ['kelompokNama', 'kelompokDosenKelompokId', 'kelompokTahunAkademik'];
    protected $returnType = 'object';
}
