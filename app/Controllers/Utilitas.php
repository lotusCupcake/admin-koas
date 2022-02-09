<?php

namespace App\Controllers;

use App\Models\PengumumanModel;
use CodeIgniter\HTTP\Request;

class Utilitas extends BaseController
{
    protected $pengumumanModel;
    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }
    public function index()
    {
        $data = [
            'title' => "Utilitas",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Setting', 'Utilitas'],
            'pengumuman' => $this->pengumumanModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/utilitas', $data);
    }

    public function pengumumanAdd()
    {
        if (!$this->validate([
            'pengumumanJudul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul Pengumuman Harus Diisi!',
                ]
            ],
            'pengumumanIsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Pengumuman Harus Dipilih!'
                ]
            ],
            'pengumumanTanggalMulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai Pengumuman Harus Dipilih!'
                ]
            ],
            'pengumumanTanggalAkhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Akhir Pengumuman Harus Dipilih!'
                ]
            ]
        ])) {
            return redirect()->to('pengumuman')->withInput();
        }

        // dd($_POST);
        $data = array(
            'pengumumanJudul' => trim($this->request->getPost('pengumumanJudul')),
            'pengumumanIsi' => trim($this->request->getPost('pengumumanIsi')),
            'pengumumanTanggalMulai' => (int)strtotime($this->request->getPost('pengumumanTanggalMulai')) * 1000,
            'pengumumanTanggalAkhir' => (int)strtotime($this->request->getPost('pengumumanTanggalAkhir')) * 1000,
            'pengumumanIsForceToShow' => trim($this->request->getPost('pengumumanIsForceToShow')) == null ? 0 : 1
        );

        if ($this->pengumumanModel->insert($data)) {
            session()->setFlashdata('success', 'Pengumuman Berhasil Ditambahkan!');
            return redirect()->to('utilitas');
        }
    }

    public function pengumumanEdit($id)
    {
        if (!$this->validate([
            'pengumumanJudul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul Pengumuman Harus Diisi!',
                ]
            ],
            'pengumumanIsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Pengumuman Harus Dipilih!'
                ]
            ],
            'pengumumanTanggalMulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai Pengumuman Harus Dipilih!'
                ]
            ],
            'pengumumanTanggalAkhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Akhir Pengumuman Harus Dipilih!'
                ]
            ]
        ])) {
            return redirect()->to('pengumuman')->withInput();
        }

        // dd($_POST);
        $data = array(
            'pengumumanJudul' => trim($this->request->getPost('pengumumanJudul')),
            'pengumumanIsi' => trim($this->request->getPost('pengumumanIsi')),
            'pengumumanTanggalMulai' => (int)strtotime($this->request->getPost('pengumumanTanggalMulai')) * 1000,
            'pengumumanTanggalAkhir' => (int)strtotime($this->request->getPost('pengumumanTanggalAkhir')) * 1000,
            'pengumumanIsForceToShow' => trim($this->request->getPost('pengumumanIsForceToShow')) == null ? 0 : 1
        );

        if ($this->pengumumanModel->update($id, $data)) {
            session()->setFlashdata('success', 'Pengumuman Berhasil Diupdate!');
            return redirect()->to('utilitas');
        }
    }

    public function pengumumanDelete($id)
    {
        if ($this->pengumumanModel->delete($id)) {
            session()->setFlashdata('success', 'Pengumuman Berhasil Dihapus!');
        };
        return redirect()->to('utilitas');
    }
}
