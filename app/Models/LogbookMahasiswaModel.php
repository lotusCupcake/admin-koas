<?php

namespace App\Models;

use CodeIgniter\Model;

class LogbookMahasiswaModel extends Model
{
    protected $table = 'logbook';
    protected $primaryKey = 'logbookId';
    protected $allowedFields = ['logbookRumkitDetId', 'logbookDopingId', 'logbookNim', 'logbookTanggal', 'logbookCreateDate', 'logbookKegiatanId', 'logbookJudulDeskripsi', 'logbookDeskripsi', 'logbookIsVerify'];
    protected $returnType = 'object';

    public function getLogbook()
    {
        // $builder = $this->db->query('CALL Logbook');
        $builder = $this->table('logbook');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = logbook.logbookDopingId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->orderBy('logbook.logbookId', 'DESC');
        return $builder;
    }

    public function getLogbookSearch($keyword)
    {
        // $builder = $this->db->query('CALL Logbook');
        $builder = $this->table('logbook');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = logbook.logbookDopingId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('kelompok_detail.kelompokDetNim', $keyword);
        $builder->orderBy('logbook.logbookId', 'DESC');
        return $builder;
    }
}
