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
        $currentPage = $this->request->getVar('page_followUp') ? $this->request->getVar('page_followUp') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $followUp = $this->followUpModel->getFollowUpSearch($keyword);
        } else {
            $followUp = $this->followUpModel->getFollowUp();
        }
        $data = [
            'title' => "Follow Up",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Follow Up'],
            'followUp' => $followUp->paginate(5, 'followUp'),
            'pager' => $this->followUpModel->pager,
            'currentPage' => $currentPage,
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
