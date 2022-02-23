<?php

namespace App\Models;

use CodeIgniter\Model;

class BobotModel extends Model
{
    protected $table = 'setting_bobot';
    protected $primaryKey = 'settingBobotId';
    protected $allowedFields = ['settingBobotStaseId', 'settingBobotKomposisiNilai', 'settingBobotStatus'];
    protected $returnType = 'object';
}
