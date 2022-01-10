<?php

namespace App\Controllers;

use App\Models\DataKelompokModel;
use App\Models\KelompokDosenModel;
use App\Models\KelompokMahasiswaModel;

class DataKelompok extends BaseController
{
    protected $dataKelompokModel;
    protected $kelompokDosenModel;
    protected $kelompokMahasiswaModel;
    protected $db;
    protected $curl;
    public function __construct()
    {
        $this->dataKelompokModel = new DataKelompokModel();
        $this->kelompokMahasiswaModel = new KelompokMahasiswaModel();
        $this->kelompokDosenModel = new KelompokDosenModel();
        $this->db = \Config\Database::connect();
        $this->curl = service('curlrequest');
    }
    public function index()
    {
        $data = [
            'title' => "Kelompok",
            'appName' => "KOAS",
            'breadcrumb' => ['Master', 'Penugasan', 'Kelompok'],
            'dataKelompok' => $this->dataKelompokModel->getDataKelompok()->getResult(),
            'kelompokDosen' => $this->kelompokDosenModel->findAll(),
            'mahasiswaProfesi' => $this->getMahasiswa(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dataKelompok', $data);
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
            'kelompokNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Mahasiswa Harus Diisi!',
                ]
            ],
            'kelompokDosenKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Dosen Harus Dipilih!',
                ]
            ],
            'kelompokTahunAkademik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('dataKelompok')->withInput();
        }

        // dd($_POST);
        $data = array(
            'kelompokNama' => trim($this->request->getPost('kelompokNama')),
            'kelompokDosenKelompokId' => trim($this->request->getPost('kelompokDosenKelompokId')),
            'kelompokTahunAkademik' => trim($this->request->getPost('kelompokTahunAkademik')),
        );

        if ($this->dataKelompokModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kelompok Berhasil Ditambah!');
            return redirect()->to('dataKelompok');
        }
    }

    public function tambahPartisipan()
    {
        // dd($_POST);
        if (!$this->validate([
            'mahasiswa' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mahasiswa Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('dataKelompok')->withInput();
        }


        // // dd($_POST);
        $listMhs = $this->request->getPost('mahasiswa');
        foreach ($listMhs as $dt) {
            $jumlah = $this->kelompokMahasiswaModel->dataExist([
                'kelompokDetKelompokId' => trim($this->request->getPost('kelompokId')),
                'kelompokDetNim' => explode(',', $dt)[0]
            ]);
            if ($jumlah < 1) {
                $data = array(
                    'kelompokDetKelompokId' => trim($this->request->getPost('kelompokId')),
                    'kelompokDetNim' => explode(',', $dt)[0],
                    'kelompokDetNama' => explode(',', $dt)[1]
                );
                $this->kelompokMahasiswaModel->insert($data);
            }
        }
        session()->setFlashdata('success', 'Data Mahasiswa Berhasil Ditambah Ke Dalam Kelompok!');
        return redirect()->to('dataKelompok');
    }

    public function edit($id)
    {
        if (!$this->validate([
            'kelompokNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Mahasiswa Harus Diisi!',
                ]
            ],
            'kelompokDosenKelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Dosen Harus Dipilih!',
                ]
            ],
            'kelompokTahunAkademik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('dataKelompok')->withInput();
        }

        // dd($_POST);
        $data = array(
            'kelompokNama' => trim($this->request->getPost('kelompokNama')),
            'kelompokDosenKelompokId' => trim($this->request->getPost('kelompokDosenKelompokId')),
            'kelompokTahunAkademik' => trim($this->request->getPost('kelompokTahunAkademik')),
        );

        if ($this->dataKelompokModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kelompok Berhasil Diupdate!');
            return redirect()->to('dataKelompok');
        }
    }

    public function delete($id)
    {
        if ($this->dataKelompokModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kelompok Berhasil Dihapus!');
        };
        return redirect()->to('dataKelompok');
    }
}
