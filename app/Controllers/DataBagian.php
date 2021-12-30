<?php

namespace App\Controllers;

class DataBagian extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Data Bagian",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Utama', 'Data Bagian'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/dataBagian', $data);
    }
}
