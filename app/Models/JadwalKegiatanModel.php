<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalKegiatanModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'jadwalId';
    // protected $allowedFields = ['jadwalRumkitDetId', 'jadwalKelompokId', 'jadwalJamMasuk', 'jadwalTanggalMulai', 'jadwalTanggalSelesai', 'jadwalJamKeluar'];
    protected $allowedFields = ['jadwalRumkitDetId', 'jadwalKelompokId', 'jadwalJamMasuk', 'jadwalTanggalMulai', 'jadwalTanggalSelesai', 'jadwalJamKeluar', 'jadwalJumlahWeek'];
    protected $returnType = 'object';

    public function show_Jadwal_Kegiatan($where = null)
    {
        $builder  = $this->table('jadwal');
        $builder->join('kelompok', 'kelompok.kelompokId = jadwal.jadwalKelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        if ($where) {
            $builder->where($where);
        }
        $builder->orderBy('jadwal.jadwalId', 'DESC');
        return $builder;
    }

    public function showKelompokDetail()
    {
        return $this->db->query(
            'SELECT kelompok_detail.kelompokDetKelompokId, GROUP_CONCAT(DISTINCT CONCAT( " ", kelompok_detail.kelompokDetNama, " (" ), CONCAT(kelompok_detail.kelompokDetNim,")") ORDER BY kelompok_detail.kelompokDetId ASC ) as kelompokDetKelompokMahasiswa from kelompok_detail GROUP BY kelompok_detail.kelompokDetKelompokId'
        );
    }

    public function show_Jadwal_KegiatanSearch($keyword, $where = null)
    {
        $builder  = $this->table('jadwal');
        $builder->join('kelompok', 'kelompok.kelompokId = jadwal.jadwalKelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        if ($where) {
            $builder->where($where)->like('kelompok.kelompokNama', $keyword);
            $builder->orWhere($where)->like('stase.staseNama', $keyword);
            $builder->orWhere($where)->like('rumkit.rumahSakitNama', $keyword);
        }

        $builder->orderBy('jadwal.jadwalId', 'DESC');
        return $builder;
    }

    public function Show_Data_Stase($rumahSakitId)
    {
        $builder = $this->db->table('rumkit_detail');
        $builder->select('*');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where('rumkit_detail.rumkitDetRumkitId', $rumahSakitId);
        $builder->where('rumkit_detail.rumkitDetStatus', 1);
        $staseRumkit = $builder->get();
        return $staseRumkit;
    }

    public function Show_Jadwal_Kelompok($rumkitDetId)
    {
        $builder = $this->db->table('jadwal');
        $builder->select('*');
        // $builder->join('kelompok', 'kelompok.kelompokId = '.$this->table.'.jadwalKelompokId', 'LEFT');
        // $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = '.$this->table.'.jadwalRumkitDetId', 'LEFT');
        $builder->where('jadwal.jadwalRumkitDetId', $rumkitDetId);

        $jadwalKelompok = $builder->get();
        return $jadwalKelompok;
    }

    public function Show_Kelompok($kelompokId)
    {
        $builder = $this->db->table('kelompok');
        $builder->select('*');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->groupBy('kelompok.kelompokId');
        $kelompok = $builder->get();
        return $kelompok;
    }

    public function Get_Where($table, $where)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($where);
        $rumkitDetail = $builder->get();
        return $rumkitDetail;
    }

    public function getJlhWeek($where)
    {
        $builder = $this->db->table('stase');
        $builder->select('*');
        $builder->where($where);
        $stase = $builder->get();
        return $stase;
    }

    public function getMinMax($type, $where)
    {
        $builder = $this->table('jadwal');
        if ($type === "min") {
            $builder->selectMin('jadwal.jadwalTanggalMulai');
        } else {
            $builder->selectMin('jadwal.jadwalTanggalSelesai');
        }
        $builder->join('kelompok', 'kelompok.kelompokId = jadwal.jadwalKelompokId', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where($where);
        return $builder;
    }
}
