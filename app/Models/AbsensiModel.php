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
        $builder = $this->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = ' . $this->table . '.absensiNim', 'LEFT');
        $builder = $this->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->table($this->table);
        $builder->orderBy('' . $this->table . '.absensiId', 'DESC');
        return $builder;
    }

    public function searchAbsensi($keyword)
    {
        $builder = $this->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = ' . $this->table . '.absensiNim', 'LEFT');
        $builder = $this->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->table($this->table);
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('' . $this->table . '.absensiNim', $keyword);
        $builder->orderBy('' . $this->table . '.absensiId', 'DESC');
        return $builder;
    }
}
