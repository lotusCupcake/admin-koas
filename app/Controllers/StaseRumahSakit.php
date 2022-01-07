<?php

namespace App\Controllers;

use App\Models\StaseRumahSakitModel;
use App\Models\DataRumahSakitModel;
use App\Models\DataBagianModel;

class StaseRumahSakit extends BaseController
{
    protected $staseRumahSakitModel;
    protected $dataRumahSakitModel;
    protected $dataBagianModel;
    protected $db;
    public function __construct()
    {
        $this->staseRumahSakitModel = new StaseRumahSakitModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
        $this->dataBagianModel = new DataBagianModel();
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
            'title' => "Stase Rumah Sakit",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Stase Rumah Sakit'],
            'staseRumahSakit' => $this->staseRumahSakitModel->getStaseRS()->getResult(),
            'dataRumahSakit' => $this->dataRumahSakitModel,
            'dataBagian' => $this->dataBagianModel,
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
            session()->setFlashdata('success', 'Stase Rumah Sakit Berhasil Ditambah!');
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
            session()->setFlashdata('success', 'Stase Rumah Sakit Berhasil Diupdate!');
            return redirect()->to('staseRumahSakit');
        }
    }

    public function delete($id)
    {
        if ($this->staseRumahSakitModel->delete($id)) {
            session()->setFlashdata('success', 'Stase Rumah Sakit Berhasil Dihapus!');
        };
        return redirect()->to('staseRumahSakit');
    }
}
