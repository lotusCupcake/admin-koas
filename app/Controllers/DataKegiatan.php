<?php

namespace App\Controllers;

use App\Models\DataKegiatanModel;

class DataKegiatan extends BaseController
{
    protected $dataKegiatanModel;
    public function __construct()
    {
        $this->dataKegiatanModel = new DataKegiatanModel();
    }
    public function index()
    {
        $data = [
            'title' => "Kegiatan",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Data', 'Kegiatan'],
            'dataKegiatan' => $this->dataKegiatanModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dataKegiatan', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'kegiatanNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kegiatan Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('dataKegiatan')->withInput();
        }

        // dd($_POST);
        $data = array(
            'kegiatanNama' => trim($this->request->getPost('kegiatanNama')),
            'kegiatanStatus' => trim($this->request->getPost('kegiatanStatus')) == null ? 0 : 1,
        );

        if ($this->dataKegiatanModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kegiatan Berhasil Ditambah!');
            return redirect()->to('dataKegiatan');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'kegiatanNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kegiatan Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('dataKegiatan')->withInput();
        }

        // dd($_POST);
        $data = array(
            'kegiatanNama' => trim($this->request->getPost('kegiatanNama')),
            'kegiatanStatus' => trim($this->request->getPost('kegiatanStatus')) == null ? 0 : 1,
        );

        if ($this->dataKegiatanModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kegiatan Berhasil Diupdate!');
            return redirect()->to('dataKegiatan');
        }
    }

    public function delete($id)
    {
        if ($this->dataKegiatanModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kegiatan Berhasil Dihapus!');
        };
        return redirect()->to('dataKegiatan');
    }
}
