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
        $builder = $this->join('rumkit_detail', 'rumkit_detail.rumkitDetId = ' . $this->table . '.followUpRumkitDetId', 'LEFT');
        $builder = $this->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = ' . $this->table . '.followUpDopingId', 'LEFT');
        $builder = $this->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = ' . $this->table . '.followUpNim', 'LEFT');
        $builder = $this->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder = $this->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->table($this->table);
        return $builder;
    }

    public function getFollowUpSearch($keyword)
    {
        // $builder = $this->db->query('CALL FollowUp_List');
        $builder = $this->join('rumkit_detail', 'rumkit_detail.rumkitDetId = ' . $this->table . '.followUpRumkitDetId', 'LEFT');
        $builder = $this->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = ' . $this->table . '.followUpDopingId', 'LEFT');
        $builder = $this->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = ' . $this->table . '.followUpNim', 'LEFT');
        $builder = $this->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder = $this->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->table($this->table);
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('kelompok_detail.kelompokDetNim', $keyword);
        $builder->orLike('rumkit.rumahSakitNama', $keyword);
        $builder->orLike('stase.staseNama', $keyword);
        $builder->orLike('dosen_pembimbing.dopingNamaLengkap', $keyword);
        $builder->orderBy('' . $this->table . '.followUpId', 'DESC');
        return $builder;
    }
}
