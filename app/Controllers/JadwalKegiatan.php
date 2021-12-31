<?php

namespace App\Controllers;

use App\Models\JadwalKegiatanModel;
// use App\Models\DataBagianModel;
// use App\Models\DataRumahSakitModel;

class JadwalKegiatan extends BaseController
{
    protected $JadwalKegiatanModel;
    // protected $DataBagianModel;
    // protected $DataRumahSakitModel;
    public function __construct()
    {
        $this->acaraModel = new JadwalKegiatanModel();
        // $this->penyiarModel = new DataBagianModel();
        // $this->penyiarModel = new DataRumahSakitModel();
    }
    public function index()
    {
        $data = [
            'title' => "Jadwal Kegiatan",
            'appName' => "KOAS",
            'breadcrumb' => ['Home', 'Jadwal Kegiatan'],
            'menu' => $this->fetchMenu()
        ];
        return view('pages/jadwalKegiatan', $data);
    }
}
