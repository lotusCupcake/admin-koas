<?php

namespace App\Controllers;

use App\Models\DataKelompokModel;
use App\Models\KelompokDosenModel;

class DataKelompok extends BaseController
{
    protected $dataKelompokModel;
    protected $kelompokDosenModel;
    protected $db;
    public function __construct()
    {
        $this->dataKelompokModel = new DataKelompokModel();
        $this->kelompokDosenModel = new KelompokDosenModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {

        $builder = $this->db->table('kelompok');
        $builder->select('*');
        $builder->join('dosen_kelompok', 'dosen_kelompok.dosenKelompokId = kelompok.kelompokDosenKelompokId');
        $query = $builder->get();

        $data = [
            'title' => "Data Kelompok",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Data Kelompok'],
            'dosen' => $query->getResult(),
            'dataKelompok' => $this->dataKelompokModel->findAll(),
            'kelompokDosen' => $this->kelompokDosenModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dataKelompok', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'kelompokNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Harus Diisi!',
                ]
            ],
            'kelompokDosenKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Dosen Harus Dipilih!',
                ]
            ],
            'kelompokTahunAkademik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun Akademik Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('dataKelompok')->withInput();
        }

        // dd($_POST);
        $data = array(
            'kelompokNama' => trim($this->request->getPost('kelompokNama')),
            'kelompokDosenKelompokId' => trim($this->request->getPost('kelompokDosenKelompokId')),
            'kelompokTahunAkademik' => trim($this->request->getPost('kelompokTahunAkademik')),
        );

        if ($this->dataKelompokModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kelompok Berhasil Ditambah!');
            return redirect()->to('dataKelompok');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'kelompokNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Harus Diisi!',
                ]
            ],
            'kelompokDosenKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Dosen Harus Dipilih!',
                ]
            ],
            'kelompokTahunAkademik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun Akademik Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('dataKelompok')->withInput();
        }

        // dd($_POST);
        $data = array(
            'kelompokNama' => trim($this->request->getPost('kelompokNama')),
            'kelompokDosenKelompokId' => trim($this->request->getPost('kelompokDosenKelompokId')),
            'kelompokTahunAkademik' => trim($this->request->getPost('kelompokTahunAkademik')),
        );

        if ($this->dataKelompokModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kelompok Berhasil Diupdate!');
            return redirect()->to('dataKelompok');
        }
    }

    public function delete($id)
    {
        if ($this->dataKelompokModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kelompok Berhasil Dihapus!');
        };
        return redirect()->to('dataKelompok');
    }
}
