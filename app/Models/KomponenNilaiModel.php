<?php

namespace App\Models;

use CodeIgniter\Model;

class KomponenNilaiModel extends Model
{
    protected $table = 'penilaian_komponen';
    protected $primaryKey = 'penilaianId';
    protected $allowedFields = ['komponenNama', 'KomponenBobot', 'komponenAspekId', 'komponenSkorMin', 'komponenSkorMax', 'komponenIsNumber'];
    protected $returnType = 'object';
}
