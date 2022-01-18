<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\LogbookMahasiswaModel;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    protected $logbookModel;
    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->logbookModel = new LogbookMahasiswaModel();
    }
    public function index()
    {
        $data = [
            'title' => "Penilaian",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Penilaian'],
            'penilaian' => $this->penilaianModel->findAll(),
            'validation' => \Config\Services::validation(),
            'mahasiswa' => $this->logbookModel->getMahasiswaNilai(user()->id)->findAll(),
            'penilainJurnalReading' => $this->penilaianModel->getFormJurnalReading()->findAll(),
            'penilainRefarat' => $this->penilaianModel->getFormJurnalRefarat()->findAll(),
            'penilainRefleksiKasus' => $this->penilaianModel->getFormJurnalRefleksiKasus()->findAll(),
            'menu' => $this->fetchMenu()
        ];
        // dd($data['mahasiswa']);
        return view('pages/penilaian', $data);
    }
}
