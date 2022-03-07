<?php

namespace App\Models;

use CodeIgniter\Model;

class DataRumahSakitModel extends Model
{
    protected $table = 'rumkit';
    protected $primaryKey = 'rumahSakitId';
    protected $allowedFields = ['rumahSakitNama', 'rumahSakitShortname', 'rumahSakitAlamat', 'rumahSakitTelp', 'rumahSakitLatLong', 'rumahSakitWarna', 'rumahSakitEmail', 'rumahSakitId', 'deleted_at'];
    protected $useSoftDeletes = 'true';
    protected $returnType = 'object';

    public function getSpecificRs($where)
    {
        $builder = $this->table('rumkit');
        $builder->where($where);
        $query = $builder;
        return $query;
    }
}
