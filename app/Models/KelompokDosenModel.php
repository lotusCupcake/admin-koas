<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokDosenModel extends Model
{
    protected $table = 'dosen_kelompok';
    protected $primaryKey = 'dosenKelompokId';
    protected $allowedFields = ['dosenKelompokNama'];
    protected $returnType = 'object';
}
