<?php

namespace App\Controllers;

use App\Models\BobotModel;
use App\Models\PenilaianModel;

class Bobot extends BaseController
{
    protected $bobotModel;
    protected $penilaianModel;
    public function __construct()
    {
        $this->bobotModel = new BobotModel();
        $this->penilaianModel = new PenilaianModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_bobot') ? $this->request->getVar('page_bobot') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $bobot = $this->bobotModel->getBobotSearch($keyword);
        } else {
            $bobot = $this->bobotModel->getBobot();
        }

        $data = [
            'title' => "Bobot Nilai",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Setting', 'Bobot Nilai'],
            'bobot' => $bobot->paginate($this->numberPage, 'bobot'),
            'penilaian' => $this->penilaianModel->getPenilaian()->get()->getResult(),
            'pager' => $this->bobotModel->pager,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        // dd($data['penilaian']);
        return view('pages/bobot', $data);
    }

    public function savePenilaian($id)
    {
        dd($_POST);
    }
}
