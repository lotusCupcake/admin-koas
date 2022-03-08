<?php

namespace App\Models;

use CodeIgniter\Model;

class PanduanModel extends Model
{
    protected $table = 'panduan';
    protected $primaryKey = 'panduanId';
    protected $allowedFields = ['panduanNama', 'panduanFile', 'panduanStatus', 'panduanCreatedAt', 'panduanUpdatedAt', 'panduanDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';
    protected $useTimestamps = 'true';
    protected $createdField = ' panduanCreatedAt';
    protected $updatedField = ' panduanUpdatedAt';
    protected $deletedField = 'panduanDeletedAt';


    public function updateStatus()
    {
        $builder = $this->db->query('UPDATE panduan SET panduanStatus=0');
        return $builder;
    }
}
