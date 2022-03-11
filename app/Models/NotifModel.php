<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifModel extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'notifId';
    protected $allowedFields = ['notifPenerima', 'notifJudul', 'notifIsi'];
    protected $returnType = 'object';

    public function getNotifikasi()
    {
        $builder = $this->table('notifikasi');
        $builder->orderBy('notifikasi.notifId', 'DESC');
        return $builder;
    }
}
