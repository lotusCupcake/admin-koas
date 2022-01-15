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
        // $builder = $this->db->query('CALL FollowUp_List');
        $builder = $this->table('follow_up');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = follow_up.followUpRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = follow_up.followUpDopingId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = follow_up.followUpNim', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        return $builder;
    }

    public function getFollowUpSearch($keyword)
    {
        // $builder = $this->db->query('CALL FollowUp_List');
        $builder = $this->table('follow_up');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = follow_up.followUpRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = follow_up.followUpDopingId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = follow_up.followUpNim', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('kelompok_detail.kelompokDetNim', $keyword);
        $builder->orderBy('follow_up.followUpId', 'DESC');
        return $builder;
    }
}
