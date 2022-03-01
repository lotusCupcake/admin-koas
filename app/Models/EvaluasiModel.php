<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluasiModel extends Model
{
    protected $table = 'evaluasi_grade';
    protected $primaryKey = 'gradeId';
    protected $allowedFields = ['gradeEvaluasiNpm', 'gradeEvaluasiDopingEmail', 'gradeEvaluasiNilai'];
    protected $returnType = 'object';

    public function getFilterEvaluasi()
    {
        $builder = $this->table('evaluasi_grade');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = evaluasi_grade.gradeEvaluasiNpm', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = evaluasi_grade.gradeEvaluasiDopingEmail', 'LEFT');
        $builder->groupBy('kelompok_detail.kelompokDetNim');
        return $builder->get();
    }
}
