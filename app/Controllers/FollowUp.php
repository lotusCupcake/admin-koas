<?php

namespace App\Controllers;

use App\Models\FollowUpModel;

class FollowUp extends BaseController
{
    protected $followUpModel;
    public function __construct()
    {
        $this->followUpModel = new FollowUpModel();
    }
    public function index()
    {
        $data = [
            'title' => "Follow Up",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Follow Up'],
            'followUp' => $this->followUpModel->getFollowUp()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/followUp', $data);
    }

    public function setujui($id)
    {
        $data = array(
            'followUpVerify' => ('1'),
        );

        if ($this->followUpModel->update($id, $data)) {
            session()->setFlashdata('success', 'Follow Up Mahasiswa Sudah Disetujui!');
            return redirect()->to('followUp');
        }
    }
}
