<?php

namespace App\Controllers;

use App\Models\KelompokMahasiswaModel;
use App\Models\JadwalKegiatanModel;
use App\Models\DataRumahSakitModel;
use App\Models\DosenPembimbingModel;
use App\Models\JadwalSkipModel;

class JadwalKegiatan extends BaseController
{
    protected $kelompokMahasiswaModel;
    protected $jadwalKegiatanModel;
    protected $DataRumahSakitModel;
    protected $jadwalSkipModel;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
        $this->dosenPembimbingModel = new DosenPembimbingModel();
        $this->kelompokMahasiswaModel = new KelompokMahasiswaModel();
        $this->jadwalSkipModel = new JadwalSkipModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_jadwal') ? $this->request->getVar('page_jadwal') : 1;
        $keyword = $this->request->getVar('keyword');

        if (in_groups('Koordik')) {
            $rs = $this->dosenPembimbingModel->getSpecificDosen(['dopingEmail' => user()->email])->get()->getResult()[0]->dopingRumkitId;

            if ($keyword) {
                $jadwal = $this->jadwalKegiatanModel->show_Jadwal_KegiatanSearch($keyword, ['rumkit.rumahSakitId' => $rs]);
            } else {
                $jadwal = $this->jadwalKegiatanModel->show_Jadwal_Kegiatan(['rumkit.rumahSakitId' => $rs]);
            }
            $data = [
                'title' => "Jadwal Kegiatan",
                'appName' => "Dokter Muda",
                'breadcrumb' => ['Mahasiswa', 'Jadwal Kegiatan'],
                'jadwalKegiatan' => $jadwal->paginate($this->numberPage, 'jadwal'),
                'mhsDetail' => $this->kelompokMahasiswaModel->getDetailMhs()->getResult(),
                'kelompokDetail' => $this->kelompokMahasiswaModel->findAll(),
                'pager' => $this->jadwalKegiatanModel->pager,
                'currentPage' => $currentPage,
                'numberPage' => $this->numberPage,
                'dataRumahSakit' => $this->dataRumahSakitModel->findAll(),
                'validation' => \Config\Services::validation(),
                'menu' => $this->fetchMenu(),
            ];
        } else {
            if ($keyword) {
                $jadwal = $this->jadwalKegiatanModel->show_Jadwal_KegiatanSearch($keyword);
            } else {
                $jadwal = $this->jadwalKegiatanModel->show_Jadwal_Kegiatan();
            }
            $data = [
                'title' => "Jadwal Kegiatan",
                'appName' => "Dokter Muda",
                'breadcrumb' => ['Setting', 'Jadwal Kegiatan'],
                'jadwalKegiatan' => $jadwal->paginate($this->numberPage, 'jadwal'),
                'mhsDetail' => $this->kelompokMahasiswaModel->getDetailMhs()->getResult(),
                'kelompokDetail' => $this->kelompokMahasiswaModel->findAll(),
                'pager' => $this->jadwalKegiatanModel->pager,
                'currentPage' => $currentPage,
                'numberPage' => $this->numberPage,
                'dataRumahSakit' => $this->dataRumahSakitModel->findAll(),
                'validation' => \Config\Services::validation(),
                'menu' => $this->fetchMenu(),
            ];
        }

