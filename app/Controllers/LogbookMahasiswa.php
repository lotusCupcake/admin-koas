<?php

namespace App\Controllers;

use App\Models\LogbookMahasiswaModel;

class LogbookMahasiswa extends BaseController
{
    protected $logbookMahasiswaModel;
    public function __construct()
    {
        $this->logbookMahasiswaModel = new LogbookMahasiswaModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('logbook') ? $this->request->getVar('logbook') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $logbook = $this->logbookMahasiswaModel->getLogbookSearch($keyword);
        } else {
            $logbook = $this->logbookMahasiswaModel->getLogbook();
        }

        $data = [
            'title' => "Logbook",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Logbook'],
            'logbook' => $logbook->paginate(5, 'logbook'),
            'pager' => $this->logbookMahasiswaModel->pager,
            'currentPage' => $currentPage,
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
