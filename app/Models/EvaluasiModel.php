<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluasiModel extends Model
{
    protected $table = 'evaluasi_grade';
    protected $primaryKey = 'gradeId';
    protected $allowedFields = ['gradeEvaluasiData', 'gradeNilai'];
    protected $returnType = 'object';
}
