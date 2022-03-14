<?php

namespace App\Controllers;

use App\Models\EvaluasiModel;
use App\Models\DosenPembimbingModel;
use App\Models\DataRumahSakitModel;
use App\Models\JadwalKegiatanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\StaseModel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Evaluasi extends BaseController
{
    protected $evaluasiModel;
    protected $dataRumahSakitModel;
    protected $dosenPembimbingModel;
    protected $staseModel;
    protected $jadwalKegiatanModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->staseModel = new StaseModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
        $this->dosenPembimbingModel = new DosenPembimbingModel();
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
            'dataFilter' => [null, null, null]
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
        // dd($_POST);
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

        $rumahSakitEvaluasi = trim($this->request->getPost('rumahSakitEvaluasi'));
        $staseEvaluasi = trim($this->request->getPost('staseEvaluasi'));
        $dopingEvaluasi = trim($this->request->getPost('dopingEvaluasi'));

        $dataEvaluasi = $this->evaluasiModel->getFilterEvaluasi($staseEvaluasi, $dopingEvaluasi)->getResult();
        $data = [
            'title' => "Evaluasi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Evaluasi'],
            'evaluasi' => $this->evaluasiModel->findAll(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'dataResult' => $dataEvaluasi,
            'dataFilter' => [$rumahSakitEvaluasi, $staseEvaluasi, $dopingEvaluasi]
        ];

        $doping = $this->dosenPembimbingModel->getWhere(['dopingEmail' => $dopingEvaluasi])->getResult()[0]->dopingNamaLengkap;
        $stase = $this->staseModel->getWhere(['staseId' => $staseEvaluasi])->getResult()[0]->staseNama;
        $rumahSakit = $this->dataRumahSakitModel->getWhere(['rumahSakitId' => $rumahSakitEvaluasi])->getResult()[0]->rumahSakitShortname;

        if ($dataEvaluasi == null) {
            session()->setFlashdata('danger', 'Evaluasi <strong>' . $doping . '</strong> Untuk Stase <strong>' . $stase . '</strong> Di <strong>' . $rumahSakit . '</strong> Belum Ada ,Coba Lagi Nanti!');
        } else {
            session()->setFlashdata('success', 'Evaluasi <strong>' . $doping . '</strong> Untuk Stase <strong>' . $stase . '</strong> Di <strong>' . $rumahSakit . '</strong> Sudah Ditemukan ,Klik Export Untuk Download!');
        }

        return view('pages/evaluasi', $data);
    }
}
