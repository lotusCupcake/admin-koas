<?php

namespace App\Models;

use CodeIgniter\Model;

class DataRumahSakitModel extends Model
{
    protected $table = 'rumkit';
    protected $primaryKey = 'jadwalId';
    protected $allowedFields = ['jadwalRumahSakitId', 'jadwalBagianId', 'jadwalTanggalMulai', 'jadwalTanggalSelesai', 'jadwalDurasi'];
    protected $returnType = 'object';
}
