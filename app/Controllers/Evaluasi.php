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
        return view('pages/evaluasi', $data);
    }

    public function proses()
    {
        if (!$this->validate([
            'rumahSakitEvaluasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rumah Sakit Harus Dipilih!',
                ]
            ],
            'staseEvaluasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
            'dopingEvaluasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dosen Pembimbing Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('rekapNilai')->withInput();
        }

        $dataEvaluasi = $this->evaluasiModel->getFilterEvaluasi()->getResult();
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
        session()->setFlashdata('success', 'Evaluasi Sudah Ditemukan ,Klik Export Untuk Download!');
        return view('pages/evaluasi', $data);
    }
}
