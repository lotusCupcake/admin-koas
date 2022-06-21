<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\KegiatanMahasiswaModel;
use App\Models\GradeModel;
use App\Models\GradeGrModel;
use App\Models\UsersModel;
use Mpdf\Tag\Dd;

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
        $penilaianId = $this->request->getVar('penilaian');
        $currentPage = $this->request->getVar('page_penilaian') ? $this->request->getVar('page_penilaian') : 1;
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Penilaian",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Penilaian'],
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPagePenilaian,
            'isKoordik' => $this->isKoordik,
            'isDosen' => $this->isDosen,
            'emailUser' => $this->emailUser,
            'validation' => \Config\Services::validation(),
        ];
        if ($this->isDosen) {
            $data['menuNilai'] = $this->penilaianModel->getMenuNilai(['penilaianActive' => 1, 'logbook.logbookDopingEmail' => $this->emailUser])->findAll();
            $idpenilaian = ($penilaianId == null) ? $data['menuNilai'][0]->penilaianId : $penilaianId;
            $init = $this->initDataDosen($idpenilaian);
        } elseif ($this->isKoordik) {
            $rs = getUser(user()->id)->dopingRumkitId;
            $data['menuNilai'] = $this->penilaianModel->getMenuNilai(['penilaianActive' => 1, 'rumkit_detail.rumkitDetRumkitId' => $rs])->findAll();
            $idpenilaian = ($penilaianId == null) ? $data['menuNilai'][0]->penilaianId : $penilaianId;
            $init = $this->initDataKoordik($rs, $idpenilaian);
        }
        $data['penilaianId'] = $idpenilaian;
        $data = array_merge($init, $data);
        return view('pages/penilaian', $data);
    }

    function initDataKoordik($rs, $idpenilaian)
    {
        $mhs = $this->kegiatanModel->getMahasiswaNilai(['rumkit_detail.rumkitDetRumkitId' => $rs, 'penilaian.penilaianId' => $idpenilaian]);
        $data = [
            'mahasiswa' => $mhs->paginate($this->numberPagePenilaian, 'penilaian'),
            'pager' => $this->kegiatanModel->pager,
            'nilaiMahasiswa' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => $idpenilaian])->findAll(),
        ];
        return $data;
    }

    function initDataDosen($idpenilaian)
    {
        $mhs = $this->kegiatanModel->getMahasiswaNilai(['dosen_pembimbing.dopingEmail' => $this->emailUser, 'penilaian.penilaianId' => $idpenilaian]);
        $data = [
            'mahasiswa' => $mhs->paginate($this->numberPagePenilaian, 'penilaian'),
            'pager' => $this->kegiatanModel->pager,
            'nilaiMahasiswa' => $this->penilaianModel->getFormNilai(['penilaian.penilaianId' => $idpenilaian])->findAll(),
        ];
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
        $cekGr = $this->gradeGrModel->getWhere(['grNpm' => $_POST['npm'], 'grPenilaianId' => $_POST['penilaianId'], 'grStaseId' => $_POST['staseId']])->getResult();
        $id = ($cek == null) ? 0 : $cek[0]->gradeId;
        $idGr = ($cekGr == null) ? 0 : $cekGr[0]->grId;
        $userLogin = user()->email;
        if ($cek == null) {
            $dataInsert = array(
                'gradeStaseId' => $_POST['staseId'],
                'gradePenilaianId' => $_POST['penilaianId'],
                'gradeNpm' => $_POST['npm'],
                'gradeNilai' => $nilai,
                'gradeCreatedBy' => $userLogin,
                'gradeCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
                'gradeTahunAkademik' => getTahunAkademik()
            );

            if (count($cek) < 1) {
                $this->gradeModel->insert($dataInsert);
                session()->setFlashdata('success', 'Nilai Mahasiswa Berhasil Disimpan!');
            }
            if (count(json_decode($nilaiGr)) > 0) {
                $dataInsertGr = array(
                    'grStaseId' => $_POST['staseId'],
                    'grPenilaianId' => $_POST['penilaianId'],
                    'grNpm' => $_POST['npm'],
                    'grResult' => $nilaiGr,
                    'grCreatedBy' => $userLogin,
                    'grCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
                    'grTahunAkademik' => getTahunAkademik()
                );
                if (count($cekGr) < 1) {
                    $this->gradeGrModel->insert($dataInsertGr);
                    session()->setFlashdata('success', 'Nilai Mahasiswa Berhasil Disimpan!');
                }
            }
        } else {
            $dataInsert = array(
                'gradeStaseId' => $_POST['staseId'],
                'gradePenilaianId' => $_POST['penilaianId'],
                'gradeNpm' => $_POST['npm'],
                'gradeNilai' => $nilai,
                'gradeCreatedBy' => $userLogin,
                'gradeCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
                'gradeTahunAkademik' => getTahunAkademik()
            );
            $this->gradeModel->update($id, $dataInsert);

            if (count(json_decode($nilaiGr)) > 0) {
                $dataInsertGr = array(
                    'grStaseId' => $_POST['staseId'],
                    'grPenilaianId' => $_POST['penilaianId'],
                    'grNpm' => $_POST['npm'],
                    'grResult' => $nilaiGr,
                    'grCreatedBy' => $userLogin,
                    'grCreatedAt' => strtotime(date('Y-m-d H:i:s')) * 1000,
                    'grTahunAkademik' => getTahunAkademik()
                );

                $this->gradeGrModel->update($idGr, $dataInsertGr);
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
        $userDikirim = [];
        $data = array(
            'gradeApproveStatus' => ('1'),
            'gradeApproveBy' => trim($this->request->getPost('gradeApproveBy')),
        );

        if ($this->gradeModel->update($id, $data)) {
            if ($this->request->getVar('playerId') != null) {
                array_push($userDikirim, $this->request->getVar('playerId'));
                sendNotification(['user' => $userDikirim, 'title' => 'Penilaian Kegiatan', 'message' => 'Ada Kegiatan kamu yang sudah dinilai']);
            }
            session()->setFlashdata('success', 'Penilaian Mahasiswa Sudah Disetujui!');
            return redirect()->to('penilaian');
        }
    }
}
