<?php

namespace App\Controllers;

use App\Models\KelompokMahasiswaModel;
use App\Models\DataKelompokModel;

class KelompokMahasiswa extends BaseController
{
    protected $kelompokMahasiswaModel;
    protected $dataKelompokModel;
    public function __construct()
    {
        $this->kelompokMahasiswaModel = new KelompokMahasiswaModel();
        $this->dataKelompokModel = new DataKelompokModel();
        $this->curl = service('curlrequest');
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_kelompok') ? $this->request->getVar('page_kelompok') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $kelompok = $this->dataKelompokModel->getDataKelompokSearch($keyword);
        } else {
            $kelompok = $this->dataKelompokModel->getDataKelompok();
        }

        $data = [
            'title' => "Kel. Mahasiswa",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Data', 'Kel. Mahasiswa'],
            'kelompokDetail' => $this->kelompokMahasiswaModel->findAll(),
            'kelompok' => $kelompok->paginate(5, 'kelompok'),
            'pager' => $this->dataKelompokModel->pager,
            'currentPage' => $currentPage,
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
