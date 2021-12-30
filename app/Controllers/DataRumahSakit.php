<?php

namespace App\Controllers;

class DataRumahSakit extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Data Rumah Sakit",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Data Rumah Sakit'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dataRumahSakit', $data);
    }
}
