<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalSKipModel extends Model
{
    protected $table = 'jadwal_skip';
    protected $primaryKey = 'skipId';
    protected $allowedFields = ['skipNpm', 'skipJadwalDetailId', 'skipTanggalAwal', 'skipTanggalAkhir', 'skipAlasan', 'skipHariKe', 'skipSisaHari', 'skipTanggalAktifKembali'];
    protected $returnType = 'object';

    public function getJadwalTanggal($where)
    {
        $builder = $this->table('jadwal_skip');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailId = jadwal_skip.skipJadwalDetailId');
        $builder->where($where);
        $result = $builder->get();
        return $result;
    }
}
