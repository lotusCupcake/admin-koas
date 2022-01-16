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
        $builder = $this->join('kelompok', 'kelompok.kelompokId = ' . $this->table . '.kelompokDetKelompokId', 'LEFT');
        $builder->table($this->table);
        $builder->orderBy('' . $this->table . '.kelompokDetId', 'DESC');
        return $builder;
    }

    public function getKelompokMahasiswaSearch($keyword)
    {
        $builder = $this->join('kelompok', 'kelompok.kelompokId = ' . $this->table . '.kelompokDetKelompokId', 'LEFT');
        $builder->table($this->table);
        $builder->like('' . $this->table . '.kelompokDetNama', $keyword);
        $builder->orlike('' . $this->table . '.kelompokDetNim', $keyword);
        $builder->orlike('kelompok.kelompokTahunAkademik', $keyword);
        $builder->orlike('kelompok.kelompokNama', $keyword);
        $builder->orderBy('' . $this->table . '.kelompokDetId', 'DESC');
        return $builder;
    }
}
