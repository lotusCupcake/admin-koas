<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table = 'penilaian';
    protected $returnType = 'object';

    public function getPenilaian()
    {
        $builder = $this->table('penilaian');
        $builder->orderBy('penilaianOrder', 'ASC');
        $builder->whereNotIn('penilaianId', [8, 10, 15, 9, 12]);
        return $builder;
    }

    public function getFormNilai($where)
    {
        $builder = $this->table('penilaian');
        $builder->join('penilaian_kriteria', 'penilaian_kriteria.kriteriaPenilaianId = penilaian.penilaianId', 'LEFT');
        $builder->join('penilaian_aspek', 'penilaian_aspek.aspekKriteriaId = penilaian_kriteria.kriteriaId', 'LEFT');
        $builder->join('penilaian_komponen', 'penilaian_komponen.komponenAspekId = penilaian_aspek.aspekId', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function getMenuNilai($where)
    {
        $builder = $this->table('penilaian');
        $builder->join('kegiatan', 'kegiatan.kegiatanPenilaianId = penilaian.penilaianId', 'LEFT');
        $builder->join('logbook', 'logbook.logbookKegiatanId = kegiatan.kegiatanId', 'LEFT');
        $builder->where($where);
        $builder->groupBy('penilaian.penilaianId ');
        $builder->orderBy('penilaian.penilaianOrder', 'ASC');
        return $builder;
    }

    public function getFilterNilai($where)
    {
        $builder = $this->db->table('jadwal');
        $builder->join('kelompok', 'kelompok.kelompokId = jadwal.jadwalKelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId =rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->where($where);
        $builder->groupBy(['stase.staseId', 'kelompok_detail.kelompokDetNim']);
        return $builder->get();
    }
}
