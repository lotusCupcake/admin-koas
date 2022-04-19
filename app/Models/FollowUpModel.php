<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowUpModel extends Model
{
    protected $table = 'follow_up';
    protected $primaryKey = 'followUpId';
    protected $allowedFields = ['followUpRumkitDetId', 'followUpTahunAkademik', 'followUpDopingEmail', 'followUpNim', 'followUpKasusSOAP', 'followUpTglPeriksa', 'followUpCreateDate', 'followUpVerify'];
    protected $returnType = 'object';

    public function getFollowUp($where = null)
    {
        $builder = $this->table('follow_up');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = follow_up.followUpRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = follow_up.followUpDopingEmail', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = follow_up.followUpNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('one_signal', 'one_signal.oneSignalNpm = kelompok_detail.kelompokDetNim', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailJadwalId = jadwal.jadwalId', 'LEFT');
        $builder->groupBy('follow_up.followUpId');
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
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = follow_up.followUpDopingEmail', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = follow_up.followUpNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('one_signal', 'one_signal.oneSignalNpm = kelompok_detail.kelompokDetNim', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailJadwalId = jadwal.jadwalId', 'LEFT');
        if ($where) {
            $builder->where($where)->like('kelompok_detail.kelompokDetNama', $keyword);
            $builder->orWhere($where)->like('kelompok_detail.kelompokDetNim', $keyword);
            $builder->orWhere($where)->like('stase.staseNama', $keyword);
            $builder->orWhere($where)->like('dosen_pembimbing.dopingNamaLengkap', $keyword);
            $builder->orWhere($where)->like('follow_up.followUpTahunAkademik', $keyword);
        } else {
            $builder->like('kelompok_detail.kelompokDetNim', $keyword);
            $builder->orLike('kelompok_detail.kelompokDetNama', $keyword);
            $builder->orLike('stase.staseNama', $keyword);
            $builder->orLike('rumkit.rumahSakitNama', $keyword);
            $builder->orLike('dosen_pembimbing.dopingNamaLengkap', $keyword);
            $builder->orLike('follow_up.followUpTahunAkademik', $keyword);
        }
        $builder->groupBy('follow_up.followUpId');
        $builder->orderBy('follow_up.followUpId', 'DESC');
        return $builder;
    }

    public function getJumlahFollowUp($where)
    {
        $builder = $this->table('follow_up');
        $builder->selectCount('follow_up.followUpId');
        $builder->join('users', 'users.email = follow_up.followUpDopingEmail', 'LEFT');
        $builder->where($where);
        return $builder;
    }
}
