<?php

namespace App\Models;

use CodeIgniter\Model;

class DataBagianModel extends Model
{
    protected $table = 'bagian';
    protected $primaryKey = 'bagianId';
    protected $allowedFields = ['bagianNama'];
    protected $returnType = 'object';
}
