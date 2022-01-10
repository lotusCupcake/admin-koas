<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenPembimbingModel extends Model
{
    protected $table = 'dosen_pembimbing';
    protected $primaryKey = 'dopingId';
    protected $allowedFields = ['dopingNamaLengkap', 'dopingEmail', 'dopingNoHandphone', 'dopingAlamat'];
    protected $returnType = 'object';
}
