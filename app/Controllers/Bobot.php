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
        // dd($_POST);
        //cek jika id kosong
        if ($id == null) {
            session()->setFlashdata('danger', 'Stase Belum Dipilih!');
            return redirect()->to('bobot');
        }
        // dd(count($_POST['penilaian']));

        //cek jika penilaian tidak ada dipilih
        if (count($_POST) <= 1) {
            session()->setFlashdata('danger', 'Penilaian Belum Dipilih!');
            return redirect()->to('bobot');
        }

        // $data = array('' => , );
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        $json = array();
        foreach ($_POST['penilaian'] as $i) {
            $data = array(
                'penilaian' => $i, 'bobot' => 0,
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
            session()->setFlashdata('success', 'Setting Nilai Berhasil Di Simpan, Silahkan Lanjutkan Ke Setting Bobot!');
            return redirect()->to('bobot');
        }
    }

    public function saveBobot($id)
    {
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        $json = array();
        for ($i = 0; $i < count($keys); $i++) {
            if (is_numeric($keys[$i])) {
                $data = array(
                    'penilaian' => $keys[$i], 'bobot' => $values[$i],
                );
                array_push($json, $data);
            }
            // hitung bobot nilai
        }
        // jika nilai belum atau lebih dari 100 maka force dan tampilkan pesan
        $penilaian = json_encode($json);
        $data = array(
            'settingBobotStaseId' => $id,
            'settingBobotKomposisiNilai' => $penilaian,
            'settingBobotStatus' => 1,
        );

        if ($this->bobotModel->update(getStatus(['settingBobotStaseId' => $id])[0]->settingBobotId, $data)) {
            session()->setFlashdata('success', 'Setting bobot berhasil di simpan dan siap digunakan!');
            return redirect()->to('bobot');
        }
    }
}
