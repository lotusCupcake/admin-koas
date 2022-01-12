<?php

namespace App\Controllers;

use App\Models\PanduanModel;
use CodeIgniter\HTTP\Request;

class Panduan extends BaseController
{
    protected $panduanModel;
    public function __construct()
    {
        $this->panduanModel = new PanduanModel();
    }
    public function index()
    {
        $data = [
            'title' => "Panduan",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Data', 'Panduan'],
            'panduan' => $this->panduanModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/panduan', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'panduanNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Panduan Harus Diisi!',
                ]
            ],
            'panduanFile' => [
                'rules' => 'uploaded[panduanFile]',
                'errors' => [
                    'uploaded' => 'File Panduan Harus Dipilih!'
                ]
            ]
        ])) {
            return redirect()->to('panduan')->withInput();
        }

        // upload file
        $fileDokumen = $this->request->getFile('panduanFile');
        $fileDokumen->move('dokumen');
        $namaDokumen = $fileDokumen->getName();

        // dd('berhasil');
        $data = array(
            'panduanNama' => trim($this->request->getPost('panduanNama')),
            'panduanFile' => $namaDokumen,
            'panduanStatus' => ('1')
        );

        // non aktifkan semua status file ketika file yang akan diupload mempunyai status aktif
        $this->panduanModel->updateStatus();

        if ($this->panduanModel->insert($data)) {
            session()->setFlashdata('success', 'Panduan Profesi Berhasil Ditambah!');
            return redirect()->to('panduan');
        }
    }

    public function edit($id)
    {
        // dd($_POST);
        if (!$this->validate([
            'panduanNama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Panduan Harus Diisi!',
                ]
            ],
        ])) {
            return redirect()->to('panduan')->withInput();
        }

        $fileDokumen = $this->request->getFile('panduanFile');

        if ($fileDokumen->getError() == 4) {
            $namaDokumen = $this->request->getVar('fileLama');
        } else {
            $fileDokumen->move('dokumen');
            $namaDokumen = $fileDokumen->getName();
            unlink('dokumen/' . $this->request->getVar('fileLama'));
        }

        // dd($_POST);
        $data = array(
            'panduanNama' => trim($this->request->getPost('panduanNama')),
            'panduanFile' => $namaDokumen,
            'panduanStatus' => trim($this->request->getPost('panduanStatus')) == null ? 0 : 1
        );

        // non aktifkan semua status file ketika file yang akan diupload mempunyai status aktif
        $this->panduanModel->updateStatus();

        if ($this->panduanModel->update($id, $data)) {
            session()->setFlashdata('success', 'Panduan Profesi Berhasil Diupdate!');
            return redirect()->to('panduan');
        }
    }

    public function delete($id)
    {
        // cari gambar 
        $panduan = $this->panduanModel->find($id);

        //hapus gambar
        unlink('dokumen/' . $panduan->panduanFile);

        if ($this->panduanModel->delete($id)) {
            session()->setFlashdata('success', 'Panduan Profesi Berhasil Dihapus!');
        };
        return redirect()->to('panduan');
    }
}
