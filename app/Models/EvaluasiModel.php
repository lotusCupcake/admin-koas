<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluasiModel extends Model
{
    protected $table = 'evaluasi_grade';
    protected $primaryKey = 'gradeEvaluasiId';
    protected $allowedFields = ['gradeEvaluasiNpm', 'gradeEvaluasiDopingEmail', 'gradeEvaluasiNilai', 'gradeEvaluasiStaseId'];
    protected $returnType = 'object';

    public function getFilterEvaluasi($rumahSakitEvaluasi, $staseEvaluasi, $dopingEvaluasi)
    {
        $builder = $this->table('evaluasi_grade');
        $builder->join('stase', 'stase.staseId = evaluasi_grade.gradeEvaluasiStaseId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetStaseId = stase.staseId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = evaluasi_grade.gradeEvaluasiNpm', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = evaluasi_grade.gradeEvaluasiDopingEmail', 'LEFT');
        $builder->where(
            [
                'evaluasi_grade.gradeEvaluasiStaseId' => $staseEvaluasi,
                'evaluasi_grade.gradeEvaluasiDopingEmail' => $dopingEvaluasi,
                'rumkit.rumahSakitId' => $rumahSakitEvaluasi
            ]
        );
        $builder->groupBy('gradeEvaluasiNpm');
        return $builder->get();
    }

    public function getAspekEvaluasi($where)
    {
        $builder = $this->db->table('evaluasi_aspek');
        $builder->where($where);
        return $builder->get();
    }

    public function evaluasiStase($rumahSakitEvaluasi)
    {
        $builder = $this->db->table('jadwal');
        $builder->join('rumkit_detail ', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where(
            [
                'rumkit_detail.rumkitDetRumkitId' => $rumahSakitEvaluasi,
                'rumkit_detail.rumkitDetStatus' => 1
            ]
        );
        $builder->groupBy('stase.staseId');
        $staseRumkit = $builder->get();
        return $staseRumkit;
    }

    public function evaluasiDoping($where)
    {
        $builder = $this->db->table('jadwal');
        $builder->join('rumkit_detail ', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('logbook ', 'logbook.logbookRumkitDetId = rumkit_detail.rumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing ', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where($where);
        $builder->groupBy('logbook.logbookDopingEmail');
        $staseEvaluasi = $builder->get();
        return $staseEvaluasi->getResult();
    }
}
