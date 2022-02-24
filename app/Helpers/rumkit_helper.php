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
    $result = $model->getWhere($where)->getResult();
    return $result;
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

function getNilai($idPenilaian, $npm, $stase)
{

    $model = new \App\Models\GradeModel;

    if ($idPenilaian == 19) {
        $idPenilaian = [8, 10];
    } elseif ($idPenilaian == 20) {
        $idPenilaian = [9, 15];
    } else {
        $idPenilaian = [$idPenilaian];
    }

    $result = $model->where(['gradeNpm' => $npm])->whereIn('gradePenilaianId', $idPenilaian)->get()->getResult();
    if (count($result) > 0) {
        $idPenilaian = $result[0]->gradePenilaianId;

        $komposisi = getStatus(['settingBobotStaseId' => $stase])[0]->settingBobotKomposisiNilai;

        if ($idPenilaian == 8 || $idPenilaian == 10) {
            $idPenilaian = 19;
        } elseif ($idPenilaian == 9 || $idPenilaian == 15) {
            $idPenilaian = 20;
        } else {
            $idPenilaian = $idPenilaian;
        }

        foreach (json_decode($komposisi) as $komp) {
            if ($komp->penilaian == $idPenilaian) {
                $bobot = $komp->bobot;
            }
        }

        $nilaiFix = 0;
        foreach (json_decode($result[0]->gradeNilai) as $kompBobot) {
            $nilai = 0;
            $nilai =  ((int)trim($kompBobot->nilai) * (getKomponenBobot(['komponenId' => $kompBobot->penilaian]))) / getKomponenNilaiMax(['komponenId' => $kompBobot->penilaian]);
            $nilaiFix = $nilaiFix + $nilai;
        }

        $hasil =   ($nilaiFix  * $bobot) / 100;
    } else {
        $hasil = 0;
    }
    return $hasil;
}
