<?php

namespace App\Controllers;

use App\Models\AnnounceModel;
use CodeIgniter\HTTP\Request;

class Announce extends BaseController
{
    protected $announceModel;
    public function __construct()
    {
        $this->announceModel = new AnnounceModel();
    }
    public function index()
    {
        $data = [
            'title' => "Announcement",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Setting', 'Utilitas', 'Announcement'],
            'announcement' => $this->announceModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/announce', $data);
    }

    public function announceAdd()
    {
        if (!$this->validate([
            'pengumumanJudul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul Announcement Harus Diisi!',
                ]
            ],
            'pengumumanIsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Announcement Harus Dipilih!'
                ]
            ],
            'pengumumanTanggalMulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai Announcement Harus Dipilih!'
                ]
            ],
            'pengumumanTanggalAkhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Akhir Announcement Harus Dipilih!'
                ]
            ]
        ])) {
            return redirect()->to('announce')->withInput();
        }

        // dd($_POST);
        $data = array(
            'pengumumanJudul' => trim($this->request->getPost('pengumumanJudul')),
            'pengumumanIsi' => trim($this->request->getPost('pengumumanIsi')),
            'pengumumanTanggalMulai' => (int)strtotime($this->request->getPost('pengumumanTanggalMulai')) * 1000,
            'pengumumanTanggalAkhir' => (int)strtotime($this->request->getPost('pengumumanTanggalAkhir')) * 1000,
            'pengumumanIsForceToShow' => trim($this->request->getPost('pengumumanIsForceToShow')) == null ? 0 : 1
        );

        if ($this->announceModel->insert($data)) {
            session()->setFlashdata('success', 'Announcement Berhasil Ditambahkan!');
            return redirect()->to('announce');
        }
    }

    public function announceEdit($id)
    {
        if (!$this->validate([
            'pengumumanJudul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul Announcement Harus Diisi!',
                ]
            ],
            'pengumumanIsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Announcement Harus Dipilih!'
                ]
            ],
            'pengumumanTanggalMulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai Announcement Harus Dipilih!'
                ]
            ],
            'pengumumanTanggalAkhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Akhir Announcement Harus Dipilih!'
                ]
            ]
        ])) {
            return redirect()->to('announce')->withInput();
        }

        // dd($_POST);
        $data = array(
            'pengumumanJudul' => trim($this->request->getPost('pengumumanJudul')),
            'pengumumanIsi' => trim($this->request->getPost('pengumumanIsi')),
            'pengumumanTanggalMulai' => (int)strtotime($this->request->getPost('pengumumanTanggalMulai')) * 1000,
            'pengumumanTanggalAkhir' => (int)strtotime($this->request->getPost('pengumumanTanggalAkhir')) * 1000,
            'pengumumanIsForceToShow' => trim($this->request->getPost('pengumumanIsForceToShow')) == null ? 0 : 1
        );

        if ($this->announceModel->update($id, $data)) {
            session()->setFlashdata('success', 'Announcement Berhasil Diupdate!');
            return redirect()->to('announce');
        }
    }

    public function announceDelete($id)
    {
        if ($this->announceModel->delete($id)) {
            session()->setFlashdata('success', 'Announcement Berhasil Dihapus!');
        };
        return redirect()->to('announce');
    }
}
