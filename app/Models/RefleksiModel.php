<?php

namespace App\Models;

use CodeIgniter\Model;

class RefleksiModel extends Model
{
    protected $table = 'refleksi_grade';
    protected $primaryKey = 'gradeId';
    protected $allowedFields = ['gradeRefleksiNpm', 'gradeRefleksiKompetensiId', 'gradeNilai'];
    protected $returnType = 'object';
}
