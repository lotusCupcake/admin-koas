<?php
function getRumkit($kel, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getRumkitOneline(['kelompok.kelompokId' => $kel, 'stase.staseId' => $stase])->getResult()[0]->Rumkit;
    return $result;
}

function getDetailJadwalKelStase($kel, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getDetailJadwalKelStase(['kelompok.kelompokId' => $kel, 'stase.staseId' => $stase])->getResult();
    return $result;
}

function getUser($id)
{
    $model = new \App\Models\UsersModel;
    $result = $model->getProfile(['users.id' => $id])->getResult()[0];
    return $result;
}

function getUserId($id)
{
    $model = new \App\Models\UsersModel;
    $result = $model->getSpecificUser(['users.id' => $id])->getResult()[0];
    return $result;
}

function getStatus($where)
{
    $model = new \App\Models\BobotModel;
    $result = $model->getWhere($where)->getResult();
    return $result;
}

function getPenilaian($where)
{
    $model = new \App\Models\PenilaianModel;
    $result = $model->select('GROUP_CONCAT(penilaianNamaSingkat SEPARATOR " / ") as penilaianNamaSingkat')->whereIn('penilaianId', array_map('intval', json_decode($where)))->get()->getResult();
    return $result;
}

function getKonversi($nilai)
{
    $model = new \App\Models\PenilaianModel;
    return $model->getKonversi($nilai)->getResult()[0]->konversiNilaiGradeNama;
}


function getPopup($where)
{
    $model = new \App\Models\PopupModel;
    $result = $model->selectCount('email')->getWhere($where)->getResult();
    return $result;
}

function getKomponenBobot($where)
{
    $model = new \App\Models\KomponenNilaiModel;
    $result = ($model->getWhere($where)->getResult()[0]->komponenBobot != null) ? $model->getWhere($where)->getResult()[0]->komponenBobot : 0;
    return $result;
}

function getKomponenNilaiMax($where)
{
    $model = new \App\Models\KomponenNilaiModel;
    $result = ($model->getWhere($where)->getResult()[0]->komponenSkorMax != null) ? $model->getWhere($where)->getResult()[0]->komponenSkorMax : 0;
    return $result;
}

function getGradeExists($where)
{

    $where = ['gradeNpm' => $where[0], 'gradePenilaianId' => $where[1], 'gradeStaseId' => $where[2]];
    $model = new \App\Models\GradeModel;
    $result = $model->getWhere($where)->getResult();
    return $result;
}

function getNilaiGr($idPenilaian, $npm, $stase)
{
    $where = ['penilaian_gr.grPenilaianId' => $idPenilaian, 'penilaian_gr.grNpm' => $npm, 'penilaian_gr.grStaseId' => $stase];
    $model = new \App\Models\GradeGrModel;
    $nilai = (count($model->where($where)->get()->getResult()) > 0) ? json_decode($model->where($where)->get()->getResult()[0]->grResult)[0]->nilai : 2;
    $sanksi = (count($model->where($where)->get()->getResult()) > 0) ? json_decode($model->where($where)->get()->getResult()[0]->grResult)[0]->sanksi : '';
    $result = [$nilai, $sanksi];
    return $result;
}

function getNilaiExist($idPenilaian, $npm, $stase, $kompId)
{
    $where = ['penilaian_grade.gradePenilaianId' => $idPenilaian, 'penilaian_grade.gradeNpm' => $npm, 'penilaian_grade.gradeStaseId' => $stase];
    $grade = new \App\Models\GradeModel;
    $grades = ($grade->where($where)->get()->getResult() != null) ? json_decode($grade->where($where)->get()->getResult()[0]->gradeNilai) : [];
    $nilai = null;
    foreach ($grades as $grade) {
        if ($grade->penilaian == $kompId) {
            $nilai = $grade->nilai;
        }
    }
    $result = $nilai;
    return $result;
}

