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
        $builder = $this->db->table('jadwal_detail');
        $builder->where($where);
        $result = $builder->get();
        return $result;
    }

    public function getJadwalSkip()
    {
        $builder = $this->table('jadwal_skip');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailId = jadwal_skip.skipJadwalDetailId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalId = jadwal_detail.jadwalDetailJadwalId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = jadwal_skip.skipNpm', 'LEFT');
        $builder->orderBy('jadwal_skip.skipId', 'DESC');
        return $builder;
    }

    public function getJadwalSkipSearch($keyword)
    {
        $builder = $this->table('jadwal_skip');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailId = jadwal_skip.skipJadwalDetailId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalId = jadwal_detail.jadwalDetailJadwalId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = jadwal_skip.skipNpm', 'LEFT');
        $builder->orderBy('jadwal_skip.skipId', 'DESC');
        $builder->like('jadwal_detail.jadwalDetailNpm', $keyword);
        $builder->like('jadwal_skip.skipNpm', $keyword);
        $builder->like('jadwal_skip.skipAlasan', $keyword);
        return $builder;
    }
}
