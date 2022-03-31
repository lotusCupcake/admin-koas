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
        if ($this->request->getpost('rumahSakitEvaluasi') != null) {
            $rumahSakitEvaluasi = trim($this->request->getPost('rumahSakitEvaluasi'));
            $staseEvaluasi = $this->evaluasiModel->evaluasiStase($rumahSakitEvaluasi);
            $lists = "<option value=''>Pilih Stase</option>";
            foreach ($staseEvaluasi->getResult() as $data) {
                $lists .= "<option value='" . $data->staseId . "'>" . $data->staseNama . "</option>";
            }
            $callback = array('list_stase_evaluasi' => $lists);
            echo json_encode($callback);
        }
    }

    public function evaluasiDoping()
    {
        $rumahSakitEvaluasi = trim($this->request->getPost('rumahSakitEvaluasi'));
        $staseEvaluasi = trim($this->request->getPost('staseEvaluasi'));
        $dopingEvaluasiEmail = $this->request->getPost('dopingEvaluasiEmail');
        $role = $this->request->getPost('role');

        if ($role == "Dosen") {
            $where = [
                'dosen_pembimbing.dopingEmail' => $dopingEvaluasiEmail,
                'rumkit_detail.rumkitDetRumkitId' => $rumahSakitEvaluasi,
                'rumkit_detail.rumkitDetStaseId' => $staseEvaluasi,
                'rumkit_detail.rumkitDetStatus' => 1
            ];
        } else {
            $where = [
                'rumkit_detail.rumkitDetRumkitId' => $rumahSakitEvaluasi,
                'rumkit_detail.rumkitDetStaseId' => $staseEvaluasi,
                'rumkit_detail.rumkitDetStatus' => 1
            ];
        }
        $dopingEvaluasi = $this->evaluasiModel->evaluasiDoping($where);
        $lists = "<option value=''>Pilih Dosen Pembimbing</option>";
        foreach ($dopingEvaluasi as $data) {
            if ($role == "Dosen") {
                $lists .= "<option value='" . $data->dopingEmail . "'>" . $data->dopingNamaLengkap . "</option>";
            } else {
                if ($dopingEvaluasi[0]->dopingNamaLengkap != null) {
                    $lists .= "<option value='" . $data->dopingEmail . "'>" . $data->dopingNamaLengkap . "</option>";
                }
            }
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

        $rumahSakitEvaluasi = trim($this->request->getPost('rumahSakitEvaluasi'));
        $staseEvaluasi = trim($this->request->getPost('staseEvaluasi'));
        $dopingEvaluasi = trim($this->request->getPost('dopingEvaluasi'));

        $dataEvaluasi = $this->evaluasiModel->getFilterEvaluasi($staseEvaluasi, $dopingEvaluasi)->getResult();
        $data = [
            'title' => "Evaluasi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Evaluasi'],
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

    public function exportEvaluasi()
    {
        $staseEvaluasi = trim($this->request->getPost('staseEvaluasi'));
        $dopingEvaluasi = trim($this->request->getPost('dopingEvaluasi'));
        $dataEvaluasi = $this->evaluasiModel->getFilterEvaluasi($staseEvaluasi, $dopingEvaluasi)->getResult();
        // dd($dataEvaluasi);
        $rumahSakit = $dataEvaluasi[0]->rumahSakitShortname;
        $stase = $dataEvaluasi[0]->staseNama;
        $doping = $dataEvaluasi[0]->dopingNamaLengkap;

        $this->spreadsheet = new Spreadsheet();

        $default = 1;
        $konten = 0;
        foreach ($dataEvaluasi as $data) {
            $konten = $default + $konten;
            $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $konten, $data->kelompokDetNama . ' (' . $data->kelompokDetNim . ') - ' . $doping)->mergeCells("A" . $konten . ":" . "C" . $konten)->getStyle("A" . $konten . ":" . "C" . $konten)->getFont()->setBold(true);
            $konten = $konten + 1;
            $this->spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $konten, 'No.')
                ->setCellValue('B' . $konten, 'Aspek Nilai')
                ->setCellValue('C' . $konten, 'Nilai')->getStyle("A" . $konten . ":" . "C" . $konten)->getFont()->setBold(true);

            $konten = $konten + 1;
            $no = 1;
            $evaluasi = getEvaluasi(['evaluasi_grade.gradeEvaluasiStaseId' => $data->staseId, 'evaluasi_grade.gradeEvaluasiNpm' => $data->kelompokDetNim, 'evaluasi_grade.gradeEvaluasiDopingEmail' => $data->dopingEmail])[0]->gradeEvaluasiNilai;
            foreach (json_decode($evaluasi) as $eval) {
                $this->spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $konten, $no++)
                    ->setCellValue('B' . $konten, getAspekEvaluasi(['evaluasiId' => $eval->aspek])[0]->evaluasiAspek)
                    ->setCellValue('C' . $konten, $eval->nilai)->getStyle("A" . $konten . ":" . "C" . $konten);
                $konten++;
            }
        }

        $writer = new Xlsx($this->spreadsheet);

        $fileName = 'Evaluasi Dosen Pembimbing ' . $rumahSakit . ' - ' . $stase;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
