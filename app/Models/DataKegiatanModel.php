<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'kegiatanId';
    protected $allowedFields = ['kegiatanNama', 'kegiatanStatus', 'deleted_at'];
    protected $useSoftDeletes = 'true';
    protected $returnType = 'object';

    public function getKegiatan()
    {
        $builder = $this->table('kegiatan');
        $builder->select('*');
        $builder->orderBy('kegiatan.kegiatanId', 'DESC');
        return $builder;
    }

    public function getKegiatanSearch($keyword)
    {
        $builder = $this->table('kegiatan');
        $builder->select('*');
        $builder->orderBy('kegiatan.kegiatanId', 'DESC');
        $builder->like('kegiatan.kegiatanNama', $keyword);
        return $builder;
    }
}
