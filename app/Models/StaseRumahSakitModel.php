<?php

namespace App\Models;

use CodeIgniter\Model;

class StaseRumahSakitModel extends Model
{
    protected $table = 'rumkit_detail';
    protected $primaryKey = 'rumkitDetId';
    protected $allowedFields = ['rumkitDetRumkitId', 'rumkitDetStaseId', 'rumkitDetStatus'];
    protected $returnType = 'object';

    public function getStaseRs()
    {
        $builder = $this->db->table('rumkit_detail');
        $builder->select('*');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $joinStaseRS = $builder->get();
        return $joinStaseRS;
    }
}