        return view('pages/jadwalKegiatan', $data);
    }

    public function stase()
    {
        $rumahSakitId = trim($this->request->getPost('rumahSakitId'));
        $staseRumkit = $this->jadwalKegiatanModel->Show_Data_Stase($rumahSakitId);
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseRumkit->getResult() as $data) {
            $lists .= "<option value='" . $data->rumkitDetId . "'>" . $data->staseNama . "</option>";
        }
        $callback = array('list_stase_rumkit' => $lists);
        echo json_encode($callback);
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
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($kelompok->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . " - TA." . $data->kelompokTahunAkademik . "</option>";
        }
        $callback = array('list_kelompok' => $lists);
        echo json_encode($callback);
    }

    public function add()
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

        $data = array(
            'jadwalRumkitDetId' => $this->request->getPost('staseId'),
            'jadwalKelompokId' => $this->request->getPost('kelompokId'),
            'jadwalTanggalMulai' => (int)strtotime($this->request->getPost('tanggalAwal')) * 1000,
            'jadwalTanggalSelesai' => $dateSelesai,
            'jadwalJamMasuk' => $this->request->getPost('jamMasuk'),
            'jadwalJamKeluar' => $this->request->getPost('jamKeluar'),
            'jadwalJumlahWeek' => $jlhweek,
        );

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

        $jlhweek = $this->request->getPost('jumlahWeek');
        $dateSelesai = strtotime($this->request->getPost('tanggalAwal') . " +" . $jlhweek . " weeks") * 1000;

        $data = array(
            'jadwalRumkitDetId' =>  $this->request->getPost('stase'),
            'jadwalKelompokId' => $this->request->getPost('kelompok'),
            'jadwalTanggalMulai' => (int)strtotime($this->request->getPost('tanggalAwal')) * 1000,
            'jadwalTanggalSelesai' => $dateSelesai,
            'jadwalJamMasuk' => $this->request->getPost('jamMasuk'),
            'jadwalJamKeluar' => $this->request->getPost('jamKeluar'),
            'jadwalJumlahWeek' => $jlhweek,
        );


        if ($this->jadwalKegiatanModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Jadwal Kegiatan Berhasil Diupdate!');
            return redirect()->to('jadwalKegiatan');
        }
    }

    public function skip()
    {
        if (!$this->validate([
            'skipTanggalAwal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Awal Harus Dipilih!',
                ]
            ],
            'skipTanggalAkhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Akhir Harus Dipilih!',
                ]
            ],
            'skipAlasan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alasan Penundaan Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('jadwalKegiatan')->withInput();
        }
        $stase = $this->jadwalSkipModel->getStaseByJadwalDetail(['jadwal_detail.jadwalDetailId' => $this->request->getPost('skipJadwalDetailId')])->getResult()[0]->staseId;
        $tanggalMulai = minDate($this->request->getPost('skipNpm'), $stase);
        $tanggalSelesai = maxDate($this->request->getPost('skipNpm'), $stase);
        $tanggalMulaiFormat = gmdate("Y-m-d", $tanggalMulai / 1000);
        $tanggalSelesaiFormat = gmdate("Y-m-d", $tanggalSelesai / 1000);
        $tanggalAwalSkip = (int)strtotime($this->request->getPost('skipTanggalAwal'));
        $tanggalAkhirSkip = (int)strtotime($this->request->getPost('skipTanggalAkhir'));

        $tglAwalStase = date_create($tanggalMulaiFormat);
        $tglAkhirStase = date_create($tanggalSelesaiFormat);
        $tglAwalSkip = date_create(gmdate("Y-m-d", $tanggalAwalSkip));
        $tglAkhirSkip = date_create(gmdate("Y-m-d", $tanggalAkhirSkip));
        $skipHariKe = $tglAwalStase->diff($tglAwalSkip)->d + 1;
        $hariStase = $tglAwalStase->diff($tglAkhirStase)->d + 1;
        $skipSisaHari = $hariStase - $skipHariKe;
        $data = array(
            'skipJadwalDetailId' =>  $this->request->getPost('skipJadwalDetailId'),
            'skipNpm' => $this->request->getPost('skipNpm'),
            'skipTanggalAwal' => $tanggalAwalSkip * 1000,
            'skipTanggalAkhir' => $tanggalAkhirSkip * 1000,
            'skipAlasan' => $this->request->getPost('skipAlasan'),
            'skipHariKe' => $skipHariKe,
            'skipSisaHari' => $skipSisaHari
        );

        if ($this->jadwalSkipModel->insert($data)) {
            session()->setFlashdata('success', 'Jadwal Kegiatan Berhasil Ditunda!');
            return redirect()->to('jadwalKegiatan');
        }
    }

    public function aktif($id)
    {
        $skipTanggalAktifKembali = (int)strtotime($this->request->getPost('skipTanggalAktifKembali'));
        $data = array(
            'skipTanggalAktifKembali' => $skipTanggalAktifKembali * 1000,
        );

        if ($this->jadwalSkipModel->update($id, $data)) {
            session()->setFlashdata('success', 'Tanggal Aktif Kembali Berhasil Disetting!');
            return redirect()->to('jadwalKegiatan');
        }
    }
}
