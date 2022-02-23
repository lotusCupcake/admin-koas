<?php

namespace App\Controllers;

use App\Models\BobotModel;
use App\Models\PenilaianModel;
use App\Models\StaseModel;

class Bobot extends BaseController
{
    protected $bobotModel;
    protected $penilaianModel;
    public function __construct()
    {
        $this->bobotModel = new BobotModel();
        $this->staseModel = new StaseModel();
        $this->penilaianModel = new PenilaianModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_bobot') ? $this->request->getVar('page_bobot') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $bobot = $this->staseModel->getStaseSearch($keyword, 'ASC');
        } else {
            $bobot = $this->staseModel->getStase('ASC');
        }

        $data = [
            'title' => "Bobot Nilai",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Setting', 'Bobot Nilai'],
            'bobot' => $bobot->paginate($this->numberPage, 'bobot'),
            'penilaian' => $this->penilaianModel->getPenilaian()->get()->getResult(),
            'pager' => $this->staseModel->pager,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu()
        ];
        return view('pages/bobot', $data);
    }

    public function savePenilaian($id)
    {
        //cek jika id kosong


        //cek jika penilaian tidak ada dipilih


        // $data = array('' => , );
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        $json = array();
        foreach ($_POST['penilaian'] as $i) {
            $data = array(
                $i => 0,
            );
            array_push($json, $data);
        }
        $penilaian = json_encode($json);
        $data = array(
            'settingBobotStaseId' => $id,
            'settingBobotKomposisiNilai' => $penilaian,
            'settingBobotStatus' => 0,
        );

        if ($this->bobotModel->insert($data)) {
            session()->setFlashdata('success', 'Setting nilai berhasil di simpan, silahkan lanjutkan ke setting bobot!');
            return redirect()->to('bobot');
        }
    }
}