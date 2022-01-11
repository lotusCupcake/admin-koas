<?php

namespace App\Controllers;

class Maintenance extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Maintenance",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Home', 'Maintenance'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/maintenance', $data);
    }
}
