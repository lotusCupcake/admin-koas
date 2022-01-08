<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailKelompokDosenModel extends Model
{
    protected $table = 'dosen_kelompok_detail';
    protected $primaryKey = 'detKelompokDosenId';
    protected $allowedFields = ['detKelompokDosenKelompokId', 'detKelompokDopingId'];
    protected $returnType = 'object';

    public function getDetailDosen()
    {
        $builder = $this->db->table('dosen_kelompok_detail');
        $builder->select('*');
        $builder->join('dosen_kelompok', 'dosen_kelompok.dosenKelompokId = dosen_kelompok_detail.detKelompokDosenKelompokId');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingId  = dosen_kelompok_detail.detKelompokDopingId');
        $query = $builder->get();
        return $query;
    }
}
