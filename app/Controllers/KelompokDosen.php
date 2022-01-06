<?php

namespace App\Controllers;

use App\Models\KelompokDosenModel;

class KelompokDosen extends BaseController
{
    protected $kelompokDosenModel;
    public function __construct()
    {
        $this->kelompokDosenModel = new KelompokDosenModel();
    }
    public function index()
    {
        $data = [
            'title' => "Kelompok Dosen",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Kelompok Dosen'],
            'kelompokDosen' => $this->kelompokDosenModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/kelompokDosen', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'dosenKelompokNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Dosen Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('kelompokDosen')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dosenKelompokNama' => trim($this->request->getPost('dosenKelompokNama')),
        );

        if ($this->kelompokDosenModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kelompok Dosen Berhasil Ditambah!');
            return redirect()->to('kelompokDosen');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'dosenKelompokNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Dosen Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('kelompokDosen')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dosenKelompokNama' => trim($this->request->getPost('dosenKelompokNama')),
        );

        if ($this->kelompokDosenModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kelompok Dosen Berhasil Diupdate!');
            return redirect()->to('kelompokDosen');
        }
    }

    public function delete($id)
    {
        if ($this->kelompokDosenModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kelompok Dosen Berhasil Dihapus!');
        };
        return redirect()->to('kelompokDosen');
    }
}
