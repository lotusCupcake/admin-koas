<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKelompokModel extends Model
{
    protected $table = 'kelompok';
    protected $primaryKey = 'kelompokId';
    protected $allowedFields = ['kelompokNama', 'kelompokTahunAkademik', 'deleted_at'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';


    public function getDataKelompok()
    {
        $builder = $this->table('kelompok');
        $builder->select('kelompok.*,(select count(*) from kelompok_detail where kelompokDetKelompokId = kelompok.kelompokId) as jumlahPartisipan');
        $builder->orderBy('kelompok.kelompokId', 'DESC');
        return $builder;
    }

    public function getDataKelompokSearch($keyword)
    {
        $builder = $this->table('kelompok');
        $builder->select('kelompok.*,(select count(*) from kelompok_detail where kelompokDetKelompokId = kelompok.kelompokId) as jumlahPartisipan');
        $builder->like('kelompok.kelompokNama', $keyword);
        $builder->orlike('kelompok.kelompokTahunAkademik', $keyword);
        $builder->orderBy('kelompok.kelompokId', 'DESC');
        return $builder;
    }
}
