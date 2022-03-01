<?php

namespace App\Controllers;

use App\Models\EvaluasiModel;
use App\Models\JadwalKegiatanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Evaluasi extends BaseController
{
    protected $evaluasiModel;
    protected $jadwalKegiatanModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->spreadsheet = new Spreadsheet();
        $this->evaluasiModel = new EvaluasiModel();
    }

    public function index()
    {
        $data = [
            'title' => "Evaluasi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Evaluasi'],
            'evaluasi' => $this->evaluasiModel->findAll(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'dataResult' => [],
            'dataFilter' => [null, null]
        ];
        // dd($data);
        return view('pages/evaluasi', $data);
    }

    public function proses()
    {
        $dataEvaluasi = $this->evaluasiModel->getFilterEvaluasi()->getResult();
        // dd($dataEvaluasi);
        $data = [
            'title' => "Evaluasi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Evaluasi'],
            'evaluasi' => $this->evaluasiModel->findAll(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'dataResult' => $dataEvaluasi,
            'dataFilter' => [null, null]
        ];

        // dd($data['dataResult']);
        session()->setFlashdata('success', 'Evaluasi Sudah Ditemukan ,Klik Export Untuk Download!');
        return view('pages/evaluasi', $data);
    }
}
