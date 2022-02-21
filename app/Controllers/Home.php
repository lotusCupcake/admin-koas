<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index()
    {
        week('1908320079', 1, strtotime(date("Y-m-d", strtotime('2022-04-02'))));
        $data = [
            'title' => "Home",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Home', 'Dashboard'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/home', $data);
    }
}
