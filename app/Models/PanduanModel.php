<?php

namespace App\Models;

use CodeIgniter\Model;

class PanduanModel extends Model
{
    protected $table = 'panduan';
    protected $primaryKey = 'panduanId';
    protected $allowedFields = ['panduanNama', 'panduanFile', 'panduanStatus', 'deleted_at'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';


    public function updateStatus()
    {
        $builder = $this->db->query('UPDATE panduan SET panduanStatus=0');
        return $builder;
    }
}
