<?php

namespace App\Models;

use CodeIgniter\Model;

class GradeGrModel extends Model
{
    protected $table = 'penilaian_gr';
    protected $primaryKey = 'grId';
    protected $allowedFields = ['grStaseId', 'grPenilaianId', 'grNpm', 'grResult', 'grCreatedBy', 'grCreatedAt', 'grApproveStatus', 'grApproveBy'];
    protected $returnType = 'object';
}
