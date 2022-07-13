<?php

namespace App\Controllers;

use App\Models\LapBeritaAcaraModel;
use App\Models\KelompokMahasiswaModel;
use App\Models\DataKegiatanModel;
use App\Models\DataKelompokModel;
use App\Models\DosenPembimbingModel;
use Mpdf\Tag\Dd;

class LapBeritaAcara extends BaseController
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
            'menu' => $this->fetchMenu(),
            'title' => "Jadwal Normal",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Berita Acara Kegiatan', 'Jadwal Normal'],
            'stase' => $this->lapBeritaAcaraModel->getStase($dosen)->getResult(),
            'dosen' => $this->dosenPembimbingModel->getSpecificDosen($where)->get()->getResult(),
            'beritaAcara' => []
        ];
        return view('pages/beritaAcara', $data);
    }

    public function stase()
    {
        $dosen = $this->request->getVar('dosenBeritaAcara');
        $staseBeritaAcara = $this->lapBeritaAcaraModel->getStase($dosen)->getResult();
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseBeritaAcara as $data) {
            $lists .= "<option value='" . $data->logbookRumkitDetId . "'>" . $data->staseNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_stase' => $lists);
        echo json_encode($callback);
    }

    public function kegiatan()
    {
        $staseBeritaAcara = $this->request->getVar('staseBeritaAcara');
        if ($this->request->getVar('role') == 'Koordik') {
            $email = $this->request->getVar('dosenBeritaAcara');
        } else {
            $email = $this->request->getVar('email');
        }
        $kegiatanBerita = $this->lapBeritaAcaraModel->getKegiatanMhs($staseBeritaAcara, $email);
        $lists = "<option value=''>Pilih Kegiatan</option>";
        foreach ($kegiatanBerita->getResult() as $data) {
            $lists .= "<option value='" . $data->kegiatanId . "'>" . $data->kegiatanNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_kegiatan' => $lists);
        echo json_encode($callback);
    }

    public function kelompok()
    {
        $stase = $this->request->getPost('stase');
        $kegiatan = $this->request->getPost('kegiatan');
        if ($this->request->getVar('role') == 'Koordik') {
            $email = $this->request->getPost('dosenBeritaAcara');
        } else {
            $email = $this->request->getPost('email');
        }
        $kelompokBerita = $this->lapBeritaAcaraModel->getKelompokBerita($stase, $kegiatan, $email);
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($kelompokBerita->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_kelompok' => $lists);
        echo json_encode($callback);
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
            'title' => "Jadwal Normal",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Berita Acara Kegiatan', 'Jadwal Normal'],
            'stase' => $this->lapBeritaAcaraModel->getStase($dosen)->getResult(),
            'dosen' => $this->dosenPembimbingModel->getSpecificDosen($where)->get()->getResult(),
            'beritaAcara' => $this->lapBeritaAcaraModel->getCetakBerita($paramsCetak, $staseBeritaAcara)->getResult(),
            'dataMhs' => $this->kelompokModel->dataKelompok(['kelompokDetKelompokId' => $kelompokBeritaAcara])->getResult()
        ];
        $kegiatan = $this->dataKegiatanModel->getWhere(['kegiatanId' => $kegiatanId])->getResult()[0]->kegiatanNama;
        $kelompok = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokBeritaAcara])->getResult()[0]->kelompokNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokBeritaAcara])->getResult()[0]->kelompokTahunAkademik;
        if (count($data['beritaAcara']) < 1) {
            session()->setFlashdata('danger', 'Berita Acara <strong>' . $kelompok . ' - TA.' . $tahunAkademik . '</strong> Untuk Kegiatan <strong>' . $kegiatan . '</strong> Masih Kosong!');
        }
        return view('pages/beritaAcara', $data);
    }

    public function cetak()
    {
        $nim = [];
        $staseBeritaAcara = $this->request->getVar('staseBeritaAcara');
        $kegiatanId = $this->request->getVar('kegiatanId');
        $kelompokBeritaAcara = $this->request->getVar('kelompokBeritaAcara');
        $dosenBeritaAcara = $this->request->getVar('dosenBeritaAcara');
        $kegiatan = $this->dataKegiatanModel->getWhere(['kegiatanId' => $kegiatanId])->getResult()[0]->kegiatanNama;
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

        $cetakBeritaAcara = $this->lapBeritaAcaraModel->getCetakBerita($paramsCetak, $staseBeritaAcara)->getResult();
        foreach ($cetakBeritaAcara as $row_berita_acara) {
            array_push($nim, $row_berita_acara->logbookNim);
        }
        $dataCetak = array(
            'dataInit' => $cetakBeritaAcara,
            'dataMahasiswa' => $this->kelompokModel->dataKelompok(['kelompokDetKelompokId' => $kelompokBeritaAcara])->getResult(),
        );
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'LEGAL']);
        $mpdf->WriteHTML(view('pages/laporanBeritaAcara', $dataCetak));
        return redirect()->to($mpdf->Output('Berita Acara ' . $kegiatan . '.pdf', 'I'));
    }
}
