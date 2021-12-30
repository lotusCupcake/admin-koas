<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalKegiatanModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'jadwalId';
    protected $allowedFields = ['jadwalRumahSakitId', 'jadwalBagianId', 'jadwalTanggalMulai', 'jadwalTanggalSelesai', 'jadwalDurasi'];
    protected $returnType = 'object';
}
