<?php

namespace App\Controllers;

use App\Models\FollowUpModel;
use App\Models\UsersModel;

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

        $this->usersModel = new UsersModel();
        $usr = $this->usersModel->getSpecificUser(['users.id' => user()->id])->getResult()[0]->name;
        $where = null;
        if ($usr == 'Dosen') {
            $where = array('dosen_pembimbing.dopingId' => user()->id);
        }
        if ($keyword) {
            $followUp = $this->followUpModel->getFollowUpSearch($keyword, $where);
        } else {
            $followUp = $this->followUpModel->getFollowUp($where);
        }
        $data = [
            'title' => "Follow Up",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Follow Up'],
            'followUp' => $followUp->paginate($this->numberPage, 'followUp'),
            'pager' => $this->followUpModel->pager,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
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
