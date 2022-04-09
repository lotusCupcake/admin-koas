<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKelompokModel extends Model
{
    protected $table = 'kelompok';
    protected $primaryKey = 'kelompokId';
    protected $allowedFields = ['kelompokNama', 'kelompokTahunAkademik', 'kelompokCreatedAt', 'kelompokUpdatedAt', 'kelompokDeletedAt'];
    protected $returnType = 'object';
    protected $useTimestamps = 'true';
    protected $useSoftDeletes = 'true';
    protected $createdField = 'kelompokCreatedAt';
    protected $updatedField = 'kelompokUpdatedAt';
    protected $deletedField = 'kelompokDeletedAt';


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
        $builder->like('kelompok.kelompokNama', $keyword)->where('kelompok.kelompokDeletedAt', null);
        $builder->orlike('kelompok.kelompokTahunAkademik', $keyword)->where('kelompok.kelompokDeletedAt', null);
        $builder->orderBy('kelompok.kelompokId', 'DESC');
        return $builder;
    }
}
