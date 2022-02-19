<?php
function week($nim, $stase, $now)
{
    $dari = date("Y-m-d", (minDate($nim, $stase) / 1000));
    $sampai = date("Y-m-d", (maxDate($nim, $stase) / 1000));
    $skipawal = date("Y-m-d", (maxDate($nim, $stase) / 1000));


    $prepare = $now;
    $today = date('Y-m-d', $prepare);
    $harike = 0;
    $minggu = 0;

    while (strtotime($dari) <= strtotime($sampai)) {

        $harike++;

        if ($harike === 7) {
            $minggu = $minggu + 1;
            $harike = 0;
        }

        if ($dari == $today) {
            $minggu = $minggu + 1;
            break;
        }
        $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
    }

    return $minggu;
}

function skipAwal($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMax('min', ['jadwal_detail.jadwalDetailNpm' => $nim, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalDetailTanggalMulai;
    return $result;
}

function skipAkhir($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMax('min', ['jadwal_detail.jadwalDetailNpm' => $nim, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalDetailTanggalMulai;
    return $result;
}

function skipAktifKembali($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMax('min', ['jadwal_detail.jadwalDetailNpm' => $nim, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalDetailTanggalMulai;
    return $result;
}

function minDate($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMax('min', ['jadwal_detail.jadwalDetailNpm' => $nim, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalDetailTanggalMulai;
    return $result;
}

function maxDate($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMax('max', ['jadwal_detail.jadwalDetailNpm' => $nim, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalDetailTanggalSelesai;
    return $result;
}

function minDateKel($kel, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMaxKelompok('min', ['jadwal.jadwalKelompokId' => $kel, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalTanggalMulai;
    return $result;
}

function maxDateKel($kel, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMaxKelompok('max', ['jadwal.jadwalKelompokId' => $kel, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalTanggalSelesai;
    return $result;
}
