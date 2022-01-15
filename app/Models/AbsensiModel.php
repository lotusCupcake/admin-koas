<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'absensiId';
    protected $allowedFields = ['absensiNim', 'absensiTanggal', 'absensiKeterangan', 'absensiLatLong', 'absensiLokasi'];
    protected $returnType = 'object';

    public function absensiPaginate()
    {
        $builder = $this->table('absensi');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = absensi.absensiNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->orderBy('absensi.absensiId', 'DESC');
        return $builder;
    }

    public function searchAbsensi($keyword)
    {
        $builder = $this->table('absensi');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = absensi.absensiNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('absensi.absensiNim', $keyword);
        $builder->orderBy('absensi.absensiId', 'DESC');
        return $builder;
    }
}
