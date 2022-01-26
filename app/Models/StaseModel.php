<?php

namespace App\Models;

use CodeIgniter\Model;

class StaseModel extends Model
{
    protected $table = 'stase';
    protected $primaryKey = 'staseId';
    protected $allowedFields = ['staseNama', 'staseJumlahWeek', 'staseType'];
    protected $returnType = 'object';

    public function getStase()
    {
        $builder = $this->table('stase');
        $builder->select('*');
        $builder->orderBy('stase.staseId', 'DESC');
        return $builder;
    }

    public function getStaseSearch($keyword)
    {
        $builder = $this->table('stase');
        $builder->select('*');
        $builder->orderBy('stase.staseId', 'DESC');
        $builder->like('stase.staseNama', $keyword);
        return $builder;
    }
}
