<?php

namespace App\Controllers;

use App\Models\RefleksiModel;
use App\Models\StaseModel;
use App\Models\DataKelompokModel;
use App\Models\JadwalKegiatanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Refleksi extends BaseController
{
    protected $RefleksiModel;
    protected $staseModel;
    protected $dataKelompokModel;
    protected $jadwalKegiatanModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->staseModel = new StaseModel();
        $this->dataKelompokModel = new DataKelompokModel();
        $this->spreadsheet = new Spreadsheet();
        $this->refleksiModel = new RefleksiModel();
    }

    public function index()
    {
        $data = [
            'title' => "Refleksi Diri",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Refleksi Diri'],
            'refleksi' => $this->refleksiModel->findAll(),
            'dataStase' => $this->jadwalKegiatanModel->getStase()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'refleksi' => [],
            'interpretasi' => [],
            'dataKompetensi' => [],
            'dataFilter' => [null, null]
        ];
        // dd($data);
        return view('pages/refleksi', $data);
    }

    public function refleksiKelompok()
    {
        $staseRefleksi = trim($this->request->getPost('staseRefleksi'));
        $kelompokRefleksi = $this->refleksiModel->refleksiKelompok($staseRefleksi);
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($kelompokRefleksi->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . " - TA." . $data->kelompokTahunAkademik .  "</option>";
        }
        $callback = array('list_kelompok_refleksi' => $lists);
        echo json_encode($callback);
    }

    public function proses()
    {
        if (!$this->validate([
            'staseRefleksi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
            'kelompokRefleksi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('rekapNilai')->withInput();
        }

        $staseRefleksi = trim($this->request->getPost('staseRefleksi'));
        $kelompokRefleksi = trim($this->request->getPost('kelompokRefleksi'));
        $refleksi = $this->refleksiModel->getFilterRefleksi($staseRefleksi, $kelompokRefleksi)->getResult();
        $namaKomp = [];
        foreach ($this->refleksiModel->getKompetensi()->getResult() as $komp) {
            array_push($namaKomp, $komp->kompetensiNama);
        }
        $data = [
            'title' => "Refleksi Diri",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Refleksi Diri'],
            // 'refleksi' => $this->refleksiModel->findAll(),
            'dataStase' => $this->jadwalKegiatanModel->getStase()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'kompetensi' => $this->refleksiModel->getKompetensi()->getResult(),
            'interpretasi' => $namaKomp,
            'refleksi' => $refleksi,
            'dataKompetensi' => array_unique($namaKomp),
            'dataFilter' => [$staseRefleksi, $kelompokRefleksi]
        ];

        $stase = $this->staseModel->getWhere(['staseId' => $staseRefleksi])->getResult()[0]->staseNama;
        $kelompok = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokRefleksi])->getResult()[0]->kelompokNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokRefleksi])->getResult()[0]->kelompokTahunAkademik;

        if ($refleksi == null) {
            session()->setFlashdata('danger', 'Refleksi Diri <strong>' . $kelompok . '- TA.' . $tahunAkademik .  '</strong> Di Stase <strong>' . $stase . '</strong> Belum Ada ,Coba Lagi Nanti!');
        } else {
            session()->setFlashdata('success', 'Refleksi Diri <strong>' . $kelompok . '- TA.' . $tahunAkademik .  '</strong> Di Stase <strong>' . $stase . '</strong> Sudah Ditemukan ,Klik Export Untuk Download!');
        }

        return view('pages/refleksi', $data);
    }
}
