<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\JadwalKegiatanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapNilai extends BaseController
{
    protected $jadwalKegiatanModel;
    protected $penilaianModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->penilaianModel = new PenilaianModel();
        $this->spreadsheet = new Spreadsheet();
    }

    public function index()
    {
        $data = [
            'title' => "Rekap Nilai",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Nilai'],
            'menu' => $this->fetchMenu(),
            'validation' => \Config\Services::validation(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'dataMhs' => [],
            'dataKomp' => [],
            'dataFilter' => [null, null]
        ];
        return view('pages/rekapNilai', $data);
    }

    public function rekapNilaiStase()
    {
        $rumahSakitId = $this->request->getPost('rumahSakitId');
        $staseRumkit = $this->jadwalKegiatanModel->rekapNilaiStase($rumahSakitId);
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseRumkit->getResult() as $data) {
            $lists .= "<option value='" . $data->rumkitDetId . "'>" . $data->staseNama . "</option>";
        }
        $callback = array('list_stase_rumkit' => $lists);
        echo json_encode($callback);
    }

    public function proses()
    {
        if (!$this->validate([
            'staseIdAbsen' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('rekapNilai')->withInput();
        }
        $kelompokId = trim($this->request->getPost('kelompokIdAbsen'));
        $staseId = trim($this->request->getPost('staseIdAbsen'));

        $dataMhs = $this->penilaianModel->getFilterNilai(['kelompok.kelompokId' => $kelompokId, 'stase.staseId' => $staseId])->getResult();

        $data = [
            'title' => "Rekap Nilai",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Nilai'],
            'menu' => $this->fetchMenu(),
            'validation' => \Config\Services::validation(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'dataMhs' => $dataMhs,
            'dataKomp' => json_decode(getStatus(['setting_bobot.settingBobotStaseId' => $staseId])[0]->settingBobotKomposisiNilai),
            'dataFilter' => [$staseId, $kelompokId]
        ];
        session()->setFlashdata('success', 'Nilai Sudah Ditemukan ,Klik Export Untuk Download!');
        return view('pages/rekapNilai', $data);
    }
}
