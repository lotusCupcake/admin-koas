<?php

namespace App\Controllers;

use App\Models\KelompokMahasiswaModel;
use App\Models\DataKelompokModel;

class KelompokMahasiswa extends BaseController
{
    protected $kelompokMahasiswaModel;
    protected $dataKelompokModel;
    protected $db;
    public function __construct()
    {
        $this->kelompokMahasiswaModel = new KelompokMahasiswaModel();
        $this->dataKelompokModel = new DataKelompokModel();
        $this->db = \Config\Database::connect();
        $this->curl = service('curlrequest');
    }
    public function index()
    {
        $data = [
            'title' => "Kel. Mahasiswa",
            'appName' => "KOAS",
            'breadcrumb' => ['Master', 'Data', 'Kel. Mahasiswa'],
            'kelompokDetail' => $this->kelompokMahasiswaModel->findAll(),
            'kelompok' => $this->dataKelompokModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        // dd($data);
        return view('pages/kelompokMahasiswa', $data);
    }

    public function delete($id)
    {
        if ($this->kelompokMahasiswaModel->delete($id)) {
            session()->setFlashdata('success', 'Data Mahasiswa Berhasil Dihapus Di Kelompok!');
        };
        return redirect()->to('kelompokMahasiswa');
    }
}
