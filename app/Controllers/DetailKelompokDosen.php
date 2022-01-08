<?php

namespace App\Controllers;

use App\Models\DetailKelompokDosenModel;
use App\Models\KelompokDosenModel;
use App\Models\DosenPembimbingModel;

class DetailKelompokDosen extends BaseController
{
    protected $detailKelompokDosenModel;
    protected $kelompokDosenModel;
    protected $dosenPembimbingModel;
    protected $db;
    public function __construct()
    {
        $this->detailKelompokDosenModel = new DetailKelompokDosenModel();
        $this->kelompokDosenModel = new KelompokDosenModel();
        $this->dosenPembimbingModel = new DosenPembimbingModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $data = [
            'title' => "Dosen",
            'appName' => "KOAS",
            'breadcrumb' => ['Master', 'Penugasan', 'Dosen'],
            'detailkelompokDosen' => $this->detailKelompokDosenModel->getDetailDosen()->getResult(),
            'kelompokDosen' => $this->kelompokDosenModel->findAll(),
            'dosenPembimbing' => $this->dosenPembimbingModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/detailKelompokDosen', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'detKelompokDosenKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Grup Dosen Harus Dipilih!',
                ]
            ],
            'detKelompokDopingId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dosen Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('detailKelompokDosen')->withInput();
        }

        // dd($_POST);
        $data = array(
            'detKelompokDosenKelompokId' => trim($this->request->getPost('detKelompokDosenKelompokId')),
            'detKelompokDopingId' => trim($this->request->getPost('detKelompokDopingId')),
        );

        if ($this->detailKelompokDosenModel->insert($data)) {
            session()->setFlashdata('success', 'Data Dosen Berhasil Ditambah!');
            return redirect()->to('detailKelompokDosen');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'detKelompokDosenKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Dosen Harus Dipilih!',
                ]
            ],
            'detKelompokDopingId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dosen Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('detailKelompokDosen')->withInput();
        }

        // dd($_POST);
        $data = array(
            'detKelompokDosenKelompokId' => trim($this->request->getPost('detKelompokDosenKelompokId')),
            'detKelompokDopingId' => trim($this->request->getPost('detKelompokDopingId')),
        );

        if ($this->detailKelompokDosenModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Dosen Berhasil Diupdate!');
            return redirect()->to('detailKelompokDosen');
        }
    }

    public function delete($id)
    {
        if ($this->detailKelompokDosenModel->delete($id)) {
            session()->setFlashdata('success', 'Data Dosen Berhasil Dihapus!');
        };
        return redirect()->to('detailKelompokDosen');
    }
}
