<?php

namespace App\Controllers;

use App\Models\BeritaAcaraModel;
use App\Models\KelompokMahasiswaModel;
use \Mpdf\Mpdf;

class BeritaAcara extends BaseController
{
    protected $beritaAcaraModel;
    protected $kelompokModel;

    public function __construct()
    {
        $this->beritaAcaraModel = new BeritaAcaraModel();
        $this->kelompokModel = new KelompokMahasiswaModel();
    }

    public function index()
    {
        $data = [
            'title' => "Berita Acara",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Berita Acara'],
            'menu' => $this->fetchMenu(),
            'stase' => $this->beritaAcaraModel->getStase()->get()->getResult(),
            // 'kegiatan' => $this->beritaAcaraModel->getKegiatanMhs()->get()->getResult()

        ];
        // dd(user()->email);
        return view('pages/beritaAcara', $data);
    }

    public function kegiatan()
    {
        $staseBeritaAcara = $this->request->getPost('staseBeritaAcara');
        $kegiatanBerita = $this->beritaAcaraModel->getKegiatanMhs($staseBeritaAcara);
        // Buat variabel untuk menampung tag-tag option nya
        // Set defaultnya dengan tag option Pilih
        $lists = "<option value=''>Pilih Kegiatan</option>";
        foreach ($kegiatanBerita->getResult() as $data) {
            $lists .= "<option value='" . $data->kegiatanId . "'>" . $data->kegiatanNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_kegiatan_beritaAcara' => $lists); // Masukan Variabel Lists Tadi Ke Dalam Array $callback dengan index array : list_jurusan
        echo json_encode($callback); // konversi variabel $callback menjadi JSON
    }

    public function kelompok()
    {
        $staseBeritaAcara = $this->request->getPost('staseBeritaAcara');
        $kegiatanId = $this->request->getPost('kegiatanId');
        $kelompokBerita = $this->beritaAcaraModel->getKelompokBerita($staseBeritaAcara, $kegiatanId);
        // Buat variabel untuk menampung tag-tag option nya
        // Set defaultnya dengan tag option Pilih
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($kelompokBerita->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_kelompok_beritaAcara' => $lists); // Masukan Variabel Lists Tadi Ke Dalam Array $callback dengan index array : list_jurusan
        echo json_encode($callback); // konversi variabel $callback menjadi JSON
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

        $cetakBeritaAcara = $this->beritaAcaraModel->getCetakBerita($paramsCetak)->getResult();
        $dataCetak = array(
            'dataInit' => $cetakBeritaAcara,
            'dataMahasiswa' => $this->kelompokModel->dataKelompok(['kelompokDetKelompokId' => $kelompokBeritaAcara])->getResult(),
        );

        dd($dataCetak);
        $mpdf = new Mpdf(['mode' => 'utf-8']);
        $mpdf->WriteHTML(view('welcome_message', $dataCetak));
        return redirect()->to($mpdf->Output('Test.pdf', 'I'));
    }
}
