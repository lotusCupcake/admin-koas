<?php

namespace App\Controllers;

class DosenPembimbing extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Dosen Pembimbing",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Dosen Pembimbing'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dosenPembimbing', $data);
    }
}
