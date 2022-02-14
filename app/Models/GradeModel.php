<?php

namespace App\Models;

use CodeIgniter\Model;

class GradeModel extends Model
{
    protected $table = 'penilaian_grade';
    protected $primaryKey = 'gradeId';
    protected $allowedFields = ['gradeRumkitDetId', 'gradePenilaianId', 'gradeNpm', 'gradeKomponenId', 'gradeNilai', 'gradeCreatedBy', 'gradeCreatedAt', 'gradeKeterangan'];
    protected $returnType = 'object';
}
