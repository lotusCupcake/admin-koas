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

    public function show_Jadwal_Kegiatan()
    {
        $builder = $this->db->table('jadwal');
        // $builder->select('DISTINCT (jadwal.jadwalId) AS jadwalId, GROUP_CONCAT( DISTINCT CONCAT( " ", kelompok_detail.kelompokDetNama, " (" ), CONCAT(kelompok_detail.kelompokDetNim,")") ORDER BY kelompok_detail.kelompokDetId ASC ) AS Mahasiswa, rumkit.rumahSakitId, rumkit.rumahSakitNama, rumkit_detail.rumkitDetId, stase.staseNama, date(FROM_UNIXTIME( jadwal.jadwalTanggalMulai / 1000 )) AS jadwalTanggalMulai, date(FROM_UNIXTIME( jadwal.jadwalTanggalSelesai / 1000 )) AS jadwalTanggalSelesai, CONCAT(jadwal.jadwalJamMasuk," - ",jadwal.jadwalJamKeluar," WIB") AS jadwalJam, jadwal.jadwalJamMasuk, jadwal.jadwalJamKeluar, kelompok.kelompokId, kelompok.kelompokNama, stase.staseJumlahWeek');
        $builder->select('DISTINCT jadwal.jadwalId AS jadwalId, GROUP_CONCAT( DISTINCT CONCAT( " ", kelompok_detail.kelompokDetNama, " (" ), CONCAT(kelompok_detail.kelompokDetNim,")") ORDER BY kelompok_detail.kelompokDetId ASC ) AS Mahasiswa, jadwal.*, rumkit_detail.*, rumkit.*, stase.*');
        $builder->join('kelompok', 'kelompok.kelompokId = jadwal.jadwalKelompokId', 'INNER');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $jadwal = $builder->get();
        return $jadwal;
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
        // $builder->join('kelompok', 'kelompok.kelompokId = jadwal.jadwalKelompokId', 'LEFT');
        // $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
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
        // $builder->whereNotIn('kelompok.kelompokId', $kelompokId);
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
}
