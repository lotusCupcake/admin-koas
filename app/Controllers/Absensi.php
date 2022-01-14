<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class Absensi extends BaseController
{
    protected $AbsensiModel;
    protected $pager;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->pager = \Config\Services::pager();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_absensi') != null ? $this->request->getVar('page_absensi') : 1;
        $data = [
            'title' => "Absensi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Absensi'],
            'currentPage' => $currentPage,
            'absensi' => $this->absensiModel->absensiPaginate(5, 'absensi'),
            'pager' => $this->absensiModel->pager,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
        ];
        // dd($data);
        return view('pages/absensiMahasiswa', $data);
    }
}
