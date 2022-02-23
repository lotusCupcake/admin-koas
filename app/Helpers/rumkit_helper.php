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
