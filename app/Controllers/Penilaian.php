<?php

namespace App\Controllers;

use App\Models\PenilaianModel;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
    }
    public function index()
    {
        $data = [
            'title' => "Penilaian",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Penilaian'],
            'penilaian' => $this->penilaianModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/penilaian', $data);
    }
}
