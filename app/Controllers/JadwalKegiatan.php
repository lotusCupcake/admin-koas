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
            'breadcrumb' => ['Setting', 'Jadwal Kegiatan'],
            'jadwalKegiatan' => $this->jadwalKegiatanModel->show_Jadwal_Kegiatan()->getResult(),
            'dataRumahSakit' => $this->dataRumahSakitModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
        ];
        // dd($data);
        return view('pages/jadwalKegiatan', $data);
    }

    public function stase()
    {
        // Ambil data rumahSakitId yang dikirim via ajax post
        $rumahSakitId = trim($this->request->getPost('rumahSakitId'));
        $staseRumkit = $this->jadwalKegiatanModel->Show_Data_Stase($rumahSakitId);
        // Proses Get Data Stase Dari Tabel Rumkit_Detail

        // Buat variabel untuk menampung tag-tag option nya
        // Set defaultnya dengan tag option Pilih
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseRumkit->getResult() as $data) {
            $lists .= "<option value='" . $data->rumkitDetId . "'>" . $data->staseNama . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_stase_rumkit' => $lists); // Masukan Variabel Lists Tadi Ke Dalam Array $callback dengan index array : list_jurusan
        echo json_encode($callback); // konversi variabel $callback menjadi JSON
    }

    public function kelompok()
    {
        $kelompokId = [];
        $rumkitDetId = trim($this->request->getPost('staseId'));

        $jadwalKelompok = $this->jadwalKegiatanModel->Show_Jadwal_Kelompok($rumkitDetId);

        foreach ($jadwalKelompok->getResult() as $kelompok_jadwal) {
            array_push($kelompokId, $kelompok_jadwal->jadwalKelompokId);
        }

        if (count($kelompokId) == 0) {
            $kelompokId = [0];
        }
        $kelompok = $this->jadwalKegiatanModel->Show_Kelompok($kelompokId);
        // Proses Get Data Stase Dari Tabel Kelompok
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($kelompok->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . " - TA." . $data->kelompokTahunAkademik . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_kelompok' => $lists); // Masukan Variabel Lists Tadi Ke Dalam Array $callback dengan index array : list_jurusan
        echo json_encode($callback); // konversi variabel $callback menjadi JSON
    }

    public function add()
    {
        // dd($_POST);
        if (!$this->validate([
            'tanggalAwal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Awal Harus Diisi!',
                ]
            ],
            'jumlahWeek' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Durasi Harus Diisi!',
                ]
            ],
            'jamMasuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam Masuk Diisi!',
                ]
            ],
            'jamKeluar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'jam Keluar Harus Diisi!',
                ]
            ],
            'rumahSakitId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rumah Sakit Harus Dipilih!',
                ]
            ],
            'staseId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
            'kelompokId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('jadwalKegiatan')->withInput();
        }
        $jlhweek = $this->request->getPost('jumlahWeek');
        $dateSelesai = strtotime($this->request->getPost('tanggalAwal') . " +" . $jlhweek . " weeks") * 1000;
        // $dt = array(
        //     'rumkitDetRumkitId' => $this->request->getPost('rumahSakitId'),
        //     'rumkitDetStaseId' => $this->request->getPost('staseId'),
        // );
        // $rumkitDetailId = '';
        // $rumkitDetail = $this->jadwalKegiatanModel->Get_Where('rumkit_detail', $dt);
        // foreach ($rumkitDetail->getResult() as $row) {
        //     $rumkitDetailId = $row->rumkitDetId;
        // }
        // dd($rumkitDetailId);
        $data = array(
            'jadwalRumkitDetId' => $this->request->getPost('staseId'),
            'jadwalKelompokId' => $this->request->getPost('kelompokId'),
            'jadwalTanggalMulai' => (int)strtotime($this->request->getPost('tanggalAwal')) * 1000,
            'jadwalTanggalSelesai' => $dateSelesai,
            'jadwalJamMasuk' => $this->request->getPost('jamMasuk'),
            'jadwalJamKeluar' => $this->request->getPost('jamKeluar'),
            'jadwalJumlahWeek' => $jlhweek,
        );
        // dd($data);

        if ($this->jadwalKegiatanModel->insert($data)) {
            session()->setFlashdata('success', 'Data Jadwal Kegiatan Berhasil Ditambah !');
            return redirect()->to('jadwalKegiatan');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'tanggalAwal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Awal Harus Diisi!',
                ]
            ],
            'jumlahWeek' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Durasi Harus Diisi!',
                ]
            ],
            'jamMasuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam Masuk Diisi!',
                ]
            ],
            'jamKeluar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'jam Keluar Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('jadwalKegiatan')->withInput();
        }
        // $jlhweek = $this->jadwalKegiatanModel->getJlhWeek(['staseId' => $this->request->getPost('stase')])->getFirstRow()->staseJumlahWeek;
        $jlhweek = $this->request->getPost('jumlahWeek');
        $dateSelesai = strtotime($this->request->getPost('tanggalAwal') . " +" . $jlhweek . " weeks") * 1000;
        // $dt = array(
        //     'rumkitDetRumkitId' => $this->request->getPost('rumahSakit'),
        //     'rumkitDetStaseId' => $this->request->getPost('stase'),
        // );
        // $rumkitDetail = $this->jadwalKegiatanModel->Get_Where('rumkit_detail', $dt);
        // foreach ($rumkitDetail->getResult() as $row) {
        //     $rumkitDetailId = $row->rumkitDetId;
        // }
        // dd($rumkitDetailId);
        $data = array(
            'jadwalRumkitDetId' =>  $this->request->getPost('stase'),
            'jadwalKelompokId' => $this->request->getPost('kelompok'),
            'jadwalTanggalMulai' => (int)strtotime($this->request->getPost('tanggalAwal')) * 1000,
            'jadwalTanggalSelesai' => $dateSelesai,
            'jadwalJamMasuk' => $this->request->getPost('jamMasuk'),
            'jadwalJamKeluar' => $this->request->getPost('jamKeluar'),
            'jadwalJumlahWeek' => $jlhweek,
        );
        // dd($data);

        // dd($this->request->getPost('rumahSakitEmail'));

        if ($this->jadwalKegiatanModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Jadwal Kegiatan Berhasil Diupdate!');
            return redirect()->to('jadwalKegiatan');
        }
    }
}
