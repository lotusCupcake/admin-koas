<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKelompokModel extends Model
{
    protected $table = 'kelompok';
    protected $primaryKey = 'kelompokId';
    protected $allowedFields = ['kelompokNama', 'kelompokTahunAkademik'];
    protected $returnType = 'object';

    public function getDataKelompok()
    {
        $builder = $this->db->table('kelompok');
        $builder->select('*,(select count(*) from kelompok_detail where kelompokDetKelompokId = kelompok.kelompokId)as jumlahPartisipan');
<<<<<<< HEAD
        $builder->join('dosen_kelompok', 'dosen_kelompok.dosenKelompokId = kelompok.kelompokDosenKelompokId', 'LEFT');
=======
>>>>>>> 25cbc850fcbc727b15f166aac50d518dc6e2ad77
        $kelompok = $builder->get();
        return $kelompok;
    }
}
