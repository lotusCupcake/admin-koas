<?php

namespace App\Controllers;

use App\Models\DosenPembimbingModel;
use App\Models\DataBagianModel;

class DosenPembimbing extends BaseController
{
    protected $dosenPembimbingModel;
    protected $dataBagianModel;
    public function __construct()
    {
        $this->dosenPembimbingModel = new DosenPembimbingModel();
        $this->dataBagianModel = new DataBagianModel();
    }

    public function index()
    {
        $data = [
            'title' => "Dosen Pembimbing",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Dosen Pembimbing'],
            'dosenPembimbing' => $this->dosenPembimbingModel->join('stase', 'stase.staseId = dosen_pembimbing.dopingStaseId', 'LEFT')->findAll(),
            'dataBagian' => $this->dataBagianModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dosenPembimbing', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'dopingNIDN' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIDN Dosen Harus Diisi!',
                ]
            ],
            'dopingNamaLengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Dan Gelar Dosen Harus Diisi!',
                ]
            ],
            'dopingEmail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Dosen Harus Diisi!',
                ]
            ],
            'dopingNoHandphone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Telp Dosen Harus Diisi!',
                ]
            ],
            'dopingAlamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Dosen Harus Diisi!',
                ]
            ],
            'dopingStaseId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('dataRumahSakit')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dopingNIDN' => trim($this->request->getPost('dopingNIDN')),
            'dopingNamaLengkap' => trim($this->request->getPost('dopingNamaLengkap')),
            'dopingEmail' => trim($this->request->getPost('dopingEmail')),
            'dopingNoHandphone' => trim($this->request->getPost('dopingNoHandphone')),
            'dopingAlamat' => trim($this->request->getPost('dopingAlamat')),
            'dopingStaseId' => trim($this->request->getPost('dopingStaseId')),
        );

        if ($this->dosenPembimbingModel->insert($data)) {
            session()->setFlashdata('success', 'Data Dosen Pembimbing Berhasil Ditambah!');
            return redirect()->to('dosenPembimbing');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'dopingNIDN' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIDN Dosen Harus Diisi!',
                ]
            ],
            'dopingNamaLengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Dan Gelar Dosen Harus Diisi!',
                ]
            ],
            'dopingEmail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Dosen Harus Diisi!',
                ]
            ],
            'dopingNoHandphone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Telp Dosen Harus Diisi!',
                ]
            ],
            'dopingAlamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Dosen Harus Diisi!',
                ]
            ],
            'dopingStaseId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('dataRumahSakit')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dopingNIDN' => trim($this->request->getPost('dopingNIDN')),
            'dopingNamaLengkap' => trim($this->request->getPost('dopingNamaLengkap')),
            'dopingEmail' => trim($this->request->getPost('dopingEmail')),
            'dopingNoHandphone' => trim($this->request->getPost('dopingNoHandphone')),
            'dopingAlamat' => trim($this->request->getPost('dopingAlamat')),
            'dopingStaseId' => trim($this->request->getPost('dopingStaseId')),
        );

        if ($this->dosenPembimbingModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Dosen Pembimbing Berhasil Ditambah!');
            return redirect()->to('dosenPembimbing');
        }
    }

    public function delete($id)
    {
        if ($this->dosenPembimbingModel->delete($id)) {
            session()->setFlashdata('success', 'Data Dosen Pembimbing Berhasil Dihapus!');
        };
        return redirect()->to('dosenPembimbing');
    }
}
