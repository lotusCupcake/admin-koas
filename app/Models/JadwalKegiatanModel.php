<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalKegiatanModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'jadwalId';
    protected $allowedFields = ['jadwalRumahSakitId', 'jadwalBagianId', 'jadwalTanggalMulai', 'jadwalTanggalSelesai', 'jadwalDurasi'];
    protected $returnType = 'object';

    public function Show_Data_Stase($rumahSakitId)
    {
        $builder = $this->db->table('rumkit_detail');
        $builder->select('*');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where('rumkit_detail.rumkitDetRumkitId', $rumahSakitId);
        $builder->where('rumkit_detail.rumkitDetStatus', 1);
        $staseRumkit = $builder->get();
        return $staseRumkit;
    }
}
