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
        $data = [
            'title' => "Logbook",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Setting', 'Logbook'],
            'logbook' => $this->logbookMahasiswaModel->getLogbook()->getResult(),
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
