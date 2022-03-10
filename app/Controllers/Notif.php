<?php

namespace App\Controllers;

use App\Models\NotifModel;
use App\Models\OneSignalModel;

class Notif extends BaseController
{
    protected $notifModel;
    protected $oneSignalModel;

    public function __construct()
    {
        $this->notifModel = new NotifModel();
        $this->oneSignalModel = new OneSignalModel();
    }

    public function index()
    {
        $data = [
            'title' => "Notifikasi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Setting', 'Utilitas', 'Notifikasi'],
            'notif' => $this->notifModel->getNotifikasi()->get()->getResult(),
            'oneSignal' => $this->oneSignalModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
        ];
        // dd($data['oneSignal']);
        return view('pages/notif', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'notifJudul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul Notifikasi Harus Diisi!',
                ]
            ],
            'notifIsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Notifikasi Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('notif')->withInput();
        }

        // dd($_POST);
        $data = array(
            'notifJudul' => trim($this->request->getPost('notifJudul')),
            'notifIsi' => trim($this->request->getPost('notifIsi')),
            'notifPenerima' => trim($this->request->getPost('notifPenerima')),
        );

        if ($this->notifModel->insert($data)) {
            session()->setFlashdata('success', 'Data Notifikasi Berhasil Ditambah!');
            return redirect()->to('notif');
        }
    }

    public function edit($id)
    {
        if (!$this->validate([
            'notifJudul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul Notifikasi Harus Diisi!',
                ]
            ],
            'notifIsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Notifikasi Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('notif')->withInput();
        }

        // dd($_POST);
        $data = array(
            'notifJudul' => trim($this->request->getPost('notifJudul')),
            'notifIsi' => trim($this->request->getPost('notifIsi')),
            'notifPenerima' => trim($this->request->getPost('notifPenerima')),
        );

        if ($this->notifModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Notifikasi Berhasil Diupdate!');
            return redirect()->to('notif');
        }
    }

    public function delete($id)
    {
        if ($this->notifModel->delete($id)) {
            session()->setFlashdata('success', 'Data Notifikasi Berhasil Dihapus!');
        };
        return redirect()->to('notif');
    }

    public function send()
    {
        $userDikirim = [];
        $penerima = $this->request->getVar('notifPenerima');
        $playerId = $this->oneSignalModel->getPlayerId($penerima);
        foreach ($playerId->get()->getResult() as $oneSignal) {
            $sendPlayerId = $oneSignal->oneSignalPlayerId;
        }
        if ($this->request->getVar('notifPenerima') == '999') {
            sendNotificationBulk(['title' => $this->request->getVar('notifJudul'), 'message' => $this->request->getVar('notifIsi')]);
        } else {
            array_push($userDikirim, $sendPlayerId);
            sendNotification(['title' => $this->request->getVar('notifJudul'), 'user' => $userDikirim, 'message' => $this->request->getVar('notifIsi')]);
        }
        session()->setFlashdata('success', 'Notifikasi Berhasil Dikirim!');
        return redirect()->to('notif');
    }
}
