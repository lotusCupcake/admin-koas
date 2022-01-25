<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class Absensi extends BaseController
{
    protected $AbsensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_absensi') ? $this->request->getVar('page_absensi') : 1;
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
            'numberPage' => $this->numberPage,
            'absensi' => $absen->paginate($this->numberPage, 'absensi'),
            'pager' => $absen->pager,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
        ];
        // dd($data);
        return view('pages/absensiMahasiswa', $data);
    }
}
