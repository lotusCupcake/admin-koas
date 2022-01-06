<?php

namespace App\Controllers;

use App\Models\JadwalKegiatanModel;
// use App\Models\DataBagianModel;
// use App\Models\DataRumahSakitModel;

class JadwalKegiatan extends BaseController
{
    protected $jadwalKegiatanModel;
    // protected $DataBagianModel;
    // protected $DataRumahSakitModel;
    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        // $this->penyiarModel = new DataBagianModel();
        // $this->penyiarModel = new DataRumahSakitModel();
    }
    public function index()
    {
        $data = [
            'title' => "Jadwal Kegiatan",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Jadwal Kegiatan'],
            'jadwalKegiatan' => $this->jadwalKegiatanModel,
            'menu' => $this->fetchMenu()
        ];
        return view('pages/jadwalKegiatan', $data);
    }

    public function add()
    {
        dd($_POST);
        if (!$this->validate([
            'rumahSakitNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Rumah Sakit Harus Diisi',
                ]
            ],
            'rumahSakitLat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Koordinat Rumah Sakit Harus Diisi',
                ]
            ],
            'rumahSakitLong' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Koordinat Rumah Sakit Harus Diisi',
                ]
            ],
            'rumahSakitTelp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Telp Rumah Sakit Harus Diisi',
                ]
            ],
            'rumahSakitEmail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Rumah Sakit Harus Diisi',
                ]
            ],
        ])) {
            return redirect()->to('jadwalKegiatan')->withInput();
        }


        $data = array(
            'rumahSakitNama' => trim($this->request->getPost('rumahSakitNama')),
            'rumahSakitLatLong' => trim($this->request->getPost('rumahSakitLat')) . ',' . trim($this->request->getPost('rumahSakitLong')),
            'rumahSakitTelp' => trim($this->request->getPost('rumahSakitTelp')),
            'rumahSakitEmail' => trim($this->request->getPost('rumahSakitEmail')),
            'rumahSakitWarna' => trim($this->request->getPost('rumahSakitWarna')),
        );

        if ($this->dataRumahSakitModel->insert($data)) {
            session()->setFlashdata('success', 'Data Rumah Sakit Berhasil Ditambah !');
            return redirect()->to('dataRumahSakit');
        }
    }
}
