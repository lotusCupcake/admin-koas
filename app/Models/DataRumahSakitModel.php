<?php

namespace App\Models;

use CodeIgniter\Model;

class DataRumahSakitModel extends Model
{
    protected $table = 'rumkit';
    protected $primaryKey = 'rumahSakitId';
    protected $allowedFields = ['rumahSakitNama', 'rumahSakitAlamat', 'rumahSakitTelp', 'rumahSakitLatLong'];
    protected $returnType = 'object';
}
