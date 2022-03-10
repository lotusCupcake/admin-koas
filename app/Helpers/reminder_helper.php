<?php
function jumlahFollowUp()
{
    $followUpModel = new App\Models\FollowUpModel;
    $usersModel = new App\Models\UsersModel;
    $email = $usersModel->getSpecificUser(['users.email' => user()->email])->getResult()[0]->email;

    return $followUpModel->getJumlahFollowUp([
        'users.email' => $email,
        'follow_up.followUpVerify' => 0
    ])->get()->getResult()[0]->followUpId;
}

function jumlahKegiatan()
{
    $kegiatan = new App\Models\KegiatanMahasiswaModel;
    $usersModel = new App\Models\UsersModel;
    $email = $usersModel->getSpecificUser(['users.email' => user()->email])->getResult()[0]->email;

    return $kegiatan->getJumlahKegiatan([
        'users.email' => $email,
        'logbook.logbookIsVerify' => 0
    ])->get()->getResult()[0]->logbookId;
}

function jumlahPenilaian()
{
    $usersModel = new App\Models\UsersModel;
    $penilaian = new App\Models\PenilaianModel;
    $id = user()->id;
    $rs = $usersModel->getProfile(['users.id' => $id])->getResult()[0]->dopingRumkitId;

    return $penilaian->getMenuNilai(['penilaianActive' => 1, 'rumkit_detail.rumkitDetRumkitId' => $rs])->get()->getResult();
}
