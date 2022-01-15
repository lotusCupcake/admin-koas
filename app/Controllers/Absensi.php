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
        $currentPage = $this->request->getVar('absensi') ? $this->request->getVar('absensi') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $absen = $this->absensiModel->searchAbsensi($keyword);
        } else {
            $absen = $this->absensiModel->absensiPaginate();
        }

        $data = [
            'title' => "Absensi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Absensi'],
            'currentPage' => $currentPage,
            'absensi' => $absen->paginate(5, 'absensi'),
            'pager' => $this->absensiModel->pager,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
        ];
        return view('pages/absensiMahasiswa', $data);
    }
}
