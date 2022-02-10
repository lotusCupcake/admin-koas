<?php
<<<<<<< HEAD
function week($from, $to, $now)
{
    $dari = date("Y-m-d", 1643090400);
    $sampai = date("Y-m-d", 1648098000);


    $prepare = strtotime('02/19/2022');
=======
function week($nim, $stase, $now)
{
    $dari = date("Y-m-d", (minDate($nim, $stase) / 1000));
    $sampai = date("Y-m-d", (maxDate($nim, $stase) / 1000));


    $prepare = $now;
>>>>>>> 0bef54247d50dd86ff594d7beb5ff1b73c85bfc6
    $today = date('Y-m-d', $prepare);
    $harike = 0;
    $minggu = 0;

    while (strtotime($dari) <= strtotime($sampai)) {
        $day  =  date('D', strtotime($dari));
        $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        $harike++;

        if ($harike === 7) {
<<<<<<< HEAD
            $minggu++;
=======
            $minggu = $minggu + 1;
>>>>>>> 0bef54247d50dd86ff594d7beb5ff1b73c85bfc6
            $harike = 0;
        }

        if ($dari == $today) {
            $minggu = $minggu + 1;
            break;
        }
    }

    return $minggu;
}
<<<<<<< HEAD
=======

function minDate($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMax('min', ['kelompok_detail.kelompokDetNim' => $nim, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalTanggalMulai;
    return $result;
}

function maxDate($nim, $stase)
{
    $model = new \App\Models\JadwalKegiatanModel;
    $result = $model->getMinMax('max', ['kelompok_detail.kelompokDetNim' => $nim, 'stase.staseId' => $stase])->get()->getResult()[0]->jadwalTanggalSelesai;
    return $result;
}
>>>>>>> 0bef54247d50dd86ff594d7beb5ff1b73c85bfc6
