<?php

namespace App\Models;

use CodeIgniter\Model;

class DataBagianModel extends Model
{
    protected $table = 'stase';
    protected $primaryKey = 'staseId';
    protected $allowedFields = ['staseNama', 'staseJumlahWeek'];
    protected $returnType = 'object';
}
