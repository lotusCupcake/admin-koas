<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'absensiId';
    protected $allowedFields = ['absensiNim', 'absensiTahunAkademik', 'absensiTanggal', 'absensiKeterangan', 'absensiLatLong', 'absensiLokasi'];
    protected $returnType = 'object';

    public function absensiPaginate()
    {
        $builder = $this->table('absensi');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = absensi.absensiNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->orderBy('absensi.absensiId', 'DESC');
        return $builder;
    }

    public function searchAbsensi($keyword)
    {
        $builder = $this->table('absensi');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = absensi.absensiNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('absensi.absensiTahunAkademik', $keyword);
        $builder->orLike('absensi.absensiNim', $keyword);
        $builder->orLike('absensi.absensiKeterangan', $keyword);
        $builder->orderBy('absensi.absensiId', 'DESC');
        return $builder;
    }

    public function getAbsensiKoordik($where)
    {
        $builder = $this->table('absensi');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = absensi.absensiNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', ' rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', ' stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where(
            [
                'rumkit.rumahSakitId' => $where,
            ]
        );
        $builder->groupBy('jadwal.jadwalId');
        $builder->orderBy('absensi.absensiId', 'DESC');
        return $builder;
    }

    public function getAbsensiKoordikSearch($keyword, $where)
    {
        $builder = $this->table('absensi');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = absensi.absensiNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', ' rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', ' stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('absensi.absensiTahunAkademik', $keyword);
        $builder->orLike('absensi.absensiNim', $keyword);
        $builder->orLike('absensi.absensiKeterangan', $keyword);
        $builder->orderBy('absensi.absensiId', 'DESC');
        $builder->where(
            [
                'rumkit.rumahSakitId' => $where,
            ]
        );
        $builder->groupBy('jadwal.jadwalId');
        $builder->orderBy('absensi.absensiId', 'DESC');
        return $builder;
    }
}
