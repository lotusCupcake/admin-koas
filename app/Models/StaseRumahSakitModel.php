<?php

namespace App\Models;

use CodeIgniter\Model;

class StaseRumahSakitModel extends Model
{
    protected $table = 'rumkit_detail';
    protected $primaryKey = 'rumkitDetId';
    protected $allowedFields = ['rumkitDetRumkitId', 'rumkitDetStaseId', 'rumkitDetStatus'];
    protected $returnType = 'object';
}
