<?php

namespace App\Controllers;

use App\Models\DosenPembimbingModel;

class DosenPembimbing extends BaseController
{
    protected $dosenPembimbingModel;
    public function __construct()
    {
        $this->dosenPembimbingModel = new DosenPembimbingModel();
    }

    public function index()
    {
        $data = [
            'title' => "Dosen Pembimbing",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Dosen Pembimbing'],
            'dosenPembimbing' => $this->dosenPembimbingModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dosenPembimbing', $data);
    }

    public function add()
    {
        if (!$this->validate([
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
        ])) {
            return redirect()->to('dataRumahSakit')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dopingNamaLengkap' => trim($this->request->getPost('dopingNamaLengkap')),
            'dopingEmail' => trim($this->request->getPost('dopingEmail')),
            'dopingNoHandphone' => trim($this->request->getPost('dopingNoHandphone')),
            'dopingAlamat' => trim($this->request->getPost('dopingAlamat')),
        );

        if ($this->dosenPembimbingModel->insert($data)) {
            session()->setFlashdata('success', 'Data Dosen Pembimbing Berhasil Ditambah!');
            return redirect()->to('dosenPembimbing');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
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
        ])) {
            return redirect()->to('dosenPembimbing')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dopingNamaLengkap' => trim($this->request->getPost('dopingNamaLengkap')),
            'dopingEmail' => trim($this->request->getPost('dopingEmail')),
            'dopingNoHandphone' => trim($this->request->getPost('dopingNoHandphone')),
            'dopingAlamat' => trim($this->request->getPost('dopingAlamat')),
        );

        if ($this->dosenPembimbingModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Dosen Pembimbing Berhasil Diupdate!');
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
