<?php

namespace App\Controllers;

use App\Models\StaseRumahSakitModel;
use App\Models\DataRumahSakitModel;
use App\Models\StaseModel;

class StaseRumahSakit extends BaseController
{
    protected $staseRumahSakitModel;
    protected $dataRumahSakitModel;
    protected $staseModel;
    protected $db;
    public function __construct()
    {
        $this->staseRumahSakitModel = new StaseRumahSakitModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
        $this->staseModel = new StaseModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $builder = $this->staseRumahSakitModel->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $namars = [];
        foreach ($builder->findAll() as $k) {
            array_push($namars, $k->rumahSakitNama);
        }

        $data = [
            'title' => "Stase Di RS",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Penugasan', 'Stase Di RS'],
            'staseRumahSakit' => $this->staseRumahSakitModel->getStaseRS()->getResult(),
            'dataRumahSakit' => $this->dataRumahSakitModel,
            'dataBagian' => $this->staseModel,
            'dataNamaRs' => $namars,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        // dd($data);
        return view('pages/staseRumahSakit', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'detRumkit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rumah Sakit Harus Dipilih!',
                ]
            ],
            'detStase' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('staseRumahSakit')->withInput();
        }

        // dd($_POST);
        $data = array(
            'rumkitDetRumkitId' => trim($this->request->getPost('detRumkit')),
            'rumkitDetStaseId' => trim($this->request->getPost('detStase')),
            'rumkitDetStatus' => trim($this->request->getPost('detStatus')) == null ? 0 : 1
        );

        if ($this->staseRumahSakitModel->insert($data)) {
            session()->setFlashdata('success', 'Stase Di RS Berhasil Ditambah!');
            return redirect()->to('staseRumahSakit');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'detRumkit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rumah Sakit Harus Dipilih!',
                ]
            ],
            'detStase' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('staseRumahSakit')->withInput();
        }


        $data = array(
            'rumkitDetRumkitId' => trim($this->request->getPost('detRumkit')),
            'rumkitDetStaseId' => trim($this->request->getPost('detStase')),
            'rumkitDetStatus' => trim($this->request->getPost('detStatus')) == null ? 0 : 1
        );

        // dd($this->request->getPost('rumahSakitEmail'));

        if ($this->staseRumahSakitModel->update($id, $data)) {
            session()->setFlashdata('success', 'Stase Di RS Berhasil Diupdate!');
            return redirect()->to('staseRumahSakit');
        }
    }

    public function delete($id)
    {
        if ($this->staseRumahSakitModel->delete($id)) {
            session()->setFlashdata('success', 'Stase Di RS Berhasil Dihapus!');
        };
        return redirect()->to('staseRumahSakit');
    }
}
