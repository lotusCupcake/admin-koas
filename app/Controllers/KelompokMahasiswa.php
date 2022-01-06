<?php

namespace App\Controllers;

use App\Models\KelompokMahasiswaModel;

class KelompokMahasiswa extends BaseController
{
    protected $kelompokMahasiswaModel;
    public function __construct()
    {
        $this->kelompokMahasiswaModel = new KelompokMahasiswaModel();
    }
    public function index()
    {
        $data = [
            'title' => "Kelompok Mahasiswa",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Kelompok Mahasiswa'],
            'kelompokMahasiswa' => $this->kelompokMahasiswaModel->findAll(),
            'mahasiswaProfesi' => $this->getMahasiswa(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/kelompokMahasiswa', $data);
    }

    public function getMahasiswa()
    {
        $response = $this->curl->request("GET", "https://api.umsu.ac.id/koas/mahasiswa", [
            "headers" => [
                "Accept" => "application/json"
            ],

        ]);

        return json_decode($response->getBody())->data;
    }

    // batas sampai sini, belum page

    public function add()
    {
        if (!$this->validate([
            'dosenKelompokNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Mahasiswa Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('kelompokMahasiswa')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dosenKelompokNama' => trim($this->request->getPost('dosenKelompokNama')),
        );

        if ($this->kelompokMahasiswaModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kelompok Mahasiswa Berhasil Ditambah!');
            return redirect()->to('kelompokMahasiswa');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'dosenKelompokNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Mahasiswa Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('kelompokMahasiswa')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dosenKelompokNama' => trim($this->request->getPost('dosenKelompokNama')),
        );

        if ($this->kelompokMahasiswaModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kelompok Mahasiswa Berhasil Diupdate!');
            return redirect()->to('kelompokMahasiswa');
        }
    }

    public function delete($id)
    {
        if ($this->kelompokMahasiswaModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kelompok Mahasiswa Berhasil Dihapus!');
        };
        return redirect()->to('kelompokMahasiswa');
    }
}
