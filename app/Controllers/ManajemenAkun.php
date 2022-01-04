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

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as userid, auth_groups_users.group_id as groups_id, username, email, name, active');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id  = auth_groups_users.group_id');
        $query = $builder->get();
        // $users = new \Myth\Auth\Models\UserModel();
        // dd($query->getResult());
        $data = [
            'title' => "Manajemen Akun",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Manajemen Akun'],
            'menu' => $this->fetchMenu(),
            'users' => $query->getResult(),
            'akun' =>  $this->usersModel->findAll(),
            'authGroups' =>  $this->authGroupsModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
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

    public function delete($id)
    {
        if ($this->usersModel->delete($id)) {
            if ($this->authGroupsUsersModel->delete($id)) {
                session()->setFlashdata('success', 'Data Akun Berhasil Dihapus !');
                return redirect()->to('manajemenAkun');
            }
        }
    }
}