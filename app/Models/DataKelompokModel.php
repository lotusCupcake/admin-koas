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
        $builder = $this->select('' . $this->table . '.*,(select count(*) from kelompok_detail where kelompokDetKelompokId = ' . $this->table . '.kelompokId)as jumlahPartisipan');
        $builder->table($this->table);
        $builder->orderBy('' . $this->table . '.kelompokId', 'DESC');
        return $builder;
    }

    public function getDataKelompokSearch($keyword)
    {
        $builder = $this->select('' . $this->table . '.*,(select count(*) from kelompok_detail where kelompokDetKelompokId = ' . $this->table . '.kelompokId)as jumlahPartisipan');
        $builder->table($this->table);
        $builder->like('' . $this->table . '.kelompokNama', $keyword);
        $builder->orlike('' . $this->table . '.kelompokTahunAkademik', $keyword);
        $builder->orderBy('' . $this->table . '.kelompokId', 'DESC');
        return $builder;
    }
}
