<?php

namespace App\Controllers;

use App\Models\DosenPembimbingModel;

class Profile extends BaseController
{
    protected $modelDoping;

    public function __construct()
    {
        $this->modelDoping = new DosenPembimbingModel();
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
        $image = str_replace('./signature-image/', '', $file);

        $id = getUser(user()->id)->dopingId;
        $dataEdit = array('dopingSignature' => $image);
        $this->modelDoping->update($id, $dataEdit);
        echo '<img src="' . base_url() . '/' . $image . '">';
    }
}
