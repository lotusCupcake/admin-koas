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
            'title' => "Refleksi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Refleksi'],
            'refleksi' => $this->refleksiModel->findAll(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'dataResult' => [],
            'dataFilter' => [null, null]
        ];
        // dd($data);
        return view('pages/refleksi', $data);
    }
}
