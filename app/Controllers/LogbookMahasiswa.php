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
        $this->usersModel = new UsersModel();
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
            $usr = $this->usersModel->getSpecificUser(['users.email' => user()->email])->getResult()[0]->name;
            // dd($usr);
            $where = null;
            if ($usr == 'Dosen') {
                $where = array('dosen_pembimbing.dopingEmail' => user()->email);
            }
            // dd($where = array('dosen_pembimbing.dopingEmail' => user()->email));
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
        // dd($data['logbook']);
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
