<?php

namespace App\Controllers;

use App\Models\LapBeritaAcaraModel;
use App\Models\KelompokMahasiswaModel;

class LapBeritaAcara extends BaseController
{
    protected $lapBeritaAcaraModel;
    protected $kelompokModel;

    public function __construct()
    {
        $this->lapBeritaAcaraModel = new LapBeritaAcaraModel();
        $this->kelompokModel = new KelompokMahasiswaModel();
    }

    public function index()
    {
        $data = [
            'title' => "Berita Acara",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Berita Acara'],
            'menu' => $this->fetchMenu(),
            'stase' => $this->lapBeritaAcaraModel->getStase()->get()->getResult(),

        ];
        return view('pages/beritaAcara', $data);
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
        $staseBeritaAcara = $this->request->getPost('staseBeritaAcara');
        $kegiatanId = $this->request->getPost('kegiatanId');
        $kelompokBeritaAcara = $this->request->getPost('kelompokBeritaAcara');
        $paramsCetak = array(
            'logbookRumkitDetId' => $staseBeritaAcara,
            'logbookDopingEmail' => user()->email,
            'logbookKegiatanId' => $kegiatanId,
            'kelompokId' => $kelompokBeritaAcara,
            'logbookIsVerify' => 1
        );

        $cetakBeritaAcara = $this->lapBeritaAcaraModel->getCetakBerita($paramsCetak)->getResult();
        $dataCetak = array(
            'dataInit' => $cetakBeritaAcara,
            'dataMahasiswa' => $this->kelompokModel->dataKelompok(['kelompokDetKelompokId' => $kelompokBeritaAcara])->getResult(),
        );
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'LEGAL']);
        $mpdf->WriteHTML(view('pages/laporanBeritaAcara', $dataCetak));
        return redirect()->to($mpdf->Output('laporan_Berita_Acara.pdf', 'I'));
    }
}
