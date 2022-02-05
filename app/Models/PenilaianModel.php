<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table = 'penilaian';
    // protected $primaryKey = 'staseId';
    // protected $allowedFields = ['staseNama', 'staseJumlahWeek', 'staseType'];
    protected $returnType = 'object';


    public function getFormJurnalReading()
    {
        $builder = $this->table('penilaian');
        $builder->join('kriteria_penilaian', 'kriteria_penilaian.kriteriaPenilaianId = penilaian.penilaianId', 'LEFT');
        $builder->join('kemampuan_penilaian', 'kemampuan_penilaian.kemampuanKriteriaId = kriteria_penilaian.kriteriaId', 'LEFT');
        $builder->join('komponen_penilaian', 'komponen_penilaian.komponenNilaiKemampuanId = kemampuan_penilaian.kemampuanNilaiId', 'LEFT');
        $builder->where(['penilaian.penilaianId' => 1]);
        return $builder;
    }

    public function getFormJurnalRefarat()
    {
        $builder = $this->table('penilaian');
        $builder->join('kriteria_penilaian', 'kriteria_penilaian.kriteriaPenilaianId = penilaian.penilaianId', 'LEFT');
        $builder->join('kemampuan_penilaian', 'kemampuan_penilaian.kemampuanKriteriaId = kriteria_penilaian.kriteriaId', 'LEFT');
        $builder->join('komponen_penilaian', 'komponen_penilaian.komponenNilaiKemampuanId = kemampuan_penilaian.kemampuanNilaiId', 'LEFT');
        $builder->where(['penilaian.penilaianId' => 2]);
        return $builder;
    }

    public function getFormJurnalRefleksiKasus()
    {
        $builder = $this->table('penilaian');
        $builder->join('kriteria_penilaian', 'kriteria_penilaian.kriteriaPenilaianId = penilaian.penilaianId', 'LEFT');
        $builder->join('kemampuan_penilaian', 'kemampuan_penilaian.kemampuanKriteriaId = kriteria_penilaian.kriteriaId', 'LEFT');
        $builder->join('komponen_penilaian', 'komponen_penilaian.komponenNilaiKemampuanId = kemampuan_penilaian.kemampuanNilaiId', 'LEFT');
        $builder->where(['penilaian.penilaianId' => 3]);
        return $builder;
    }
}
