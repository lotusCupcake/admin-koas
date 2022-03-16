<?php

namespace App\Controllers;

class Tutor extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Panduan Pengguna",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['User Manual', 'Panduan Pengguna'],
            'menu' => $this->fetchMenu(),
        ];
        return view('pages/tutor', $data);
    }
}
