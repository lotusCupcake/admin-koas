<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenPembimbingModel extends Model
{
    protected $table = 'dosen_pembimbing';
    protected $primaryKey = 'doping_id';
    protected $allowedFields = ['dopingNIDN', 'dopingNamaLengkap', 'dopingEmail', 'dopingNoHandphone', 'dopingAlamat', 'dopingStaseId'];
    protected $returnType = 'object';
}
