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
            'oneSignal' => $this->oneSignalModel->getUserOneSignal()->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
        ];
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
        if ($this->request->getVar('rencana') == null) {
            $penerima = $this->request->getPost('notifPenerima');
            $data = array(
                'notifJudul' => trim($this->request->getPost('notifJudul')),
                'notifIsi' => trim($this->request->getPost('notifIsi')),
                'notifPenerima' => json_encode(["999"]),
            );
        } else {
            $penerima = $this->request->getPost('notifPenerima');
            $data = array(
                'notifJudul' => trim($this->request->getPost('notifJudul')),
                'notifIsi' => trim($this->request->getPost('notifIsi')),
                'notifPenerima' => json_encode($penerima),
            );
        }

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

        $penerima = $this->request->getPost('notifPenerima');
        // dd($penerima);
        $data = array(
            'notifJudul' => trim($this->request->getPost('notifJudul')),
            'notifIsi' => trim($this->request->getPost('notifIsi')),
            'notifPenerima' => json_encode($penerima),
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

    public function send($id)
    {
        $data = $this->notifModel->where(['notifId' => $id])->findAll();
        if (json_decode($data[0]->notifPenerima) == ["999"]) {
            sendNotificationBulk(['title' => $data[0]->notifJudul, 'message' => $data[0]->notifIsi]);
        } else {
            $playerId = $this->oneSignalModel->getPlayerId(json_decode($data[0]->notifPenerima))->getResult();
            $sendPlayerId = [];
            foreach ($playerId as $oneSignal) {
                array_push($sendPlayerId, $oneSignal->oneSignalPlayerId);
            }
            sendNotification(['title' => $data[0]->notifJudul, 'user' => $sendPlayerId, 'message' => $data[0]->notifIsi]);
        }
        session()->setFlashdata('success', 'Notifikasi Berhasil Dikirim!');
        return redirect()->to('notif');
    }
}
