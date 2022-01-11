<?php

namespace App\Models;

use CodeIgniter\Model;

class PanduanModel extends Model
{
    protected $table = 'panduan';
    protected $primaryKey = 'panduanId';
    protected $allowedFields = ['panduanNama', 'panduanFile', 'panduanStatus'];
    protected $returnType = 'object';
}
