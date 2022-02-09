<?php

namespace App\Controllers;

use App\Models\JadwalKegiatanModel;

class RekapAbsen extends BaseController
{
    protected $jadwalKegiatanModel;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
    }

    public function index()
    {
        $data = [
            'title' => "Rekap Absensi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Absensi'],
            'menu' => $this->fetchMenu(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkitAbsensi()->getResult()
        ];
        return view('pages/rekapAbsen', $data);
    }

    public function rekapAbsenStase()
    {
        // Ambil data rumahSakitId yang dikirim via ajax post
        $rumahSakitId = trim($this->request->getPost('rumahSakitId'));
        $staseRumkit = $this->jadwalKegiatanModel->rekapAbsenStase($rumahSakitId);
        // Proses Get Data Stase Dari Tabel Rumkit_Detail

        // Buat variabel untuk menampung tag-tag option nya
        // Set defaultnya dengan tag option Pilih
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseRumkit->getResult() as $data) {
            $lists .= "<option value='" . $data->rumkitDetId . "'>" . $data->staseNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_stase_rumkit' => $lists); // Masukan Variabel Lists Tadi Ke Dalam Array $callback dengan index array : list_jurusan
        echo json_encode($callback); // konversi variabel $callback menjadi JSON
    }

    public function rekapAbsenKelompok()
    {
        $kelompokId = [];
        $rumkitDetId = trim($this->request->getPost('staseId'));

        $jadwalKelompok = $this->jadwalKegiatanModel->rekapAbsenKelompok($rumkitDetId);
        // dd($jadwalKelompok);
        foreach ($jadwalKelompok->getResult() as $kelompok_jadwal) {
            array_push($kelompokId, $kelompok_jadwal->jadwalKelompokId);
        }

        if (count($kelompokId) == 0) {
            $kelompokId = [0];
        }
        $kelompok = $this->jadwalKegiatanModel->Show_Kelompok($kelompokId);
        // Proses Get Data Stase Dari Tabel Kelompok
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($jadwalKelompok->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . " - TA." . $data->kelompokTahunAkademik . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_kelompok' => $lists); // Masukan Variabel Lists Tadi Ke Dalam Array $callback dengan index array : list_jurusan
        echo json_encode($callback); // konversi variabel $callback menjadi JSON
    }

    public function proses()
    {
        dd($_POST);
    }
}
