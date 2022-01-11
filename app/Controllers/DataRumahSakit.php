<?php

namespace App\Controllers;

use App\Models\DataRumahSakitModel;

class DataRumahSakit extends BaseController
{
    protected $dataRumahSakitModel;
    public function __construct()
    {
        $this->dataRumahSakitModel = new DataRumahSakitModel();
    }
    public function index()
    {
        $data = [
            'title' => "Data Rumah Sakit",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Data', 'Rumah Sakit'],
            'dataRumahSakit' => $this->dataRumahSakitModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dataRumahSakit', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'rumahSakitNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitShortname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Shortname Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitLat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Koordinat Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitLong' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Koordinat Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitTelp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Telp Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitEmail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Rumah Sakit Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('dataRumahSakit')->withInput();
        }

        // dd($_POST);
        $data = array(
            'rumahSakitNama' => trim($this->request->getPost('rumahSakitNama')),
            'rumahSakitShortname' => trim($this->request->getPost('rumahSakitShortname')),
            'rumahSakitLatLong' => trim($this->request->getPost('rumahSakitLat')) . ',' . trim($this->request->getPost('rumahSakitLong')),
            'rumahSakitTelp' => trim($this->request->getPost('rumahSakitTelp')),
            'rumahSakitEmail' => trim($this->request->getPost('rumahSakitEmail')),
            'rumahSakitWarna' => trim($this->request->getPost('rumahSakitWarna')),
        );

        if ($this->dataRumahSakitModel->insert($data)) {
            session()->setFlashdata('success', 'Data Rumah Sakit Berhasil Ditambah!');
            return redirect()->to('dataRumahSakit');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'rumahSakitNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitShortname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Shortname Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitLat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Koordinat Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitLong' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Koordinat Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitTelp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Telp Rumah Sakit Harus Diisi!',
                ]
            ],
            'rumahSakitEmail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Rumah Sakit Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('dataRumahSakit')->withInput();
        }


        $data = array(
            'rumahSakitNama' => trim($this->request->getPost('rumahSakitNama')),
            'rumahSakitShortname' => trim($this->request->getPost('rumahSakitShortname')),
            'rumahSakitLatLong' => trim($this->request->getPost('rumahSakitLat')) . ',' . trim($this->request->getPost('rumahSakitLong')),
            'rumahSakitTelp' => trim($this->request->getPost('rumahSakitTelp')),
            'rumahSakitEmail' => trim($this->request->getPost('rumahSakitEmail')),
            'rumahSakitWarna' => trim($this->request->getPost('rumahSakitWarna')),
        );

        // dd($this->request->getPost('rumahSakitEmail'));

        if ($this->dataRumahSakitModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Rumah Sakit Berhasil Diupdate!');
            return redirect()->to('dataRumahSakit');
        }
    }

    public function delete($id)
    {
        if ($this->dataRumahSakitModel->delete($id)) {
            session()->setFlashdata('success', 'Data Rumah Sakit Berhasil Dihapus!');
        };
        return redirect()->to('dataRumahSakit');
    }
}
