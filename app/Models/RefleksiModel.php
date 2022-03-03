<?php

namespace App\Models;

use CodeIgniter\Model;

class RefleksiModel extends Model
{
    protected $table = 'refleksi_grade';
    protected $primaryKey = 'gradeRefleksiId';
    protected $allowedFields = ['gradeRefleksiNpm', 'gradeRefleksiKompetensiId', 'gradeRefleksiNilai'];
    protected $returnType = 'object';

    public function getFilterRefleksi()
    {
        $builder = $this->table('refleksi_grade');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = refleksi_grade.gradeRefleksiNpm', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        return $builder->get();
    }

    public function getKompetensiRefleksi($where)
    {
        $builder = $this->db->table('refleksi_kompetensi');
        $builder->join('refleksi_tujuan', 'refleksi_tujuan.tujuanKompetensiId = refleksi_kompetensi.kompetensiId', 'LEFT');
        $builder->where($where);
        return $builder->get();
    }

    public function getKompetensi()
    {
        $builder = $this->db->table('refleksi_kompetensi');
        $builder->join('refleksi_tujuan', 'refleksi_tujuan.tujuanKompetensiId = refleksi_kompetensi.kompetensiId', 'LEFT');
        return $builder->get();
    }
}
