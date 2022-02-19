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
