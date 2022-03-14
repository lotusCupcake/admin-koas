<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AuthGroupsModel;
use App\Models\AuthGroupsUsersModel;

class ManajemenAkun extends BaseController
{
    protected $usersModel;
    protected $authGroupsUsersModel;
    protected $authGroupsModel;
    public function __construct()
    {
        $this->usersModel = new UsersModel();
        $this->authGroupsModel = new AuthGroupsModel();
        $this->authGroupsUsersModel = new AuthGroupsUsersModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_akun') ? $this->request->getVar('page_akun') : 1;
        $keyword = $this->request->getVar('keyword');
        // dd($keyword);
        if ($keyword) {
            $akun = $this->usersModel->getUserSearch($keyword);
        } else {
            $akun = $this->usersModel->getUser();
        }

        $data = [
            'title' => "Manajemen Akun",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['User', 'Manajemen Akun'],
            'menu' => $this->fetchMenu(),
            'akun' => $akun->paginate($this->numberPage, 'akun'),
            'currentPage' => $currentPage,
            'pager' => $akun->pager,
            'numberPage' => $this->numberPage,
            'authGroups' =>  $this->authGroupsModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        // dd($data['akun']);

        return view('pages/manajemenAkun', $data);
    }

    public function edit($id)
    {
        if (!$this->validate([
            'userEmail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Harus Diisi!',
                ]
            ],
            'userName' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Harus Diisi!',
                ]
            ],
            'userRole' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('manajemenAkun')->withInput();
        }

        // dd($_POST);
        $data = array(
            'email' => trim($this->request->getPost('userEmail')),
            'username' => trim($this->request->getPost('userName')),
            'active' => trim($this->request->getPost('userActive')) == null ? 0 : 1
        );

        $data_user_group = array('group_id' => trim($this->request->getPost('userRole')));

        if ($this->usersModel->update($id, $data)) {
            if ($this->authGroupsUsersModel->update($id, $data_user_group)) {
                session()->setFlashdata('success', 'Data Akun Berhasil Diupdate !');
                return redirect()->to('manajemenAkun');
            }
        }
    }
}
