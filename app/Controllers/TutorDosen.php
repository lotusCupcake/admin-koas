<?php

namespace App\Controllers;

class TutorDosen extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Panduan Dosen",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['User Manual', 'Panduan Pengguna', 'Panduan Dosen'],
            'menu' => $this->fetchMenu(),
        ];
        return view('pages/tutorDosen', $data);
    }
}
