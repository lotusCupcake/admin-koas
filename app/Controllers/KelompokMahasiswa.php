<?php

namespace App\Controllers;

use App\Models\KelompokMahasiswaModel;

class KelompokMahasiswa extends BaseController
{
    protected $kelompokMahasiswaModel;
    protected $db;
    public function __construct()
    {
        $this->kelompokMahasiswaModel = new KelompokMahasiswaModel();
        $this->db = \Config\Database::connect();
        $this->curl = service('curlrequest');
    }
    public function index()
    {
        $data = [
            'title' => "Kelompok Mahasiswa",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Kelompok Mahasiswa'],
            'kelompok' => $this->kelompokMahasiswaModel->getKelompok()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/kelompokMahasiswa', $data);
    }

    public function delete($id)
    {
        if ($this->kelompokMahasiswaModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kelompok Mahasiswa Berhasil Dihapus!');
        };
        return redirect()->to('kelompokMahasiswa');
    }
}
