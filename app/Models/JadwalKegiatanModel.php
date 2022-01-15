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
        $builder = $this->select('DISTINCT (' . $this->table . '.jadwalId) AS jadwalId, rumkit_detail.*, rumkit.*, stase.*, CONCAT(' . $this->table . '.jadwalJamMasuk," - ",' . $this->table . '.jadwalJamKeluar," WIB") AS jadwalJam, kelompok.*, date(FROM_UNIXTIME( ' . $this->table . '.jadwalTanggalMulai / 1000 )) AS jadwalTanggalMulai, date(FROM_UNIXTIME( ' . $this->table . '.jadwalTanggalSelesai / 1000 )) AS jadwalTanggalSelesai,' . $this->table . '.jadwalJumlahWeek,' . $this->table . '.jadwalJamMasuk,' . $this->table . '.jadwalJamKeluar,(select  GROUP_CONCAT( DISTINCT CONCAT( " ", kelompok_detail.kelompokDetNama, " (" ), CONCAT(kelompok_detail.kelompokDetNim,")") ORDER BY kelompok_detail.kelompokDetId ASC )  from kelompok_detail where kelompok_detail.kelompokDetKelompokId=' . $this->table . '.jadwalKelompokId
        GROUP BY kelompok_detail.kelompokDetKelompokId) AS Mahasiswa');
        $builder->table($this->table);
        $builder->join('kelompok', 'kelompok.kelompokId = ' . $this->table . '.jadwalKelompokId', 'INNER');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = ' . $this->table . '.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->orderBy('jadwal.jadwalId', 'DESC');
        return $builder;
    }

    public function show_Jadwal_KegiatanSearch($keyword)
    {
        $builder = $this->select('DISTINCT (' . $this->table . '.jadwalId) AS jadwalId, rumkit_detail.*, rumkit.*, stase.*, CONCAT(' . $this->table . '.jadwalJamMasuk," - ",' . $this->table . '.jadwalJamKeluar," WIB") AS jadwalJam, kelompok.*, date(FROM_UNIXTIME( ' . $this->table . '.jadwalTanggalMulai / 1000 )) AS jadwalTanggalMulai, date(FROM_UNIXTIME( ' . $this->table . '.jadwalTanggalSelesai / 1000 )) AS jadwalTanggalSelesai,' . $this->table . '.jadwalJumlahWeek,' . $this->table . '.jadwalJamMasuk,' . $this->table . '.jadwalJamKeluar,(select  GROUP_CONCAT( DISTINCT CONCAT( " ", kelompok_detail.kelompokDetNama, " (" ), CONCAT(kelompok_detail.kelompokDetNim,")") ORDER BY kelompok_detail.kelompokDetId ASC )  from kelompok_detail where kelompok_detail.kelompokDetKelompokId=' . $this->table . '.jadwalKelompokId
        GROUP BY kelompok_detail.kelompokDetKelompokId) AS Mahasiswa');
        $builder->table($this->table);
        $builder->join('kelompok', 'kelompok.kelompokId = ' . $this->table . '.jadwalKelompokId', 'INNER');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = ' . $this->table . '.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->like('kelompok_detail.kelompokDetNama', $keyword);
        $builder->orLike('kelompok_detail.kelompokDetNim', $keyword);
        $builder->orLike('stase.staseNama', $keyword);
        $builder->orLike('rumkit.rumahSakitNama', $keyword);
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
        $builder->where('' . $this->table . '.jadwalRumkitDetId', $rumkitDetId);

        $jadwalKelompok = $builder->get();
        return $jadwalKelompok;
    }

    public function Show_Kelompok($kelompokId)
    {
        $builder = $this->db->table('kelompok');
        $builder->select('*');
        $builder->join('jadwal', '' . $this->table . '.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = ' . $this->table . '.jadwalRumkitDetId', 'LEFT');
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
}
