<?php
function week($from, $to, $now)
{
    $dari = date("Y-m-d", 1643090400);
    $sampai = date("Y-m-d", 1648098000);


    $prepare = strtotime('02/19/2022');
    $today = date('Y-m-d', $prepare);
    $harike = 0;
    $minggu = 0;

    while (strtotime($dari) <= strtotime($sampai)) {
        $day  =  date('D', strtotime($dari));
        $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        $harike++;

        if ($harike === 7) {
            $minggu++;
            $harike = 0;
        }

        if ($dari == $today) {
            $minggu = $minggu + 1;
            break;
        }
    }

    return $minggu;
}
