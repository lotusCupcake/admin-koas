<?php

namespace App\Models;

use CodeIgniter\Model;

class BobotModel extends Model
{
    protected $table = 'setting_bobot';
    protected $primaryKey = 'settingBobotId';
    protected $allowedFields = ['settingBobotStaseId', 'serttingBobotKomposisiNilai'];
    protected $returnType = 'object';

    public function getBobot()
    {
        $builder = $this->table('setting_bobot');
        $builder->join('stase', 'stase.staseId = setting_bobot.settingBobotStaseId', 'LEFT');
        $builder->orderBy('setting_bobot.settingBobotId', 'DESC');
        return $builder;
    }

    public function getBobotSearch($keyword)
    {
        $builder = $this->table('setting_bobot');
        $builder->join('stase', 'stase.staseId = setting_bobot.settingBobotStaseId', 'LEFT');
        $builder->orderBy('setting_bobot.settingBobotId', 'DESC');
        $builder->like('stase.staseNama', $keyword);
        return $builder;
    }
}
