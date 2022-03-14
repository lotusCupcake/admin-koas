<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\JadwalKegiatanModel;
use App\Models\DataKelompokModel;
use App\Models\StaseModel;
use App\Models\DataRumahSakitModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapNilai extends BaseController
{
    protected $jadwalKegiatanModel;
    protected $dataKelompokModel;
    protected $staseModel;
    protected $dataRumahSakitModel;
    protected $penilaianModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->dataKelompokModel = new DataKelompokModel();
        $this->staseModel = new StaseModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
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

    public function exportRekapNilai($stase)
    {
        dd($_POST);
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

        $rumahSakitId = trim($this->request->getPost('rumahSakitIdAbsen'));
        $staseId = trim($this->request->getPost('staseIdAbsen'));
        $kelompokId = trim($this->request->getPost('kelompokIdAbsen'));

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

        $stase = $this->staseModel->getWhere(['staseId' => $staseId])->getResult()[0]->staseNama;
        $rumahSakit = $this->dataRumahSakitModel->getWhere(['rumahSakitId' => $rumahSakitId])->getResult()[0]->rumahSakitShortname;
        $kelompok = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokId])->getResult()[0]->kelompokNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokId])->getResult()[0]->kelompokTahunAkademik;

        if ($dataMhs == null) {
            session()->setFlashdata('danger', 'Nilai <strong> ' . $kelompok . '- TA.' . $tahunAkademik . '</strong>, Stase <strong>' . $stase . '</strong> Di <strong>' . $rumahSakit . '</strong> Belum Ada ,Coba Lagi Nanti!');
        } else {
            session()->setFlashdata('success', 'Nilai <strong> ' . $kelompok . '- TA.' . $tahunAkademik . '</strong>, Stase <strong>' . $stase . '</strong> Di <strong>' . $rumahSakit . '</strong> Sudah Ditemukan ,Klik Export Untuk Download!');
        }
        return view('pages/rekapNilai', $data);
    }
}
