<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalKegiatanModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'jadwalId';
    protected $allowedFields = ['jadwalRumkitDetId', 'jadwalTahunAkademik', 'jadwalKelompokId', 'jadwalJamMasuk', 'jadwalTanggalMulai', 'jadwalTanggalSelesai', 'jadwalJamKeluar', 'jadwalJumlahWeek'];
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
        $builder->groupBy(['stase.staseId', 'kelompok.kelompokId']);
        $builder->orderBy('jadwal.jadwalId', 'DESC');
        return $builder;
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
            $builder->orWhere($where)->like('jadwal.jadwalTahunAkademik', $keyword);
        } else {
            $builder->like('kelompok.kelompokNama', $keyword);
            $builder->orLike('stase.staseNama', $keyword);
            $builder->orLike('rumkit.rumahSakitNama', $keyword);
            $builder->orLike('jadwal.jadwalTahunAkademik', $keyword);
        }
        $builder->groupBy(['stase.staseId', 'kelompok.kelompokId']);
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
            $builder->selectMin('jadwal_detail.jadwalDetailTanggalMulai');
        } else {
            $builder->selectMax('jadwal_detail.jadwalDetailTanggalSelesai');
        }
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailJadwalId = jadwal.jadwalId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('jadwal_skip', 'jadwal_skip.skipJadwalDetailId = jadwal_detail.jadwalDetailId', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function getMinMaxKelompok($type, $where)
    {
        $builder = $this->table('jadwal');
        if ($type === "min") {
            $builder->selectMin('jadwal.jadwalTanggalMulai');
        } else {
            $builder->selectMax('jadwal.jadwalTanggalSelesai');
        }
        $builder->join('kelompok', 'kelompok.kelompokId = jadwal.jadwalKelompokId', 'LEFT');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailJadwalId = jadwal.jadwalId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function getMinMaxKelompokByDetail($type, $where)
    {
        $builder = $this->table('jadwal');
        if ($type === "min") {
            $builder->selectMin('jadwal_detail.jadwalDetailTanggalMulai');
        } else {
            $builder->selectMax('jadwal_detail.jadwalDetailTanggalSelesai');
        }
        $builder->join('kelompok', 'kelompok.kelompokId = jadwal.jadwalKelompokId', 'LEFT');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailJadwalId = jadwal.jadwalId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function getRumkit()
    {
        $builder = $this->table('jadwal');
        $builder->join('rumkit_detail ', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->groupBy('rumkit.rumahSakitId');
        return $builder->get();
    }

    public function getStase()
    {
        $builder = $this->table('jadwal');
        $builder->join('rumkit_detail ', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->groupBy('stase.staseId');
        return $builder->get();
    }

    public function rekapAbsenStase($rumahSakitId)
    {
        $builder = $this->db->table('jadwal');
        $builder->join('rumkit_detail ', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where(
            [
                'rumkit_detail.rumkitDetRumkitId' => $rumahSakitId,
                'rumkit_detail.rumkitDetStatus' => 1
            ]
        );
        $builder->groupBy('stase.staseId');
        $staseRumkit = $builder->get();
        return $staseRumkit;
    }

    public function rekapAbsenKelompok($staseId)
    {
        $builder = $this->db->table('jadwal');
        $builder->join('kelompok', 'kelompok.kelompokId=jadwal.jadwalKelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where('stase.staseId', $staseId);
        $builder->groupBy('stase.staseId,  jadwal.jadwalKelompokId');
        $kelompok = $builder->get();
        return $kelompok;
    }

    public function getFilterAbsen($staseId, $kelompokId)
    {
        $builder = $this->db->table('absensi');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = absensi.absensiNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where(
            [
                'stase.staseId' => $staseId,
                'kelompok.kelompokId' => $kelompokId
            ]
        );
        $builder->groupBy(['absensi.absensiKeterangan', "from_unixtime(absensi.absensiTanggal / 1000, '%Y %D %M')"]);
        $kelompok = $builder->get();
        return $kelompok;
    }

    public function getMahasiswa($where)
    {
        $builder = $this->db->table('kelompok');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->where($where);
        $result = $builder->get();
        return $result;
    }

    public function rekapNilaiStase($rumahSakitId)
    {
        $builder = $this->db->table('jadwal');
        $builder->join('rumkit_detail ', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where(
            [
                'rumkit_detail.rumkitDetRumkitId' => $rumahSakitId,
                'rumkit_detail.rumkitDetStatus' => 1
            ]
        );
        $staseRumkit = $builder->get();
        return $staseRumkit;
    }

    public function getRumkitOneline($where)
    {
        $builder = $this->db->table('jadwal');
        $builder->select('(select  GROUP_CONCAT( DISTINCT CONCAT( " ", rumkit.rumahSakitShortname))) AS Rumkit');
        $builder->join('kelompok', 'kelompok.kelompokId =jadwal.jadwalKelompokId', 'INNER');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where($where);
        $query = $builder->get();
        return $query;
    }

    public function getDetailJadwalKelStase($where)
    {
        $builder = $this->db->table('jadwal');
        $builder->join('kelompok', 'kelompok.kelompokId =jadwal.jadwalKelompokId', 'INNER');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where($where);
        $query = $builder->get();
        return $query;
    }

    public function getStaseByJadwalDetail($where)
    {
        $builder = $this->db->table('jadwal_detail');
        $builder->join('jadwal', 'jadwal.jadwalId = jadwal_detail.jadwalDetailJadwalId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where($where);
        $query = $builder->get();
        return $query;
    }

    public function getDetailSkip($where)
    {
        $builder = $this->db->table('jadwal_skip');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailId = jadwal_skip.skipJadwalDetailId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalId = jadwal_detail.jadwalDetailJadwalId', 'LEFT');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = jadwal.jadwalRumkitDetId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where($where);
        $query = $builder->get();
        return $query;
    }
}
