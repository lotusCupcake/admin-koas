<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class LapBeritaAcaraModel extends Model
{
    protected $table = 'logbook';
    protected $stase = '';

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

    public function getKegiatanMhs($staseBeritaAcara, $email)
    {
        $builder = $this->table('logbook');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->where(['logbook.logbookDopingEmail' => $email, 'kegiatan.kegiatanBeritaAcara' => 1, 'logbook.logbookIsVerify' => 1, 'logbook.logbookRumkitDetId' => $staseBeritaAcara]);
        $builder->groupBy('stase.staseId');
        $kegiatanBerita = $builder->get();
        return $kegiatanBerita;
    }

    public function getKelompokBerita($stase, $kegiatan, $email)
    {
        $builder = $this->table('logbook');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->where(['logbook.logbookDopingEmail' => $email, 'logbook.logbookIsVerify' => 1, 'logbook.logbookRumkitDetId' => $stase, 'logbook.logbookKegiatanId' => $kegiatan]);
        $builder->groupBy(['stase.staseId']);
        $kelompokBerita = $builder->get();
        return $kelompokBerita;
    }

    public function getCetakBerita($paramsCetak, $staseBeritaAcara)
    {
        $this->stase = $staseBeritaAcara;
        $builder = $this->table('logbook');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->where($paramsCetak);
        $builder->whereNotIn(
            'logbook.logbookNim',
            function (BaseBuilder $subBuilder) {
                $subBuilder->select('jadwal_skip.skipNpm');
                $subBuilder->from('jadwal_skip');
                $subBuilder->join('jadwal_detail', 'jadwal_detail.jadwalDetailId = jadwal_skip.skipJadwalDetailId', 'INNER');
                $subBuilder->join('jadwal', 'jadwal.jadwalId = jadwal_detail.jadwalDetailJadwalId', 'INNER');
                $subBuilder->where(['jadwal.jadwalRumkitDetId' => $this->stase]);
                return $subBuilder;
            }
        );
        $builder->groupBy(['stase.staseId']);
        $kelompokBerita = $builder->get();
        return $kelompokBerita;
    }

    public function getCetakBerita_JadwalSkip($paramsCetak, $staseBeritaAcara)
    {
        $this->stase = $staseBeritaAcara;
        $builder = $this->table('logbook');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = dosen_pembimbing.dopingRumkitId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->where($paramsCetak);
        $builder->whereIn(
            'logbook.logbookNim',
            function (BaseBuilder $subBuilder) {
                $subBuilder->select('jadwal_skip.skipNpm');
                $subBuilder->from('jadwal_skip');
                $subBuilder->join('jadwal_detail', 'jadwal_detail.jadwalDetailId = jadwal_skip.skipJadwalDetailId', 'INNER');
                $subBuilder->join('jadwal', 'jadwal.jadwalId = jadwal_detail.jadwalDetailJadwalId', 'INNER');
                $subBuilder->where(['jadwal.jadwalRumkitDetId' => $this->stase]);
                return $subBuilder;
            }
        );
        $builder->groupBy(['stase.staseId']);
        $kelompokBerita = $builder->get();
        return $kelompokBerita;
    }
}
