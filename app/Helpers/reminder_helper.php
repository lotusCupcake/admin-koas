<?php
function jumlahFollowUp()
{
    $followUpModel = new App\Models\FollowUpModel;
    $usersModel = new App\Models\UsersModel;
    $email = $usersModel->getSpecificUser(['users.email' => user()->email])->getResult()[0]->email;

    $curl = service('curlrequest');
    $response = $curl->request("GET", "https://api.umsu.ac.id/koas/tahunAkademik", [
        "headers" => [
            "Accept" => "application/json"
        ],

    ]);

    return $followUpModel->getJumlahFollowUp([
        'users.email' => $email,
        'follow_up.followUpVerify' => 0,
        'follow_up.followUpTahunAkademik' => json_decode($response->getBody())->data
    ])->get()->getResult()[0]->followUpId;
}

function jumlahKegiatan()
{
    $kegiatan = new App\Models\KegiatanMahasiswaModel;
    $usersModel = new App\Models\UsersModel;
    $email = $usersModel->getSpecificUser(['users.email' => user()->email])->getResult()[0]->email;

    $curl = service('curlrequest');
    $response = $curl->request("GET", "https://api.umsu.ac.id/koas/tahunAkademik", [
        "headers" => [
            "Accept" => "application/json"
        ],

    ]);
    return $kegiatan->getJumlahKegiatan([
        'users.email' => $email,
        'logbook.logbookIsVerify' => 0,
        'logbook.logbookTahunAkademik' => json_decode($response->getBody())->data
    ])->get()->getResult()[0]->logbookId;
}

function getPenilaianRs()
{
    $usersModel = new App\Models\UsersModel;
    $penilaian = new App\Models\GradeModel();
    $rs = $usersModel->getProfile(['users.id' => user()->id])->getResult()[0]->dopingRumkitId;

    $curl = service('curlrequest');
    $response = $curl->request("GET", "https://api.umsu.ac.id/koas/tahunAkademik", [
        "headers" => [
            "Accept" => "application/json"
        ],

    ]);
    return $penilaian->getPenilaianVerifikasi(['dosen_pembimbing.dopingRumkitId ' => $rs, 'penilaian_grade.gradeApproveStatus ' => 0, 'penilaian_grade.gradeTahunAkademik' => json_decode($response->getBody())->data])->get()->getResult();
}

function getPenilaianDosen()
{
    $usersModel = new App\Models\UsersModel;
    $penilaian = new App\Models\GradeModel();
    $email = $usersModel->getSpecificUser(['users.email' => user()->email])->getResult()[0]->email;

    $curl = service('curlrequest');
    $response = $curl->request("GET", "https://api.umsu.ac.id/koas/tahunAkademik", [
        "headers" => [
            "Accept" => "application/json"
        ],

    ]);
    return $penilaian->getPenilaianVerifikasi(['dosen_pembimbing.dopingEmail ' => $email, 'penilaian_grade.gradeApproveStatus ' => 1, 'penilaian_grade.gradeTahunAkademik' => json_decode($response->getBody())->data])->get()->getResult();
}
