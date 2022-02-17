<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table = 'penilaian';
    protected $returnType = 'object';


    public function getFormNilai($where)
    {
        $builder = $this->table('penilaian');
        $builder->join('penilaian_kriteria', 'penilaian_kriteria.kriteriaPenilaianId = penilaian.penilaianId', 'LEFT');
        $builder->join('penilaian_aspek', 'penilaian_aspek.aspekKriteriaId = penilaian_kriteria.kriteriaId', 'LEFT');
        $builder->join('penilaian_komponen', 'penilaian_komponen.komponenAspekId = penilaian_aspek.aspekId', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function getMenuNilai()
    {
        $builder = $this->table('penilaian');
        $builder->orderBy('penilaianOrder', 'ASC');
        $builder->where(['penilaianActive' => 1]);
        return $builder;
    }
}
