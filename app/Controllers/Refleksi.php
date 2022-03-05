<?php

namespace App\Controllers;

use App\Models\RefleksiModel;
use App\Models\JadwalKegiatanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Refleksi extends BaseController
{
    protected $RefleksiModel;
    protected $jadwalKegiatanModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
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
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . "</option>";
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

        $data = [
            'title' => "Refleksi Diri",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Refleksi Diri'],
            'refleksi' => $this->refleksiModel->findAll(),
            'dataStase' => $this->jadwalKegiatanModel->getStase()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'kompetensi' => $this->refleksiModel->getKompetensi()->getResult(),
            'refleksi' => $this->refleksiModel->getFilterRefleksi()->getResult(),
            'dataFilter' => [null, null]
        ];

        // dd($data['dataResult']);
        session()->setFlashdata('success', 'Refleksi Diri Sudah Ditemukan ,Klik Export Untuk Download!');
        return view('pages/refleksi', $data);
    }
}
