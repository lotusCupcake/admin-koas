<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Home",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Home', 'Dashboard'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/home', $data);
    }
}
