<?php

namespace App\Controllers;

class Maintenance extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Maintenance",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Mainteance'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/maintenance', $data);
    }
}
