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
            'breadcrumb' => ['Master', 'Data', 'Bobot Nilai'],
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
        dd($_POST);
        if ($id == null) {
            session()->setFlashdata('danger', 'Stase Belum Dipilih!');
            return redirect()->to('bobot');
        }

        if (count($_POST) <= 1) {
            session()->setFlashdata('danger', 'Penilaian Belum Dipilih!');
            return redirect()->to('bobot');
        }

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

        $stase = $this->staseModel->findAll();
        foreach ($stase as $row) {
            $nama = $row->staseNama;
        }

        if ($this->bobotModel->insert($data)) {
            session()->setFlashdata('success', 'Setting Penilaian Stase' . $nama . 'Berhasil Di Simpan, Silahkan Lanjutkan Ke Setting Bobot!');
            return redirect()->to('bobot');
        }
    }

    public function saveBobot($id)
    {
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        $json = array();
        $total = 0;
        for ($i = 0; $i < count($keys); $i++) {
            if (is_numeric($keys[$i])) {
                $data = array(
                    'penilaian' => $keys[$i], 'bobot' => $values[$i],
                );
                array_push($json, $data);
                $total = $total + $values[$i];
            }
        }
        if ($total < 100) {
            session()->setFlashdata('danger', 'Total Bobot Nilai Kurang Dari 100!');
            return redirect()->to('bobot');
        } elseif ($total > 100) {
            session()->setFlashdata('danger', 'Total Bobot Nilai Lebih Dari 100!');
            return redirect()->to('bobot');
        } else {
            $penilaian = json_encode($json);
            $data = array(
                'settingBobotStaseId' => $id,
                'settingBobotKomposisiNilai' => $penilaian,
                'settingBobotStatus' => 1,
            );

            $stase = $this->staseModel->findAll();
            foreach ($stase as $row) {
                $namaStase = $row->staseNama;
            }

            $penilaian = $this->penilaianModel->findAll();
            foreach ($penilaian as $row) {
                $namaPenilaian = $row->penilaianNama;
            }

            if ($this->bobotModel->update(getStatus(['settingBobotStaseId' => $id])[0]->settingBobotId, $data)) {
                session()->setFlashdata('success', 'Setting Bobot Penilaian ' . $namaPenilaian . 'Untuk Stase ' . $namaStase . ' Berhasil Di Simpan Dan Siap Digunakan!');
                return redirect()->to('bobot');
            }
        }
    }

    public function delete($id)
    {
        $stase = $this->staseModel->getWhere(['staseId' => $id])->getResult()[0]->staseNama;

        if ($this->bobotModel->delete($id)) {
            session()->setFlashdata('success', 'Berhasil Reset Penilaian Stase ' . $stase . '!');
        };
        return redirect()->to('bobot');
    }

    public function getPenilaian()
    {
        $request = 1;
        $name = $this->request->getVar('name');

        if ($this->request->getVar('request') != null) {
            $request = $this->request->getVar('request');
        }

        if ($request == 1) {
            $data = array();
            $penilaian = $this->penilaianModel->getPenilaian()->get()->getResult();
            foreach ($penilaian as $row) {
                $data[] = array(
                    'id' => $row->penilaianId, 'text' => $row->penilaianNama,
                );
            }
            echo json_encode($data);
            exit;
        }

        if ($request == 2) {

            $html = "<br><select class='select2_el' multiple='' name='" . $name . "[]'><option value='0'>- Search user -</option></select><br>";
            echo $html;
            exit;
        }
    }
}
