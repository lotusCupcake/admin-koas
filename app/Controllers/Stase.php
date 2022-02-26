<?php

namespace App\Controllers;

use App\Models\StaseModel;

class Stase extends BaseController
{
    protected $staseModel;
    public function __construct()
    {
        $this->staseModel = new StaseModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_stase') ? $this->request->getVar('page_stase') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $stase = $this->staseModel->getStaseSearch($keyword);
        } else {
            $stase = $this->staseModel->getStase();
        }
        $data = [
            'title' => "Stase",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Data', 'Stase'],
            'stase' => $stase->paginate($this->numberPage, 'stase'),
            'pager' => $this->staseModel->pager,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/stase', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'staseNama' => [
                'rules' => 'required|is_unique[stase.staseNama]',
                'errors' => [
                    'required' => 'Nama Stase Harus Diisi!',
                    'is_unique' => 'Nama Stase Sudah terdaftar!',
                ]
            ],
            'staseJumlahWeek' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Durasi Stase Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('stase')->withInput();
        }

        // dd($_POST);
        $data = array(
            'staseNama' => trim($this->request->getPost('staseNama')),
            'staseJumlahWeek' => trim($this->request->getPost('staseJumlahWeek')),
        );

        if ($this->staseModel->insert($data)) {
            session()->setFlashdata('success', 'Data Stase Berhasil Ditambah!');
            return redirect()->to('stase');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'staseNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Stase Harus Diisi!',
                ]
            ],
            'staseJumlahWeek' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Durasi Stase Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('stase')->withInput();
        }

        // dd($_POST);
        $data = array(
            'staseNama' => trim($this->request->getPost('staseNama')),
            'staseJumlahWeek' => trim($this->request->getPost('staseJumlahWeek')),
        );

        if ($this->staseModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Stase Berhasil Diupdate!');
            return redirect()->to('stase');
        }
    }

    public function delete($id)
    {
        if ($this->staseModel->delete($id)) {
            session()->setFlashdata('success', 'Data Stase Berhasil Dihapus!');
        };
        return redirect()->to('stase');
    }
}
