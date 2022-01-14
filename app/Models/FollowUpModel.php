<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowUpModel extends Model
{
    protected $table = 'follow_up';
    protected $primaryKey = 'followUpId';
    protected $allowedFields = ['followUpRumkitDetId', 'followUpDopingId', 'followUpNim', 'followUpKasusSOAP', 'followUpTglPeriksa', 'followUpCreateDate', 'followUpVerify'];
    protected $returnType = 'object';

    public function getFollowUp()
    {
        $builder = $this->db->query('CALL FollowUp_List');
        return $builder;
    }
}
