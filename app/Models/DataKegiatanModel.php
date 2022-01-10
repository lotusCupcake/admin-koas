<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'kegiatanId';
    protected $allowedFields = ['kegiatanNama', 'kegiatanStatus'];
    protected $returnType = 'object';
}
