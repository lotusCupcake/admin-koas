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

function getPenilaianRs()
{
    $usersModel = new App\Models\UsersModel;
    $penilaian = new App\Models\GradeModel();
    $rs = $usersModel->getProfile(['users.id' => user()->id])->getResult()[0]->dopingRumkitId;

    return $penilaian->getPenilaianVerifikasi(['dosen_pembimbing.dopingRumkitId ' => $rs, 'penilaian_grade.gradeApproveStatus ' => 0])->get()->getResult();
}

function getPenilaianDosen()
{
    $usersModel = new App\Models\UsersModel;
    $penilaian = new App\Models\GradeModel();
    $email = $usersModel->getSpecificUser(['users.email' => user()->email])->getResult()[0]->email;

    return $penilaian->getPenilaianVerifikasi(['dosen_pembimbing.dopingEmail ' => $email, 'penilaian_grade.gradeApproveStatus ' => 0])->get()->getResult();
}
