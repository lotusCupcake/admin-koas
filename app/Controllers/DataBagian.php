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
            'title' => "Data Bagian",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Data Bagian'],
            'dataBagian' => $this->dataBagianModel->whereNotIn('bagianId', [99])->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dataBagian', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'bagianNama' => [
                'rules' => 'required|is_unique[bagian.bagianNama]',
                'errors' => [
                    'required' => 'Nama Bagian Harus Diisi',
                    'is_unique' => 'Nama Bagian Sudah terdaftar',
                ]
            ],
        ])) {
            return redirect()->to('dataBagian')->withInput();
        }


        $data = array(
            'bagianNama' => $this->request->getPost('bagianNama'),
        );

        if ($this->dataBagianModel->insert($data)) {
            session()->setFlashdata('success', 'Data Bagian Berhasil Ditambah !');
            return redirect()->to('dataBagian');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'bagianNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Bagian Harus Diisi',
                ]
            ],
        ])) {
            return redirect()->to('dataBagian')->withInput();
        }


        $data = array(
            'bagianNama' => $this->request->getPost('bagianNama'),
        );

        if ($this->dataBagianModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Bagian Berhasil Ditambah !');
            return redirect()->to('dataBagian');
        }
    }

    public function delete($id)
    {
        if ($this->dataBagianModel->delete($id)) {
            session()->setFlashdata('success', 'Data Bagian Berhasil Dihapus !');
        };
        return redirect()->to('dataBagian');
    }
}
