<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenPembimbingModel extends Model
{
    protected $table = 'dosen_pembimbing';
    protected $primaryKey = 'dopingId';
    protected $allowedFields = ['dopingNamaLengkap', 'dopingEmail', 'dopingNoHandphone', 'dopingAlamat', 'dopingRumkitId', 'type'];
    protected $returnType = 'object';

    public function getDosenPembimbing($where = null, $keyword = null)
    {
        $builder = $this->table('dosen_pembimbing');
        $builder->select('*');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        if ($where) {
            $builder->where($where);
        }
        if ($keyword) {
            $builder->like('dosen_pembimbing.dopingNamaLengkap', $keyword);
        }
        $query = $builder;
        return $query;
    }

    public function getSpecificDosen($where)
    {
        $builder = $this->table('dosen_pembimbing');
        $builder->where($where);
        $query = $builder;
        return $query;
    }
}
