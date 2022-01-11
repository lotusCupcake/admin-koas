<?php

namespace App\Controllers;

use App\Models\DataBagianModel;

class DataBagian extends BaseController
{
    protected $dataBagianModel;
    public function __construct()
    {
        $this->dataBagianModel = new DataBagianModel();
    }
    public function index()
    {
        $data = [
            'title' => "Stase",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Data', 'Stase'],
            'dataBagian' => $this->dataBagianModel->whereNotIn('staseId', [99])->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dataBagian', $data);
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
            'staseType' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Type Form Nilai Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('dataBagian')->withInput();
        }

        // dd($_POST);
        $data = array(
            'staseNama' => trim($this->request->getPost('staseNama')),
            'staseJumlahWeek' => trim($this->request->getPost('staseJumlahWeek')),
            'staseType' => trim($this->request->getPost('staseType')),
        );

        if ($this->dataBagianModel->insert($data)) {
            session()->setFlashdata('success', 'Data Stase Berhasil Ditambah!');
            return redirect()->to('dataBagian');
        }
    }

    public function edit($id)
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
            'staseType' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Type Form Nilai Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('dataBagian')->withInput();
        }

        // dd($_POST);
        $data = array(
            'staseNama' => trim($this->request->getPost('staseNama')),
            'staseJumlahWeek' => trim($this->request->getPost('staseJumlahWeek')),
            'staseType' => trim($this->request->getPost('staseType')),
        );

        if ($this->dataBagianModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Stase Berhasil Diupdate!');
            return redirect()->to('dataBagian');
        }
    }

    public function delete($id)
    {
        if ($this->dataBagianModel->delete($id)) {
            session()->setFlashdata('success', 'Data Stase Berhasil Dihapus!');
        };
        return redirect()->to('dataBagian');
    }
}
