<?php

namespace App\Controllers;

use App\Models\PanduanModel;

class Panduan extends BaseController
{
    protected $panduanModel;
    public function __construct()
    {
        $this->panduanModel = new PanduanModel();
    }
    public function index()
    {
        $data = [
            'title' => "Panduan",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Data', 'Panduan'],
            'panduan' => $this->panduanModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/panduan', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'panduanNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Panduan Harus Diisi!',
                ]
            ],
            // 'panduanFile' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'File Panduan Harus Dipilih!',
            //     ]
            // ],
        ])) {
            return redirect()->to('panduan')->withInput();
        }

        // dd($_POST);
        $data = array(
            'panduanNama' => trim($this->request->getPost('panduanNama')),
            'panduanStatus' => trim($this->request->getPost('panduanStatus')) == null ? 0 : 1
        );

        if ($this->panduanModel->insert($data)) {
            session()->setFlashdata('success', 'Panduan Profesi Berhasil Ditambah!');
            return redirect()->to('panduan');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'panduanNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Panduan Harus Diisi!',
                ]
            ],
            // 'panduanFile' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'File Panduan Harus Dipilih!',
            //     ]
            // ],
        ])) {
            return redirect()->to('panduan')->withInput();
        }

        // dd($_POST);
        $data = array(
            'panduanNama' => trim($this->request->getPost('panduanNama')),
            'panduanStatus' => trim($this->request->getPost('panduanStatus')) == null ? 0 : 1
        );

        if ($this->panduanModel->update($data, $id)) {
            session()->setFlashdata('success', 'Panduan Profesi Berhasil Diupdate!');
            return redirect()->to('panduan');
        }
    }

    public function delete($id)
    {
        if ($this->panduanModel->delete($id)) {
            session()->setFlashdata('success', 'Panduan Profesi Berhasil Dihapus!');
        };
        return redirect()->to('panduan');
    }
}
