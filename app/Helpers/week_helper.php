<?php
function week($nim, $stase, $now)
{
    $dari = date("Y-m-d", (minDate($nim, $stase) / 1000));
    $sampai = date("Y-m-d", (maxDate($nim, $stase) / 1000));
    $skipawal = (skipAwal($nim, $stase) != null) ? date("Y-m-d", (skipAwal($nim, $stase) / 1000)) : false;
    $skipakhir = (skipAkhir($nim, $stase) != null) ? date("Y-m-d", (skipAkhir($nim, $stase) / 1000)) : false;
    $skipaktifkembali = (skipAktifKembali($nim, $stase) != null) ? date("Y-m-d", (skipAktifKembali($nim, $stase) / 1000)) : false;

    $prepare = $now;
    $today = date('Y-m-d', $prepare);
    $harike = 0;
    $minggu = 0;

    if (!$skipawal && !$skipakhir && !$skipaktifkembali) {
        //kondisi jika tidak ada jadwal skip
        while (strtotime($dari) <= strtotime($sampai)) {
            if ($harike === 7) {
                $minggu = $minggu + 1;
                $harike = 0;
            }

            if ($dari == $today) {
                $minggu = $minggu + 1;
                break;
            }
            $harike++;
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }
    } elseif ($skipawal && $skipakhir && !$skipaktifkembali) {
        //kondisi jika ada jadwal skip dan belum aktif kembali
        $listjadwal = [];
        while (strtotime($dari) <= strtotime("-1 day", strtotime($skipawal))) {
            array_push($listjadwal, $dari);
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }

        foreach ($listjadwal as $jadwal) {
            if ($harike === 7) {
                $minggu = $minggu + 1;
                $harike = 0;
            }

            if ($jadwal == $today) {
                $minggu = $minggu + 1;
                break;
            }
            $harike++;
            $jadwal = date("Y-m-d", strtotime("+1 day", strtotime($jadwal)));
        }
    } elseif ($skipawal && $skipakhir && $skipaktifkembali) {
        //kondisi jika ada jadwal skip dan sudah aktif
        $listjadwal = [];
        while (strtotime($dari) <= strtotime("-1 day", strtotime($skipawal))) {
            array_push($listjadwal, $dari);
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }

        while (strtotime($skipaktifkembali) <= strtotime($sampai)) {
            array_push($listjadwal, $skipaktifkembali);
            $skipaktifkembali = date("Y-m-d", strtotime("+1 day", strtotime($skipaktifkembali)));
        }

        foreach ($listjadwal as $jadwal) {
            if ($harike === 7) {
                $minggu = $minggu + 1;
                $harike = 0;
            }

            if (
                $jadwal == $today
            ) {
                $minggu = $minggu + 1;
                break;
            }
            $harike++;
            $jadwal = date("Y-m-d", strtotime("+1 day", strtotime($jadwal)));
        }
    }

    return $minggu;
}

function skipAwal($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = (count($model->getDetailSkip(['jadwal_skip.skipNpm' => $nim, 'stase.staseId' => $stase])->getResult()) != 0) ? $model->getDetailSkip(['jadwal_skip.skipNpm' => $nim, 'stase.staseId' => $stase])->getResult()[0]->skipTanggalAwal : null;
    return $result;
}

function skipAkhir($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result =  (count($model->getDetailSkip(['jadwal_skip.skipNpm' => $nim, 'stase.staseId' => $stase])->getResult()) != 0) ? $model->getDetailSkip(['jadwal_skip.skipNpm' => $nim, 'stase.staseId' => $stase])->getResult()[0]->skipTanggalAkhir : null;
    return $result;
}

function skipAktifKembali($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result =  (count($model->getDetailSkip(['jadwal_skip.skipNpm' => $nim, 'stase.staseId' => $stase])->getResult()) != 0) ? $model->getDetailSkip(['jadwal_skip.skipNpm' => $nim, 'stase.staseId' => $stase])->getResult()[0]->skipTanggalAktifKembali : null;
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
