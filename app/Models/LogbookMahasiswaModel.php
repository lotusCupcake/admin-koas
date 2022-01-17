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
        $builder = $this->join('rumkit_detail', 'rumkit_detail.rumkitDetId = ' . $this->table . '.logbookRumkitDetId', 'LEFT');
        $builder = $this->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = ' . $this->table . '.logbookDopingId', 'LEFT');
        $builder = $this->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = ' . $this->table . '.logbookNim', 'LEFT');
        $builder = $this->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder = $this->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder = $this->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder = $this->join('kegiatan', 'kegiatan.kegiatanId = ' . $this->table . '.logbookKegiatanId', 'LEFT');
        $builder->table($this->table);
        $builder->orderBy('' . $this->table . '.logbookId', 'DESC');
        return $builder;
    }

    public function getLogbookSearch($keyword)
    {
        // $builder = $this->db->query('CALL Logbook');
        $builder = $this->join('rumkit_detail', 'rumkit_detail.rumkitDetId = ' . $this->table . '.logbookRumkitDetId', 'LEFT');
        $builder = $this->join('dosen_pembimbing', 'dosen_pembimbing.dopingId = ' . $this->table . '.logbookDopingId', 'LEFT');
        $builder = $this->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = ' . $this->table . '.logbookNim', 'LEFT');
        $builder = $this->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder = $this->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder = $this->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder = $this->join('kegiatan', 'kegiatan.kegiatanId = ' . $this->table . '.logbookKegiatanId', 'LEFT');
        $builder->table($this->table);
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('kelompok_detail.kelompokDetNim', $keyword);
        $builder->orderBy('' . $this->table . '.logbookId', 'DESC');
        return $builder;
    }
}
