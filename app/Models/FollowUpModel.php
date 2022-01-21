<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowUpModel extends Model
{
    protected $table = 'follow_up';
    protected $primaryKey = 'followUpId';
    protected $allowedFields = ['followUpRumkitDetId', 'followUpDopingId', 'followUpNim', 'followUpKasusSOAP', 'followUpTglPeriksa', 'followUpCreateDate', 'followUpVerify'];
    protected $returnType = 'object';

    public function getFollowUp($where = null)
    {
        $builder = $this->table('follow_up');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = follow_up.followUpRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = follow_up.followUpDopingId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = follow_up.followUpNim', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->orderBy('follow_up.followUpId', 'DESC');
        if ($where) {
            $builder->where($where);
        }
        return $builder;
    }

    public function getFollowUpSearch($keyword, $where = null)
    {
        $builder = $this->table('follow_up');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = follow_up.followUpRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = follow_up.followUpDopingId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = follow_up.followUpNim', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('kelompok_detail.kelompokDetNim', $keyword);
        $builder->orLike('rumkit.rumahSakitNama', $keyword);
        $builder->orLike('stase.staseNama', $keyword);
        $builder->orLike('dosen_pembimbing.dopingNamaLengkap', $keyword);
        $builder->orderBy('follow_up.followUpId', 'DESC');
        if ($where) {
            $builder->where($where);
        }
        return $builder;
    }
}
