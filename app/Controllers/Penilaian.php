<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\KegiatanMahasiswaModel;
use App\Models\GradeModel;
use App\Models\GradeGrModel;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    protected $kegiatanModel;
    protected $gradeModel;
    protected $gradeGrModel;
    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->kegiatanModel = new KegiatanMahasiswaModel();
        $this->gradeModel = new GradeModel();
        $this->gradeGrModel = new GradeGrModel();
    }
    public function index()
    {
        $data = [
            'title' => "Penilaian",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Penilaian'],
            'penilaian' => $this->penilaianModel->findAll(),
            'validation' => \Config\Services::validation(),
            'menuNilai' => $this->penilaianModel->getMenuNilai(['penilaianActive' => 1, 'logbook.logbookDopingEmail' => user()->email])->findAll(),
            // mahasiswa dalam setiap penilaian berbeda sesuai nilai exists
            'mahasiswa' => $this->kegiatanModel->getMahasiswaNilai(user()->email)->findAll(),
            'nilaiLapKasus' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 1])->findAll(),
            'nilaiP2KM' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 2])->findAll(),
            'nilaiJurnalReading' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 3])->findAll(),
            'nilaiTinjauanPustaka' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 4])->findAll(),
            'nilaiP2K' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 5])->findAll(),
            'nilaiFollowUp' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 6])->findAll(),
            'nilaiResponsiLap' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 7])->findAll(),
            'nilaiDOPS' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 8])->findAll(),
            'nilaiTKlinikI' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 9])->findAll(),
            'nilaiMiniCex' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 10])->findAll(),
            'nilaiIPC' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 11])->findAll(),
            'nilaiKondite' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 12])->findAll(),
            'nilaiPretest' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 13])->findAll(),
            'nilaiPostest' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 14])->findAll(),
            'nilaiTKlinikII' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 15])->findAll(),
            'nilaiIPE' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 16])->findAll(),
            'nilaiKDinasKesehatan' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 17])->findAll(),
            'nilaiKPuskesmas' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => 18])->findAll(),
            'menu' => $this->fetchMenu()
        ];
        // dd($data['mahasiswa']);
        return view('pages/penilaian', $data);
    }

    public function save()
    {
        dd($_POST);
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        $json = array();
        for ($i = 0; $i < count($keys); $i++) {
            if (is_numeric($keys[$i])) {
                $data = array(
                    $keys[$i] => $values[$i],
                );
                array_push($json, $data);
            }
        }
        $nilai = json_encode($json);
        $dataInsert = array(
            'gradeRumkitDetId' => $_POST['rumkitDetId'],
            'gradePenilaianId' => $_POST['penilaianId'],
            'gradeNpm' => $_POST['npm'],
            'gradeNilai' => $nilai,
            'gradeCreatedBy' => user()->email,
            'gradeCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
        );

        $dataInsertGr = array(
            'grRumkitDetId' => $_POST['rumkitDetId'],
            'grPenilaianId' => $_POST['penilaianId'],
            'grNpm' => $_POST['npm'],
            'grResult' => $nilai,
            'grCreatedBy' => user()->email,
            'grCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
        );
        $this->gradeModel->insert($dataInsert);
        $this->gradeGrModel->insert($dataInsertGr);

        session()->setFlashdata('success', 'Nilai Mahasiswa Berhasil Disimpan!');
        return redirect()->to('penilaian');
    }
}
