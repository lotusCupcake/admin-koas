<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Profile extends BaseController
{
    protected $modelUsers;

    public function __construct()
    {
        $this->modelUsers = new UsersModel();
    }

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

    public function insert_signature()
    {
        $img = $this->request->getVar('image');
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = './signature-image/' . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        $image = str_replace('./', '', $file);


        // $this->modelUsers->update($image);
        // echo '<img src="' . base_url() . '/' . $image . '">';
    }
}
