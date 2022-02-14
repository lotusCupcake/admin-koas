<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\KegiatanMahasiswaModel;
use App\Models\GradeModel;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    protected $kegiatanModel;
    protected $gradeModel;
    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->kegiatanModel = new KegiatanMahasiswaModel();
        $this->gradeModel = new GradeModel();
    }
    public function index()
    {
        $data = [
            'title' => "Penilaian",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Penilaian'],
            'penilaian' => $this->penilaianModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menuNilai' => $this->penilaianModel->getMenuNilai()->findAll(),
            'mahasiswa' => $this->kegiatanModel->getMahasiswaNilai(user()->email)->findAll(),
            'nilaiLapKasus' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 1])->findAll(),
            'nilaiP2KM' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 2])->findAll(),
            'nilaiJurnalReading' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 3])->findAll(),
            'nilaiTinjauanPustaka' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 4])->findAll(),
            'nilaiP2K' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 5])->findAll(),
            'nilaiFollowUp' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 6])->findAll(),
            'nilaiResponsiLap' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 7])->findAll(),
            'nilaiDOPS' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 8])->findAll(),
            'nilaiIPE' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 9])->findAll(),
            'nilaiMiniCex' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 10])->findAll(),
            'nilaiIPC' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 11])->findAll(),
            'nilaiKondite' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 12])->findAll(),
            'menu' => $this->fetchMenu()
        ];
        // dd($data['nilaiLapKasus']);
        // dd($data['mahasiswa']);
        return view('pages/penilaian', $data);
    }

    public function save()
    {
        // dd($_POST);
        $keys = array_keys($_POST);
        $values = array_values($_POST);

        for ($i = 0; $i < count($keys); $i++) {
            if (is_numeric($keys[$i])) {
                $data = array(
                    'gradeRumkitDetId' => $_POST['rumkitDetId'],
                    'gradePenilaianId' => $_POST['penilaianId'],
                    'gradeNpm' => $_POST['npm'],
                    'gradeKomponenId' => $keys[$i],
                    'gradeCreatedBy' => user()->email,
                    'gradeCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
                );

                ($_POST['penilaianId'] != 12) ? $data['gradeNilai'] = $values[$i] : $data['gradeKeterangan'] = $values[$i];

                $this->gradeModel->insert($data);
            }
        }

        session()->setFlashdata('success', 'Nilai Mahasiswa Berhasil Disimpan!');
        return redirect()->to('penilaian');
    }
}
