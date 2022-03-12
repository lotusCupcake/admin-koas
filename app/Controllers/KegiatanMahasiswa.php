<?php

namespace App\Controllers;

use App\Models\KegiatanMahasiswaModel;
use App\Models\UsersModel;
use App\Models\DosenPembimbingModel;

class KegiatanMahasiswa extends BaseController
{
    protected $dosenPembimbingModel;
    protected $kegiatanMahasiswaModel;
    public function __construct()
    {
        $this->kegiatanMahasiswaModel = new KegiatanMahasiswaModel();
        $this->dosenPembimbingModel = new DosenPembimbingModel();
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_kegiatan') ? $this->request->getVar('page_kegiatan') : 1;
        $keyword = $this->request->getVar('keyword');

        if (in_groups('Koordik')) {
            $rs = $this->dosenPembimbingModel->getSpecificDosen(['dopingEmail' => user()->email])->get()->getResult()[0]->dopingRumkitId;
            if ($keyword) {
                $kegiatan = $this->kegiatanMahasiswaModel->getKegiatanSearch($keyword, ['dosen_pembimbing.dopingRumkitId' => $rs]);
            } else {
                $kegiatan = $this->kegiatanMahasiswaModel->getKegiatan(['dosen_pembimbing.dopingRumkitId' => $rs]);
            };
        } else {
            $usr = $this->usersModel->getSpecificUser(['users.email' => user()->email])->getResult()[0]->name;
            $where = null;
            if ($usr == 'Dosen') {
                $where = array('dosen_pembimbing.dopingEmail' => user()->email);
            }
            if ($keyword) {
                $kegiatan = $this->kegiatanMahasiswaModel->getKegiatanSearch($keyword, $where);
            } else {
                $kegiatan = $this->kegiatanMahasiswaModel->getKegiatan($where);
            }
        }


        $data = [
            'title' => "Kegiatan",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Kegiatan'],
            'kegiatan' => $kegiatan->paginate($this->numberPage, 'kegiatan'),
            'pager' => $this->kegiatanMahasiswaModel->pager,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/kegiatanMahasiswa', $data);
    }

    public function setujui($id)
    {
        $data = array(
            'logbookIsVerify' => ('1'),
        );

        if ($this->kegiatanMahasiswaModel->update($id, $data)) {
            $userDikirim = [];
            if ($this->request->getVar('playerId') != null) {
                array_push($userDikirim, $this->request->getVar('playerId'));
                sendNotification(['user' => $userDikirim, 'title' => 'Verifikasi Kegiatan', 'message' => 'Kegiatan ' . $this->request->getVar('kegiatan') . ' kamu sudah disetujui oleh ' . $this->request->getVar('dopingKegiatan')]);
            }
            session()->setFlashdata('success', 'Kegiatan Mahasiswa Sudah Disetujui!');
            return redirect()->to('kegiatanMahasiswa');
        }
    }
}
