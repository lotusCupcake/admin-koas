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

    public function getKelompok()
    {
        $builder = $this->db->table('kelompok_detail');
        $builder->select('*');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId');
        $query = $builder->get();
        return $query;
    }
}
