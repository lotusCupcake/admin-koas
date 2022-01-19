<?php

namespace App\Controllers;

use App\Models\DosenPembimbingModel;
use App\Models\DataRumahSakitModel;
use Myth\Auth\Entities\User;
use App\Models\UsersModel;
use CodeIgniter\Controller;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;

class DosenPembimbing extends BaseController
{
    protected $dosenPembimbingModel;
    protected $dataRumahSakitModel;
    protected $config;
    protected $session;
    protected $auth;
    public function __construct()
    {
        $this->dosenPembimbingModel = new DosenPembimbingModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
        $this->session = service('session');
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    public function index()
    {
        if (in_groups('Koordik')) {
            $data = [
                'title' => "Dosen Pembimbing",
                'appName' => "Dokter Muda",
                'breadcrumb' => ['Master', 'Data', 'Dosen Pembimbing'],
                'dosenPembimbing' => $this->dosenPembimbingModel->getDosenPembimbing()->getResult(),
                'dataRumahSakit' => $this->dataRumahSakitModel->findAll(),
                'validation' => \Config\Services::validation(),
                'menu' => $this->fetchMenu()
            ];
        } else {
            $data = [
                'title' => "Dosen/Koordik",
                'appName' => "Dokter Muda",
                'breadcrumb' => ['Master', 'Data', 'Dosen/Koordik'],
                'dosenPembimbing' => $this->dosenPembimbingModel->getDosenPembimbing()->getResult(),
                'dataRumahSakit' => $this->dataRumahSakitModel->findAll(),
                'validation' => \Config\Services::validation(),
                'menu' => $this->fetchMenu()
            ];
        }

        return view('pages/dosenPembimbing', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'dopingNamaLengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Dan Gelar Harus Diisi!',
                ]
            ],
            'dopingEmail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Harus Diisi!',
                ]
            ],
            'dopingNoHandphone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Telp Harus Diisi!',
                ]
            ],
            'dopingAlamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Harus Diisi!',
                ]
            ],
            'dopingRumkitId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rumah Sakit Harus Dipilih!',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Harus Diisi!',
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[3]|max_length[30]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username Harus Diisi!',
                    'min_length' => 'Username Kurang Dari 3 Karakter!',
                    'max_length' => 'Username Setidaknya Tidak Lebih Dari 30 Karakter!',
                    'is_unique' => 'Username Sudah Digunakan!'
                ]
            ]
        ])) {
            return redirect()->to('dosenPembimbing')->withInput();
        }

        // Start Save the user
        $users = model(UserModel::class);
        // dd($_POST);
        $dataUser = [
            'password' => trim($this->request->getPost('password')),
            'email' => trim($this->request->getPost('dopingEmail')),
            'username' => trim($this->request->getPost('username')),
            'active' => 1,
        ];
        $user = new User($dataUser);

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();
        $users = $users->withGroup($this->request->getPost('type'));

        if (!$users->save($user)) {
            return redirect()->to('dosenPembimbing')->withInput()->with('errors', $users->errors());
        }
        // End Save the user

        // dd($_POST);
        $data = array(
            'dopingNamaLengkap' => trim($this->request->getPost('dopingNamaLengkap')),
            'dopingEmail' => trim($this->request->getPost('dopingEmail')),
            'dopingNoHandphone' => trim($this->request->getPost('dopingNoHandphone')),
            'dopingAlamat' => trim($this->request->getPost('dopingAlamat')),
            'dopingRumkitId' => trim($this->request->getPost('dopingRumkitId')),
            'type' => trim($this->request->getPost('type')),
        );

        if ($this->dosenPembimbingModel->insert($data)) {
            if (in_groups('Koordik')) {
                session()->setFlashdata('success', 'Data Dosen Pembimbing Berhasil Ditambah!');
            } else {
                session()->setFlashdata('success', 'Data Dosen/Koordik Berhasil Ditambah!');
            }
            return redirect()->to('dosenPembimbing');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'dopingNamaLengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Dan Gelar Dosen Harus Diisi!',
                ]
            ],
            'dopingEmail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Dosen Harus Diisi!',
                ]
            ],
            'dopingNoHandphone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Telp Dosen Harus Diisi!',
                ]
            ],
            'dopingAlamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Dosen Harus Diisi!',
                ]
            ],
            'dopingRumkitId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rumah Sakit Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('dosenPembimbing')->withInput();
        }

        // dd($_POST);
        $data = array(
            'dopingNamaLengkap' => trim($this->request->getPost('dopingNamaLengkap')),
            'dopingEmail' => trim($this->request->getPost('dopingEmail')),
            'dopingNoHandphone' => trim($this->request->getPost('dopingNoHandphone')),
            'dopingAlamat' => trim($this->request->getPost('dopingAlamat')),
            'dopingRumkitId' => trim($this->request->getPost('dopingRumkitId')),
            'type' => trim($this->request->getPost('type')),
        );

        if ($this->dosenPembimbingModel->update($id, $data)) {
            if (in_groups('Koordik')) {
                session()->setFlashdata('success', 'Data Dosen Pembimbing Berhasil Diupdate!');
            } else {
                session()->setFlashdata('success', 'Data Dosen/Koordik Berhasil Diupdate!');
            }
            return redirect()->to('dosenPembimbing');
        }
    }

    public function delete($id)
    {
        if ($this->dosenPembimbingModel->delete($id)) {
            if (in_groups('Koordik')) {
                session()->setFlashdata('success', 'Data Dosen Pembimbing Berhasil Dihapus!');
            } else {
                session()->setFlashdata('success', 'Data Dosen/Koordik Berhasil Dihapus!');
            }
        };
        return redirect()->to('dosenPembimbing');
    }
}
