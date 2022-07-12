<?php

namespace App\Controllers;

use App\Models\LapBeritaAcaraModel;
use App\Models\KelompokMahasiswaModel;
use App\Models\DataKegiatanModel;
use App\Models\DataKelompokModel;
use App\Models\DosenPembimbingModel;

class LapBeritaSkipKegiatan extends BaseController
{
    protected $lapBeritaAcaraModel;
    protected $dosenPembimbingModel;
    protected $kelompokModel;
    protected $dataKegiatanModel;
    protected $dataKelompokModel;

    public function __construct()
    {
        $this->lapBeritaAcaraModel = new LapBeritaAcaraModel();
        $this->dosenPembimbingModel = new DosenPembimbingModel();
        $this->kelompokModel = new KelompokMahasiswaModel();
        $this->dataKegiatanModel = new DataKegiatanModel();
        $this->dataKelompokModel = new DataKelompokModel();
    }

    public function index()
    {
        if (in_groups('Koordik')) {
            $rumkit = getUser(user()->id)->rumahSakitId;
            $where = ['dosen_pembimbing.dopingRumkitId' => $rumkit];
            $dosen = null;
        } elseif (in_groups('Dosen')) {
            $where = null;
            $dosen = user()->email;
        }
        $data = [
            'title' => "Jadwal Tertunda",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Berita Acara Kegiatan', 'Jadwal Tertunda'],
            'menu' => $this->fetchMenu(),
            'stase' => $this->lapBeritaAcaraModel->getStase($dosen)->getResult(),
            'dosen' => $this->dosenPembimbingModel->getSpecificDosen($where)->get()->getResult(),
            'beritaAcara' => []

        ];
        return view('pages/beritaSkipKegiatan', $data);
    }

    public function loadData()
    {
        $staseBeritaAcara = $this->request->getVar('staseBeritaAcara');
        $kegiatanId = $this->request->getVar('kegiatanId');
        $kelompokBeritaAcara = $this->request->getVar('kelompokBeritaAcara');
        $dosenBeritaAcara = $this->request->getVar('dosenBeritaAcara');
        if (in_groups('Koordik')) {
            $paramsCetak = array(
                'logbookRumkitDetId' => $staseBeritaAcara,
                'logbookDopingEmail' => $dosenBeritaAcara,
                'logbookKegiatanId' => $kegiatanId,
                'kelompokId' => $kelompokBeritaAcara,
                'logbookIsVerify' => 1
            );
        } else {
            $paramsCetak = array(
                'logbookRumkitDetId' => $staseBeritaAcara,
                'logbookDopingEmail' => user()->email,
                'logbookKegiatanId' => $kegiatanId,
                'kelompokId' => $kelompokBeritaAcara,
                'logbookIsVerify' => 1
            );
        }

        if (in_groups('Koordik')) {
            $rumkit = getUser(user()->id)->rumahSakitId;
            $where = ['dosen_pembimbing.dopingRumkitId' => $rumkit];
            $dosen = null;
        } elseif (in_groups('Dosen')) {
            $where = null;
            $dosen = user()->email;
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jadwal Tertunda",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Berita Acara Kegiatan', 'Jadwal Tertunda'],
            'stase' => $this->lapBeritaAcaraModel->getStase($dosen)->getResult(),
            'dosen' => $this->dosenPembimbingModel->getSpecificDosen($where)->get()->getResult(),
            'beritaAcara' => $this->lapBeritaAcaraModel->getCetakBerita_JadwalSkip($paramsCetak, $staseBeritaAcara)->getResult(),
            'dataMhs' => $this->kelompokModel->dataKelompok(['kelompokDetKelompokId' => $kelompokBeritaAcara])->getResult()
        ];
        $kegiatan = $this->dataKegiatanModel->getWhere(['kegiatanId' => $kegiatanId])->getResult()[0]->kegiatanNama;
        $kelompok = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokBeritaAcara])->getResult()[0]->kelompokNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokBeritaAcara])->getResult()[0]->kelompokTahunAkademik;
        if (count($data['beritaAcara']) < 1) {
            session()->setFlashdata('danger', 'Berita Acara <strong>' . $kelompok . ' - TA.' . $tahunAkademik . '</strong> Untuk Kegiatan <strong>' . $kegiatan . '</strong> Masih Kosong!');
        }
        return view('pages/beritaSkipKegiatan', $data);
    }

    public function cetak()
    {
        $nim = [];
        $staseBeritaAcara = $this->request->getPost('staseBeritaAcara');
        $kegiatanId = $this->request->getPost('kegiatanId');
        $kelompokBeritaAcara = $this->request->getPost('kelompokBeritaAcara');
        $kegiatan = $this->dataKegiatanModel->getWhere(['kegiatanId' => $kegiatanId])->getResult()[0]->kegiatanNama;
        $kelompok = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokBeritaAcara])->getResult()[0]->kelompokNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokBeritaAcara])->getResult()[0]->kelompokTahunAkademik;
        $paramsCetak = array(
            'logbookRumkitDetId' => $staseBeritaAcara,
            'logbookDopingEmail' => user()->email,
            'logbookKegiatanId' => $kegiatanId,
            'kelompokId' => $kelompokBeritaAcara,
            'logbookIsVerify' => 1
        );

        $cetakBeritaAcara = $this->lapBeritaAcaraModel->getCetakBerita_JadwalSkip($paramsCetak, $staseBeritaAcara)->getResult();
        foreach ($cetakBeritaAcara as $row_berita_acara) {
            array_push($nim, $row_berita_acara->logbookNim);
        }
        if (count($nim) > 0) {
            $dataCetak = array(
                'dataInit' => $cetakBeritaAcara,
                'dataMahasiswa' => $this->kelompokModel->dataKelompok(['kelompokDetKelompokId' => $kelompokBeritaAcara])->getResult(),
            );
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'LEGAL']);
            $mpdf->WriteHTML(view('pages/laporanBeritaAcara', $dataCetak));
            return redirect()->to($mpdf->Output('laporan_Berita_Skip_Kegiatan.pdf', 'I'));
        } else {
            session()->setFlashdata('danger', 'Berita Acara <strong>' . $kelompok . ' - TA.' . $tahunAkademik . '</strong> Untuk Kegiatan <strong>' . $kegiatan . '</strong> Masih Kosong!');
            return redirect()->to('lapBeritaSkipKegiatan');
        }
    }
}
