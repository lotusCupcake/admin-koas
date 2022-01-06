<?php

namespace App\Controllers;

use App\Models\KelompokMahasiswaModel;
use App\Models\DataKelompokModel;

class KelompokMahasiswa extends BaseController
{
    protected $dataKelompokModel;
    protected $kelompokMahasiswaModel;
    protected $db;
    protected $curl;
    public function __construct()
    {
        $this->dataKelompokModel = new DataKelompokModel();
        $this->kelompokMahasiswaModel = new KelompokMahasiswaModel();
        $this->db = \Config\Database::connect();
        $this->curl = service('curlrequest');
    }
    public function index()
    {

        $builder = $this->db->table('kelompok_detail');
        $builder->select('*');
        $builder->join('kelompok', 'kelompok.kelompokId = kelompok_detail.kelompokDetKelompokId');
        $query = $builder->get();

        $data = [
            'title' => "Kelompok Mahasiswa",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Kelompok Mahasiswa'],
            'kelompokMahasiswa' => $this->kelompokMahasiswaModel->findAll(),
            'dataKelompok' => $this->dataKelompokModel->findAll(),
            'kelompok' => $query->getResult(),
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

    public function add()
    {
        if (!$this->validate([
            'kelompokDetKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Mahasiswa Harus Dipilih!',
                ]
            ],
            'kelompokDetNim' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Mahasiswa Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('kelompokMahasiswa')->withInput();
        }

        // dd($_POST);
        $data = array(
            'kelompokDetKelompokId' => trim($this->request->getPost('kelompokDetKelompokId')),
            'kelompokDetNim' => trim($this->request->getPost('kelompokDetNim')),
        );

        if ($this->kelompokMahasiswaModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kelompok Mahasiswa Berhasil Ditambah!');
            return redirect()->to('kelompokMahasiswa');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'kelompokDetKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Mahasiswa Harus Dipilih!',
                ]
            ],
            'kelompokDetNim' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Mahasiswa Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('kelompokMahasiswa')->withInput();
        }

        // dd($_POST);
        $data = array(
            'kelompokDetKelompokId' => trim($this->request->getPost('kelompokDetKelompokId')),
            'kelompokDetNim' => trim($this->request->getPost('kelompokDetNim')),
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
