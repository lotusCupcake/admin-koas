<?php

namespace App\Models;

use CodeIgniter\Model;

class StaseModel extends Model
{
    protected $table = 'stase';
    protected $primaryKey = 'staseId';
    protected $allowedFields = ['staseNama', 'staseJumlahWeek', 'staseCreatedAt', 'staseUpdatedAt', 'staseDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';
    protected $useTimestamps = 'true';
    protected $createdField = 'staseCreatedAt';
    protected $updatedField = 'staseUpdatedAt';
    protected $deletedField = 'staseDeletedAt';




    public function getStase($fil = null)
    {
        ($fil != null) ? $fil = $fil : $fil = 'DESC';

        $builder = $this->table('stase');
        $builder->select('*');
        $builder->orderBy('stase.staseId', $fil);
        return $builder;
    }

    public function getStaseSearch($keyword, $fil = null)
    {
        ($fil != null) ? $fil = $fil : $fil = 'DESC';
        $builder = $this->table('stase');
        $builder->select('*');
        $builder->orderBy('stase.staseId', $fil);
        $builder->like('stase.staseNama', $keyword);
        return $builder;
    }
}
