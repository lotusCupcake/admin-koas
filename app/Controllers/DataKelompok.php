<?php

namespace App\Controllers;

use App\Models\DataKelompokModel;
use App\Models\KelompokMahasiswaModel;

class DataKelompok extends BaseController
{
    protected $dataKelompokModel;
    protected $kelompokMahasiswaModel;
    protected $curl;
    public function __construct()
    {
        $this->dataKelompokModel = new DataKelompokModel();
        $this->kelompokMahasiswaModel = new KelompokMahasiswaModel();
        $this->curl = service('curlrequest');
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_kelompok') ? $this->request->getVar('page_kelompok') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $dataKelompok = $this->dataKelompokModel->getDataKelompokSearch($keyword);
        } else {
            $dataKelompok = $this->dataKelompokModel->getDataKelompok();
        }

        $data = [
            'title' => "Kelompok",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Penugasan', 'Kelompok'],
            'dataKelompok' => $dataKelompok->paginate($this->numberPage, 'kelompok'),
            'pager' => $this->dataKelompokModel->pager,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'mahasiswaProfesi' => $this->getMahasiswa(),
            'validation' => \Config\Services::validation(),
            'tahunAkademik' => getTahunAkademik(),
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
        ])) {
            return redirect()->to('dataKelompok')->withInput();
        }

        $data = array(
            'kelompokNama' => trim($this->request->getPost('kelompokNama')),
            'kelompokTahunAkademik' => trim($this->request->getPost('kelompokTahunAkademik')),
        );

        if ($this->dataKelompokModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kelompok Berhasil Ditambah!');
            return redirect()->to('dataKelompok');
        }
    }

    public function tambahPartisipan()
    {
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
        ])) {
            return redirect()->to('dataKelompok')->withInput();
        }

        $data = array(
            'kelompokNama' => trim($this->request->getPost('kelompokNama')),
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
