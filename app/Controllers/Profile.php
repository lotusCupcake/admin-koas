<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class Profile extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Profile",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Home', 'Profile'],
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
        ];
        // dd($data);
        return view('pages/profile', $data);
    }
}
