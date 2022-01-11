<?php

namespace App\Controllers;

class MahasiswaProfesi extends BaseController
{
    protected $curl;
    public function __construct()
    {
        $this->curl = service('curlrequest');
    }
    public function index()
    {
        $data = [
            'title' => "Mahasiswa Profesi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Master', 'Data', 'Mahasiswa Profesi'],
            'mahasiswaProfesi' => $this->getMahasiswa(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/mahasiswaProfesi', $data);
    }

    public function getMahasiswa()
    {
        $response = $this->curl->request("GET", "https://api.umsu.ac.id/koas/mahasiswa", [
            "headers" => [
                "Accept" => "application/json"
            ],

        ]);

        return json_decode($response->getBody())->data;
    }
}
