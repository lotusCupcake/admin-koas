<?php

namespace App\Controllers;

use App\Models\LogbookMahasiswaModel;
use App\Models\UsersModel;
use App\Models\DosenPembimbingModel;

class LogbookMahasiswa extends BaseController
{
    protected $dosenPembimbingModel;
    protected $logbookMahasiswaModel;
    public function __construct()
    {
        $this->logbookMahasiswaModel = new LogbookMahasiswaModel();
        $this->dosenPembimbingModel = new DosenPembimbingModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_logbook') ? $this->request->getVar('page_logbook') : 1;
        $keyword = $this->request->getVar('keyword');

        if (in_groups('Koordik')) {
            $rs = $this->dosenPembimbingModel->getSpecificDosen(['dopingEmail' => user()->email])->get()->getResult()[0]->dopingRumkitId;
            // dd($rs);
            if ($keyword) {
                $logbook = $this->logbookMahasiswaModel->getLogbookSearch($keyword, ['dosen_pembimbing.dopingRumkitId' => $rs]);
            } else {
                $logbook = $this->logbookMahasiswaModel->getLogbook(['dosen_pembimbing.dopingRumkitId' => $rs]);
            };
        } else {
            $this->usersModel = new UsersModel();
            $usr = $this->usersModel->getSpecificUser(['users.id' => user()->id])->getResult()[0]->name;
            $where = null;
            if ($usr == 'Dosen') {
                $where = array('dosen_pembimbing.dopingId' => user()->id);
            }
            if ($keyword) {
                $logbook = $this->logbookMahasiswaModel->getLogbookSearch($keyword, $where);
            } else {
                $logbook = $this->logbookMahasiswaModel->getLogbook($where);
            }
        }


        $data = [
            'title' => "Logbook",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Logbook'],
            'logbook' => $logbook->paginate($this->numberPage, 'logbook'),
            'pager' => $this->logbookMahasiswaModel->pager,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/logbookMahasiswa', $data);
    }

    public function setujui($id)
    {
        $data = array(
            'logbookIsVerify' => ('1'),
        );

        if ($this->logbookMahasiswaModel->update($id, $data)) {
            session()->setFlashdata('success', 'Logbook Mahasiswa Sudah Disetujui!');
            return redirect()->to('logbookMahasiswa');
        }
    }
}
