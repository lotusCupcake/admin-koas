<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaAcaraModel extends Model
{
    protected $table = 'logbook';
    public function getStase()
    {
        $builder = $this->table('logbook');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where(['logbook.logbookDopingEmail' => user()->email, 'logbook.logbookIsVerify' => 1]);
        $builder->groupBy(['stase.staseId']);
        return $builder;
    }

    public function getKegiatanMhs($staseBeritaAcara)
    {
        $builder = $this->table('logbook');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->where(['logbook.logbookDopingEmail' => user()->email, 'kegiatan.kegiatanBeritaAcara' => 1, 'logbook.logbookIsVerify' => 1, 'logbook.logbookRumkitDetId' => $staseBeritaAcara]);
        $builder->groupBy(['stase.staseId']);
        $kegiatanBerita = $builder->get();
        return $kegiatanBerita;
    }

    public function getKelompokBerita($staseBeritaAcara, $kegiatanId)
    {
        $builder = $this->table('logbook');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->where(['logbook.logbookDopingEmail' => user()->email, 'logbook.logbookIsVerify' => 1, 'logbook.logbookRumkitDetId' => $staseBeritaAcara, 'logbook.logbookKegiatanId' => $kegiatanId]);
        $builder->groupBy(['stase.staseId']);
        $kelompokBerita = $builder->get();
        return $kelompokBerita;
    }

    public function getCetakBerita($paramsCetak)
    {
        $builder = $this->table('logbook');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->where($paramsCetak);
        $builder->groupBy(['stase.staseId']);
        $kelompokBerita = $builder->get();
        return $kelompokBerita;
    }
}
