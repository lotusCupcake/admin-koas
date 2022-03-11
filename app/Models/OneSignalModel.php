<?php

namespace App\Models;

use CodeIgniter\Model;

class OneSignalModel extends Model
{
    protected $table = 'one_signal';
    protected $primaryKey = 'oneSignalId';
    protected $allowedFields = ['oneSignalNpm', 'oneSignalPlayerId', 'oneSignalIsAktif'];
    protected $returnType = 'object';

    public function getPlayerId($penerima)
    {
        $builder = $this->table('one_signal');
        $builder->whereIn('one_signal.oneSignalNpm', $penerima);
        return $builder->get();
    }

    public function getUserOneSignal()
    {
        $builder = $this->table('one_signal');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim=one_signal.oneSignalNpm', 'left');
        return $builder->get();
    }
}
