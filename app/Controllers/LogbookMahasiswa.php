<?php

namespace App\Controllers;

use App\Models\LogbookMahasiswaModel;
use App\Models\UsersModel;

class LogbookMahasiswa extends BaseController
{
    protected $logbookMahasiswaModel;
    public function __construct()
    {
        $this->logbookMahasiswaModel = new LogbookMahasiswaModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_logbook') ? $this->request->getVar('page_logbook') : 1;
        $keyword = $this->request->getVar('keyword');

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
