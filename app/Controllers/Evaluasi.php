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

    public function evaluasiStase()
    {
        $rumahSakitEvaluasi = trim($this->request->getPost('rumahSakitEvaluasi'));
        $staseEvaluasi = $this->evaluasiModel->evaluasiStase($rumahSakitEvaluasi);
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseEvaluasi->getResult() as $data) {
            $lists .= "<option value='" . $data->staseId . "'>" . $data->staseNama . "</option>";
        }
        $callback = array('list_stase_evaluasi' => $lists);
        echo json_encode($callback);
    }

    public function evaluasiDoping()
    {
        $rumahSakitEvaluasi = trim($this->request->getPost('rumahSakitEvaluasi'));
        $staseEvaluasi = trim($this->request->getPost('staseEvaluasi'));
        $dopingEvaluasi = $this->evaluasiModel->evaluasiDoping($rumahSakitEvaluasi, $staseEvaluasi);
        $lists = "<option value=''>Pilih Dosen Pembimbing</option>";
        foreach ($dopingEvaluasi->getResult() as $data) {
            $lists .= "<option value='" . $data->dopingEmail . "'>" . $data->dopingNamaLengkap . "</option>";
        }
        $callback = array('list_doping_evaluasi' => $lists);
        echo json_encode($callback);
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
