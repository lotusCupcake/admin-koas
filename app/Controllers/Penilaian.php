<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\KegiatanMahasiswaModel;
use App\Models\GradeModel;
use App\Models\GradeGrModel;
use App\Models\UsersModel;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    protected $kegiatanModel;
    protected $gradeModel;
    protected $gradeGrModel;
    protected $usersModel;
    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->kegiatanModel = new KegiatanMahasiswaModel();
        $this->gradeModel = new GradeModel();
        $this->gradeGrModel = new GradeGrModel();
        $this->usersModel = new UsersModel();
    }
    public function index()
    {
        $data = [
            'title' => "Penilaian",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Penilaian'],
            'penilaian' => $this->penilaianModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        if (in_groups('Dosen')) {
            $init = $this->initDataDosen();
            $data['menuNilai'] = $this->penilaianModel->getMenuNilai(['penilaianActive' => 1, 'logbook.logbookDopingEmail' => user()->email])->findAll();
        } elseif (in_groups('Koordik')) {
            $rs = getUser(user()->id)->dopingRumkitId;
            $init = $this->initDataKoordik($rs);
            $data['menuNilai'] = $this->penilaianModel->getMenuNilai(['penilaianActive' => 1, 'rumkit_detail.rumkitDetRumkitId' => $rs])->findAll();
        }
        $data = array_merge($init, $data);
        return view('pages/penilaian', $data);
    }

    function initDataKoordik($rs)
    {
        $data = [
            // mahasiswa dalam setiap penilaian berbeda sesuai nilai exists
            'mhsLapKasus' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 1])->findAll(),
            'mhsP2KM' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 2])->findAll(),
            'mhsJurnalReading' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 3])->findAll(),
            'mhsTinjauanPustaka' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 4])->findAll(),
            'mhsP2K' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 5])->findAll(),
            'mhsFollowUp' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 6])->findAll(),
            'mhsResponsiLap' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 7])->findAll(),
            'mhsDOPS' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 8])->findAll(),
            'mhsTKlinikI' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 9])->findAll(),
            'mhsMiniCex' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 10])->findAll(),
            'mhsIPC' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 11])->findAll(),
            'mhsKondite' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 12])->findAll(),
            'mhsPretest' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 13])->findAll(),
            'mhsPostest' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 14])->findAll(),
            'mhsTKlinikII' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 15])->findAll(),
            'mhsIPE' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 16])->findAll(),
            'mhsKDinasKesehatan' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 17])->findAll(),
            'mhsKPuskesmas' => $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => 18])->findAll(),
            // nilai dalam setiap penilaian berbeda sesuai nilai exists
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

        return $data;
    }

    function initDataDosen()
    {
        $data = [
            // mahasiswa dalam setiap penilaian berbeda sesuai nilai exists
            'mhsLapKasus' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 1])->findAll(),
            'mhsP2KM' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 2])->findAll(),
            'mhsJurnalReading' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 3])->findAll(),
            'mhsTinjauanPustaka' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 4])->findAll(),
            'mhsP2K' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 5])->findAll(),
            'mhsFollowUp' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 6])->findAll(),
            'mhsResponsiLap' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 7])->findAll(),
            'mhsDOPS' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 8])->findAll(),
            'mhsTKlinikI' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 9])->findAll(),
            'mhsMiniCex' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 10])->findAll(),
            'mhsIPC' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 11])->findAll(),
            'mhsKondite' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 12])->findAll(),
            'mhsPretest' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 13])->findAll(),
            'mhsPostest' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 14])->findAll(),
            'mhsTKlinikII' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 15])->findAll(),
            'mhsIPE' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 16])->findAll(),
            'mhsKDinasKesehatan' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 17])->findAll(),
            'mhsKPuskesmas' => $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => user()->email, 'penilaian.penilaianId' => 18])->findAll(),
            // nilai dalam setiap penilaian berbeda sesuai nilai exists
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
        // dd($data);
        return $data;
    }

    public function save()
    {
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        $json = array();
        $jsonGr = array();
        $nilaiGr = [];
        for ($i = 0; $i < count($keys); $i++) {
            if (is_numeric($keys[$i])) {
                $data = array(
                    'penilaian' => $keys[$i], 'nilai' => $values[$i],
                );
                array_push($json, $data);
            } else {
                if ($keys[$i] === 'gr') {
                    $dataGr = array(
                        'penilaian' => $keys[$i], 'nilai' => $values[$i], 'sanksi' => (!isset($_POST['sanksi']) || $_POST['sanksi'] == "") ? "Tidak Ada Sanksi" : $_POST['sanksi']
                    );
                    array_push($jsonGr, $dataGr);
                }
            }
        }
        $nilai = json_encode($json);
        $nilaiGr = json_encode($jsonGr);

        $cek = $this->gradeModel->getWhere(['gradeNpm' => $_POST['npm'], 'gradePenilaianId' => $_POST['penilaianId'], 'gradeStaseId' => $_POST['staseId']])->getResult();
        $id = ($cek == null) ? 0 : $cek[0]->gradeId;
        if ($cek == null) {
            $dataInsert = array(
                'gradeStaseId' => $_POST['staseId'],
                'gradePenilaianId' => $_POST['penilaianId'],
                'gradeNpm' => $_POST['npm'],
                'gradeNilai' => $nilai,
                'gradeCreatedBy' => user()->email,
                'gradeCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
            );
            $this->gradeModel->insert($dataInsert);

            if (count(json_decode($nilaiGr)) > 0) {
                $dataInsertGr = array(
                    'grStaseId' => $_POST['staseId'],
                    'grPenilaianId' => $_POST['penilaianId'],
                    'grNpm' => $_POST['npm'],
                    'grResult' => $nilaiGr,
                    'grCreatedBy' => user()->email,
                    'grCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
                );

                $this->gradeGrModel->insert($dataInsertGr);
            }
            session()->setFlashdata('success', 'Nilai Mahasiswa Berhasil Disimpan!');
        } else {
            $dataInsert = array(
                'gradeStaseId' => $_POST['staseId'],
                'gradePenilaianId' => $_POST['penilaianId'],
                'gradeNpm' => $_POST['npm'],
                'gradeNilai' => $nilai,
                'gradeCreatedBy' => user()->email,
                'gradeCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
            );
            $this->gradeModel->update($id, $dataInsert);

            if (count(json_decode($nilaiGr)) > 0) {
                $dataInsertGr = array(
                    'grStaseId' => $_POST['staseId'],
                    'grPenilaianId' => $_POST['penilaianId'],
                    'grNpm' => $_POST['npm'],
                    'grResult' => $nilaiGr,
                    'grCreatedBy' => user()->email,
                    'grCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
                );

                $this->gradeGrModel->update($id, $dataInsertGr);
            }
            session()->setFlashdata('success', 'Nilai Mahasiswa Berhasil Diupdate!');
        }



        return redirect()->to('penilaian');
    }

    public function getPenilaian()
    {
        $nilai = $this->request->getVar('nilai');
        echo $this->penilaianModel->getKonversi($nilai)->getResult()[0]->konversiNilaiGradeNama;
    }

    public function setujui($id)
    {
        // dd($_POST);
        $data = array(
            'gradeApproveStatus' => ('1'),
            'gradeApproveBy' => trim($this->request->getPost('gradeApproveBy')),
        );

        if ($this->gradeModel->update($id, $data)) {
            session()->setFlashdata('success', 'Penilaian Mahasiswa Sudah Disetujui!');
            return redirect()->to('penilaian');
        }
    }
}
