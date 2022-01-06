<?php

namespace App\Controllers;

use App\Models\DetailKelompokDosenModel;
use App\Models\KelompokDosenModel;
use App\Models\DosenPembimbingModel;

class DetailKelompokDosen extends BaseController
{
    protected $detailkelompokDosenModel;
    protected $kelompokDosenModel;
    protected $dosenPembimbingModel;
    public function __construct()
    {
        $this->detailkelompokDosenModel = new DetailKelompokDosenModel();
        $this->kelompokDosenModel = new KelompokDosenModel();
        $this->dosenPembimbingModel = new DosenPembimbingModel();
    }
    public function index()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('dosen_kelompok_detail');
        $builder->select('*');
        $builder->join('dosen_kelompok', 'dosen_kelompok.dosenKelompokId = dosen_kelompok_detail.detKelompokDosenKelompokId');
        $builder->join('dosen_pembimbing', 'dosen_pembimbing.dopingId  = dosen_kelompok_detail.detKelompokDopingId');
        $query = $builder->get();

        $data = [
            'title' => "Detail Kelompok Dosen",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Detail Kelompok Dosen'],
            'detailDosen' => $query->getResult(),
            'detailkelompokDosen' => $this->detailkelompokDosenModel->findAll(),
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
                    'required' => 'Nama Kelompok Dosen Harus Dipilih!',
                ]
            ],
            'detKelompokDopingId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Dosen Harus Dipilih!',
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

        if ($this->detailkelompokDosenModel->insert($data)) {
            session()->setFlashdata('success', 'Data Detail Kelompok Dosen Berhasil Ditambah!');
            return redirect()->to('detailKelompokDosen');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'detKelompokDosenKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Dosen Harus Dipilih!',
                ]
            ],
            'detKelompokDopingId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Dosen Harus Dipilih!',
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

        if ($this->detailkelompokDosenModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Detail Kelompok Dosen Berhasil Diupdate!');
            return redirect()->to('detailKelompokDosen');
        }
    }

    public function delete($id)
    {
        if ($this->detailkelompokDosenModel->delete($id)) {
            session()->setFlashdata('success', 'Data Detail Kelompok Dosen Berhasil Dihapus!');
        };
        return redirect()->to('detailKelompokDosen');
    }
}
