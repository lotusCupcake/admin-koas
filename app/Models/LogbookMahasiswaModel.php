<?php

namespace App\Models;

use CodeIgniter\Model;

class LogbookMahasiswaModel extends Model
{
    protected $table = 'logbook';
    protected $primaryKey = 'logbookId';
    protected $allowedFields = ['logbookRumkitDetId', 'logbookDopingEmail', 'logbookNim', 'logbookTanggal', 'logbookCreateDate', 'logbookKegiatanId', 'logbookJudulDeskripsi', 'logbookDeskripsi', 'logbookIsVerify'];
    protected $returnType = 'object';

    public function getLogbook($where = null)
    {
        $builder = $this->table('logbook');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->orderBy('logbook.logbookId', 'DESC');
        if ($where) {
            $builder->where($where);
        }
        return $builder;
    }

    public function getLogbookSearch($keyword, $where = null)
    {
        $builder = $this->table('logbook');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        if ($where) {
            $builder->where($where)->like('kelompok_detail.kelompokDetNim', $keyword);
            $builder->orWhere($where)->like('kelompok_detail.kelompokDetNama', $keyword);
            $builder->orWhere($where)->like('kegiatan.kegiatanNama', $keyword);
        }
        $builder->orderBy('logbook.logbookId', 'DESC');
        return $builder;
    }

    public function getMahasiswaNilai($dosenId)
    {
        $builder = $this->table('logbook');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->where(['dosen_pembimbing.dopingId' => $dosenId]);
        $builder->groupBy(['kelompok_detail.kelompokDetNim', 'stase.staseId']);
        return $builder;
    }
}
