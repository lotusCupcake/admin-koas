<?php

namespace App\Controllers;

use App\Models\JadwalSkipModel;

class JadwalSkip extends BaseController
{
    protected $JadwalSkipModel;

    public function __construct()
    {
        $this->jadwalSkipModel = new JadwalSkipModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_jadwalSkip') ? $this->request->getVar('page_jadwalSkip') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $jadwalSkip = $this->jadwalSkipModel->getJadwalSkipSearch($keyword);
        } else {
            $jadwalSkip = $this->jadwalSkipModel->getJadwalSkip();
        }

        $data = [
            'title' => "Penundaan Jadwal",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Penundaan Jadwal'],
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'jadwalSkip' => $jadwalSkip->paginate($this->numberPage, 'jadwalSkip'),
            'pager' => $jadwalSkip->pager,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
        ];
        // dd($data['jadwalSkip']);
        return view('pages/jadwalSkip', $data);
    }
}
