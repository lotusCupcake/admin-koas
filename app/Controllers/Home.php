<?php

namespace App\Controllers;

use App\Models\PopupModel;

class Home extends BaseController
{
    protected $popupModel;
    public function __construct()
    {
        $this->popupModel = new PopupModel();
    }

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

    public function savePopup()
    {
        $data = array('email' =>  $this->request->getVar('email'));
        $this->popupModel->insert($data);
        $data = [
            'title' => "Home",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Home', 'Dashboard'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/home', $data);
    }
}
