<?php

namespace App\Controllers;

class TutorKoordik extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Panduan Koordik",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['User Manual', 'Panduan Pengguna', 'Panduan Koordik'],
            'menu' => $this->fetchMenu(),
        ];
        return view('pages/tutorKoordik', $data);
    }
}
