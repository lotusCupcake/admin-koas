<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnounceModel extends Model
{
    protected $table = 'pengumuman';
    protected $primaryKey = 'pengumumanId';
    protected $allowedFields = ['pengumumanJudul', 'pengumumanIsi', 'pengumumanTanggalMulai', 'pengumumanTanggalAkhir', 'pengumumanIsForceToShow'];
    protected $returnType = 'object';
}