function getNilai($idPenilaian, $npm, $stase)
{
    $tk2 = false;
    $bobot = 0;
    $model = new \App\Models\GradeModel;
    $penilaian = [];
    foreach ($idPenilaian as $row) {
        if ($row == 19) {
            array_push($penilaian, 8);
            array_push($penilaian, 10);
        } elseif ($row == 20) {
            array_push($penilaian, 9);
            array_push($penilaian, 15);
        } else {
            array_push($penilaian, (int)$row);
        }
    }

    $hasil = json_encode($penilaian);


    $result = $model->where(['gradeNpm' => $npm, 'gradeStaseId' => $stase])->whereIn('gradePenilaianId', $penilaian)->get()->getResult();
    if (count($result) > 1 && in_array(9, $penilaian) || count($result) > 1 && in_array(15, $penilaian)) {
        $tk2 = true;
    }

    if (count($result) > 0) {
        $penilaian = [];
        foreach ($result as $row) {
            array_push($penilaian, (int)$row->gradePenilaianId);
        }

        $komposisi = getStatus(['settingBobotStaseId' => $stase])[0]->settingBobotKomposisiNilai;
        $idPenilaian = [];
        foreach ($penilaian as $row) {
            if ($row == 8 || $row == 10) {
                array_push($idPenilaian, 19);
            } elseif ($row == 9 || $row == 15) {
                array_push($idPenilaian, 20);
            } else {
                array_push($idPenilaian, $row);
            }
        }

        $hasil = json_encode($idPenilaian);

        foreach (json_decode($komposisi) as $komp) {
            foreach (json_decode($komp->penilaian) as $cek) {
                if ($cek == $idPenilaian[0]) {
                    $bobot = $komp->bobot;
                }
            }
        }
        if ($idPenilaian[0] != 20) {
            $nilaiFix = 0;
            foreach (json_decode($result[0]->gradeNilai) as $kompBobot) {
                $nilai = 0;
                $nilai =  ((int)trim($kompBobot->nilai) * (getKomponenBobot(['komponenId' => $kompBobot->penilaian]))) / getKomponenNilaiMax(['komponenId' => $kompBobot->penilaian]);
                $nilaiFix = $nilaiFix + $nilai;
            }
            $hasil = ($nilaiFix  * $bobot) / 100;
        } else {
            if ($tk2) {
                //jika tutorial klinik ada 2
                $tutsklinik1 = $model->where(['gradeNpm' => $npm, 'gradeStaseId' => $stase])->whereIn('gradePenilaianId', [9])->get()->getResult();
                $tutsklinik2 = $model->where(['gradeNpm' => $npm, 'gradeStaseId' => $stase])->whereIn('gradePenilaianId', [15])->get()->getResult();

                $komposisi = getStatus(['settingBobotStaseId' => $stase])[0]->settingBobotKomposisiNilai;
                $hasil = $tutsklinik1[0]->gradeNilai;

                $nilaiFix = 0;
                foreach (json_decode($tutsklinik1[0]->gradeNilai) as $kompBobot) {
                    $nilai = 0;
                    $nilai =  ((int)trim($kompBobot->nilai) * (getKomponenBobot(['komponenId' => $kompBobot->penilaian]))) / getKomponenNilaiMax(['komponenId' => $kompBobot->penilaian]);
                    $nilaiFix = $nilaiFix + $nilai;
                }
                $hasilTk1 = ($nilaiFix  * $bobot) / 100;

                $nilaiFix = 0;
                foreach (json_decode($tutsklinik2[0]->gradeNilai) as $kompBobot) {
                    $nilai = 0;
                    $nilai =  ((int)trim($kompBobot->nilai) * (getKomponenBobot(['komponenId' => $kompBobot->penilaian]))) / getKomponenNilaiMax(['komponenId' => $kompBobot->penilaian]);
                    $nilaiFix = $nilaiFix + $nilai;
                }
                $hasilTk2 = ($nilaiFix  * $bobot) / 100;

                $hasil = ($hasilTk1 + $hasilTk2) / 2;
            } else {
                //jika tutorial klinik hanya 1
                $nilaiFix = 0;
                foreach (json_decode($result[0]->gradeNilai) as $kompBobot) {
                    $nilai = 0;
                    $nilai =  ((int)trim($kompBobot->nilai) * (getKomponenBobot(['komponenId' => $kompBobot->penilaian]))) / getKomponenNilaiMax(['komponenId' => $kompBobot->penilaian]);
                    $nilaiFix = $nilaiFix + $nilai;
                }

                $hasil = ($nilaiFix  * $bobot) / 100;
            }
        }
    } else {
        $hasil = 0;
    }
    return $hasil;
}

function getEvaluasi($where)
{
    $model = new \App\Models\EvaluasiModel();
    $result = $model->getWhere($where)->getResult();
    return $result;
}

function getAspekEvaluasi($where)
{
    $model = new \App\Models\EvaluasiModel();
    $result = $model->getAspekEvaluasi($where)->getResult();
    return $result;
}

function getRefleksi($where)
{
    $model = new \App\Models\RefleksiModel();
    $result = $model->getWhere($where)->getResult();
    return $result;
}

function getTahunAkademik()
{
    $curl = service('curlrequest');
    $response = $curl->request("GET", "https://api.umsu.ac.id/koas/tahunAkademik", [
        "headers" => [
            "Accept" => "application/json"
        ],

    ]);

    return json_decode($response->getBody())->data;
}
