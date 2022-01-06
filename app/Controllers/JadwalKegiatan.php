<?php

namespace App\Controllers;

use App\Models\JadwalKegiatanModel;
use App\Models\DataRumahSakitModel;
// use App\Models\DataBagianModel;

class JadwalKegiatan extends BaseController
{
    protected $jadwalKegiatanModel;
    protected $DataRumahSakitModel;
    // protected $DataBagianModel; 
    protected $db;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
        // $this->penyiarModel = new DataRumahSakitModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $data = [
            'title' => "Jadwal Kegiatan",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Jadwal Kegiatan'],
            'jadwalKegiatan' => $this->jadwalKegiatanModel,
            'dataRumahSakit' => $this->dataRumahSakitModel->findAll(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/jadwalKegiatan', $data);
    }

    public function stase()
    {
        // Ambil data rumahSakitId yang dikirim via ajax post
        $rumahSakitId = trim($this->request->getPost('rumahSakitId'));
        // $staseRumkit = $this->jadwalKegiatanModel->Show_Data_Stase($rumahSakitId);   --> Ini Klo Di CI3
        // Proses Get Data Stase Dari Tabel Rumkit_Detail

        $builder = $this->db->table('rumkit_detail');
        $builder->select('*');
        $builder->join('rumkit', 'rumkit.rumahSakitId = rumkit_detail.rumkitDetRumkitId', 'LEFT');
        $builder->join('stase', 'stase.staseId = rumkit_detail.rumkitDetStaseId', 'LEFT');
        $builder->where('rumkit_detail.rumkitDetRumkitId', $rumahSakitId);
        $builder->where('rumkit_detail.rumkitDetStatus', 1);
        $staseRumkit = $builder->get();
        // Buat variabel untuk menampung tag-tag option nya
        // Set defaultnya dengan tag option Pilih
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseRumkit->getResult() as $data) {
            $lists .= "<option value='" . $data->rumkitDetId . "'>" . $data->staseNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_stase_rumkit' => $lists); // Masukan Variabel Lists Tadi Ke Dalam Array $callback dengan index array : list_jurusan
        echo json_encode($callback); // konversi variabel $callback menjadi JSON
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
