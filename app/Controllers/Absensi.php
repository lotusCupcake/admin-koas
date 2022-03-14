<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\UsersModel;
use App\Models\DosenPembimbingModel;

class Absensi extends BaseController
{
    protected $AbsensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->dosenPembimbingModel = new DosenPembimbingModel();
        $this->usersModel = new UsersModel();
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
        return view('pages/absensiMahasiswa', $data);
    }
}
