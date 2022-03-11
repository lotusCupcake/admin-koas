<?php

namespace App\Models;

use CodeIgniter\Model;

class GradeModel extends Model
{
    protected $table = 'penilaian_grade';
    protected $primaryKey = 'gradeId';
    protected $allowedFields = ['gradeStaseId', 'gradeTahunAkademik', 'gradePenilaianId', 'gradeNpm', 'gradeNilai', 'gradeCreatedBy', 'gradeCreatedAt', 'gradeApproveStatus', 'gradeApproveBy', 'gradeTahunAkademik'];
    protected $returnType = 'object';

    public function getPenilaianVerifikasi($where)
    {
        $builder = $this->table('penilaian_grade');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = penilaian_grade.gradeCreatedBy', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->where($where);
        return $builder;
    }
}
