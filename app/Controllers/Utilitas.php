<?php

namespace App\Controllers;

class Utilitas extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Utilitas",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Setting', 'Utilitas'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/utilitas', $data);
    }
}
