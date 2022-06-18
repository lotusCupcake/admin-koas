<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanMahasiswaModel extends Model
{
    protected $table = 'logbook';
    protected $primaryKey = 'logbookId';
    protected $allowedFields = ['logbookRumkitDetId', 'logbookTahunAkademik', 'logbookDopingEmail', 'logbookNim', 'logbookTanggal', 'logbookCreateDate', 'logbookKegiatanId', 'logbookJudulDeskripsi', 'logbookDeskripsi', 'logbookIsVerify', 'logbookTahunAkademik'];
    protected $returnType = 'object';

    public function getKegiatan($where = null)
    {
        $builder = $this->table('logbook');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('one_signal', 'one_signal.oneSignalNpm = kelompok_detail.kelompokDetNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailJadwalId = jadwal.jadwalId', 'LEFT');
        $builder->groupBy('logbook.logbookId');
        $builder->orderBy('logbook.logbookId', 'DESC');
        if ($where) {
            $builder->where($where);
        }
        return $builder;
    }

    public function getKegiatanSearch($keyword, $where = null)
    {
        $builder = $this->table('logbook');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('one_signal', 'one_signal.oneSignalNpm = kelompok_detail.kelompokDetNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('jadwal', 'jadwal.jadwalKelompokId = kelompok.kelompokId', 'LEFT');
        $builder->join('jadwal_detail', 'jadwal_detail.jadwalDetailJadwalId = jadwal.jadwalId', 'LEFT');
        if ($where) {
            $builder->where($where)->like('kelompok_detail.kelompokDetNim', $keyword);
            $builder->orWhere($where)->like('kelompok_detail.kelompokDetNama', $keyword);
            $builder->orWhere($where)->like('stase.staseNama', $keyword);
            $builder->orWhere($where)->like('kegiatan.kegiatanNama', $keyword);
            $builder->orWhere($where)->like('dosen_pembimbing.dopingNamaLengkap', $keyword);
            $builder->orWhere($where)->like('logbook.logbookTahunAkademik', $keyword);
        } else {
            $builder->like('kelompok_detail.kelompokDetNim', $keyword);
            $builder->orLike('kelompok_detail.kelompokDetNama', $keyword);
            $builder->orLike('stase.staseNama', $keyword);
            $builder->orLike('kegiatan.kegiatanNama', $keyword);
            $builder->orLike('rumkit.rumahSakitNama', $keyword);
            $builder->orLike('dosen_pembimbing.dopingNamaLengkap', $keyword);
            $builder->orLike('logbook.logbookTahunAkademik', $keyword);
        }
        $builder->groupBy('logbook.logbookId');
        $builder->orderBy('logbook.logbookId', 'DESC');
        return $builder;
    }

    public function getMahasiswaNilai($where)
    {
        $builder = $this->table('logbook');
        $builder->select('kelompokDetNim,kelompokDetNama,dopingNamaLengkap,gradeApproveStatus,gradeNilai,dopingEmail,staseId,gradeId,oneSignalPlayerId,kelompokNama,rumahSakitNama,staseNama,grResult');
        $builder->join('rumkit_detail', 'rumkit_detail.rumkitDetId = logbook.logbookRumkitDetId', 'LEFT');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingEmail = logbook.logbookDopingEmail', 'LEFT');
        $builder->join('kelompok_detail', 'kelompok_detail.kelompokDetNim = logbook.logbookNim', 'LEFT');
        $builder->join('one_signal', 'one_signal.oneSignalNpm = logbook.logbookNim', 'LEFT');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId', 'LEFT');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('penilaian', 'penilaian.penilaianId = kegiatan.kegiatanPenilaianId', 'LEFT');
        $builder->join('penilaian_grade', 'penilaian_grade.gradePenilaianId = penilaian.penilaianId AND penilaian_grade.gradeStaseId=stase.staseId AND penilaian_grade.gradeNpm=logbook.logbookNim', 'LEFT');
        $builder->join('penilaian_gr', 'penilaian_gr.grPenilaianId = penilaian.penilaianId AND penilaian_gr.grStaseId = stase.staseId AND penilaian_gr.grNpm = logbook.logbookNim', 'LEFT');
        $builder->where($where);
        $builder->groupBy(['kelompok_detail.kelompokDetNim', 'stase.staseId']);
        return $builder;
    }

    public function getJumlahKegiatan($where)
    {
        $builder = $this->table('logbook');
        $builder->selectCount('logbook.logbookId');
        $builder->join('users', 'users.email = logbook.logbookDopingEmail', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function jumlahKegiatanNilai($where)
    {
        $builder = $this->table('logbook');
        $builder->join('kegiatan', 'kegiatan.kegiatanId = logbook.logbookKegiatanId', 'LEFT');
        $builder->join('penilaian', 'penilaian.penilaianId = kegiatan.kegiatanPenilaianId', 'LEFT');
        $builder->join('penilaian_grade', 'penilaian_grade.gradePenilaianId = penilaian.penilaianId', 'LEFT');
        $builder->where($where);
        return $builder;
    }
}
