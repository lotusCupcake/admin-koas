<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenPembimbingModel extends Model
{
    protected $table = 'dosen_pembimbing';
    protected $primaryKey = 'dopingId';
    protected $allowedFields = ['dopingNamaLengkap', 'dopingEmail', 'dopingNoHandphone', 'dopingAlamat', 'dopingRumkitId', 'type'];
    protected $returnType = 'object';

    public function getDosenPembimbing()
    {
        $builder = $this->table('dosen_pembimbing');
        $builder->select('*');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $query = $builder->get();
        return $query;
    }
}
