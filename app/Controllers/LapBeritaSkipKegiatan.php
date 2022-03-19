<?php

namespace App\Controllers;

use App\Models\LapBeritaAcaraModel;
use App\Models\KelompokMahasiswaModel;
use App\Models\DataKegiatanModel;
use App\Models\DataKelompokModel;

class LapBeritaSkipKegiatan extends BaseController
{
    protected $lapBeritaAcaraModel;
    protected $kelompokModel;
    protected $dataKegiatanModel;
    protected $dataKelompokModel;

    public function __construct()
    {
        $this->lapBeritaAcaraModel = new LapBeritaAcaraModel();
        $this->kelompokModel = new KelompokMahasiswaModel();
        $this->dataKegiatanModel = new DataKegiatanModel();
        $this->dataKelompokModel = new DataKelompokModel();
    }

    public function index()
    {
        $data = [
            'title' => "Jadwal Tertunda",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Berita Acara Kegiatan', 'Jadwal Tertunda'],
            'menu' => $this->fetchMenu(),
            'stase' => $this->lapBeritaAcaraModel->getStase()->get()->getResult(),

        ];
        return view('pages/beritaSkipKegiatan', $data);
    }

    public function kegiatan()
    {
        $staseBeritaAcara = $this->request->getPost('staseBeritaAcara');
        $email = $this->request->getPost('email');
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
        $email = $this->request->getPost('email');
        $kelompokBerita = $this->lapBeritaAcaraModel->getKelompokBerita($stase, $kegiatan, $email);
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($kelompokBerita->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_kelompok' => $lists);
        echo json_encode($callback);
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
