<?php

namespace App\Models;

use CodeIgniter\Model;

class PopupModel extends Model
{
    protected $table = 'popup';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email'];
    protected $returnType = 'object';
}
