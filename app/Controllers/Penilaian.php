<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\KegiatanMahasiswaModel;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    protected $kegiatanModel;
    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->kegiatanModel = new KegiatanMahasiswaModel();
    }
    public function index()
    {
        $data = [
            'title' => "Penilaian",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Penilaian'],
            'penilaian' => $this->penilaianModel->findAll(),
            'validation' => \Config\Services::validation(),
            'mahasiswa' => $this->kegiatanModel->getMahasiswaNilai(user()->email)->findAll(),
            'penilainJurnalReading' => $this->penilaianModel->getFormJurnalReading()->findAll(),
            'penilainRefarat' => $this->penilaianModel->getFormJurnalRefarat()->findAll(),
            'penilainRefleksiKasus' => $this->penilaianModel->getFormJurnalRefleksiKasus()->findAll(),
            'menu' => $this->fetchMenu()
        ];
        // dd($data['mahasiswa']);
        return view('pages/penilaian', $data);
    }
}
