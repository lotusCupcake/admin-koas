<?php

namespace App\Controllers;

class TutorAdmin extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Panduan Admin",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['User Manual', 'Panduan Pengguna', 'Panduan Admin'],
            'menu' => $this->fetchMenu(),
        ];
        return view('pages/tutorAdmin', $data);
    }
}
