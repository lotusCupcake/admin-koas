<?php

namespace App\Models;

use CodeIgniter\Model;

class GradeModel extends Model
{
    protected $table = 'penilaian_grade';
    protected $primaryKey = 'gradeId';
    protected $allowedFields = ['gradeStaseId', 'gradePenilaianId', 'gradeNpm', 'gradeNilai', 'gradeCreatedBy', 'gradeCreatedAt', 'gradeApproveStatus', 'gradeApproveBy'];
    protected $returnType = 'object';
}
