<?php

namespace App\Models;

use CodeIgniter\Model;

class DataRumahSakitModel extends Model
{
    protected $table = 'rumkit';
    protected $primaryKey = 'rumahSakitId';
    protected $allowedFields = ['rumahSakitNama', 'rumahSakitShortname', 'rumahSakitAlamat', 'rumahSakitTelp', 'rumahSakitLatLong', 'rumahSakitWarna', 'rumahSakitEmail', 'rumahSakitId', 'rumahSakitCreatedAt', 'rumahSakitUpdatedAt', 'rumahSakitDeletedAt'];
    protected $useSoftDeletes = 'true';
    protected $useTimestamps = 'true';
    protected $createdField = 'rumahSakitCreatedAt';
    protected $updatedField = 'rumahSakitUpdatedAt';
    protected $deletedField = 'rumahSakitDeletedAt';
    protected $returnType = 'object';

    public function getSpecificRs($where)
    {
        $builder = $this->table('rumkit');
        $builder->where($where);
        $query = $builder;
        return $query;
    }
}
