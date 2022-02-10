<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokMahasiswaModel extends Model
{
    protected $table = 'kelompok_detail';
    protected $primaryKey = 'kelompokDetId';
    protected $allowedFields = ['kelompokDetKelompokId', 'kelompokDetNim', 'kelompokDetNama'];
    protected $returnType = 'object';

    public function dataExist($where)
    {
        $builder = $this->db->table('kelompok_detail');
        $builder->select('*');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }

    public function getKelompokMahasiswa()
    {
        $builder = $this->table('kelompok_detail');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->orderBy('kelompok_detail.kelompokDetId', 'DESC');
        return $builder;
    }

    public function getKelompokMahasiswaSearch($keyword)
    {
        $builder = $this->table('kelompok_detail');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orlike('kelompok_detail.kelompokDetNim', $keyword);
        $builder->orlike('kelompok.kelompokTahunAkademik', $keyword);
        $builder->orlike('kelompok.kelompokNama', $keyword);
        $builder->orderBy('kelompok_detail.kelompokDetId', 'DESC');
        return $builder;
    }
}
