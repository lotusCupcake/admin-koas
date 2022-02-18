<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\JadwalKegiatanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapNilai extends BaseController
{
    protected $jadwalKegiatanModel;
    protected $penilaianModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->penilaianModel = new PenilaianModel();
        $this->spreadsheet = new Spreadsheet();
    }

    public function index()
    {
        $data = [
            'title' => "Rekap Nilai",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Nilai'],
            'menu' => $this->fetchMenu(),
            'validation' => \Config\Services::validation(),
            'penilaian' => $this->penilaianModel->findAll(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'dataResult' => [],
            'dataFilter' => [null, null]
        ];
        return view('pages/rekapNilai', $data);
    }

    public function rekapNilaiStase()
    {
        $rumahSakitId = $this->request->getPost('rumahSakitId');
        $staseRumkit = $this->jadwalKegiatanModel->rekapNilaiStase($rumahSakitId);
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseRumkit->getResult() as $data) {
            $lists .= "<option value='" . $data->rumkitDetId . "'>" . $data->staseNama . "</option>";
        }
        $callback = array('list_stase_rumkit' => $lists);
        echo json_encode($callback);
    }

    public function proses()
    {
        // dd($_POST);
        if (!$this->validate([
            'staseIdNilai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('rekapNilai')->withInput();
        }
        $kelompokId = trim($this->request->getPost('kelompokNama'));

        $rekapNilai = $this->penilaianModel->getFilterNilai($kelompokId)->getResult();

        $data = [
            'title' => "Rekap Nilaisi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Nilaisi'],
            'menu' => $this->fetchMenu(),
            'validation' => \Config\Services::validation(),
            'dataRumahSakit' => $this->penilaianModel->findAll(),
            'dataResult' => $rekapNilai,
            'dataFilter' => [$kelompokId]
        ];
        // dd($rekapNilai);
        $rekapNilai = $this->penilaianModel->getFilterNilai($kelompokId)->getResult();
        foreach ($rekapNilai as $absen) {
            $rumahSakit = $absen->rumahSakitShortname;
            $stase = $absen->staseNama;
            $kelompok = $absen->kelompokNama;
        }
        // session()->setFlashdata('success', 'Nilaisi Sudah Ditemukan ,Klik Export Untuk Download!');
        session()->setFlashdata('success', 'Nilaisi <strong> ' . $kelompok . ' Stase ' . $stase . ' Di ' . $rumahSakit . ' </strong> Sudah Ditemukan ,Klik Export Untuk Download!');
        return view('pages/rekapNilai', $data);
    }

    public function exportRekapNilai()
    {
        $jadwalRumkitDetId = trim($this->request->getPost('staseIdNilai'));
        $kelompokId = trim($this->request->getPost('kelompokIdNilai'));

        $rekapNilai = $this->penilaianModel->getFilterNilai($jadwalRumkitDetId, $kelompokId)->getResult();
        foreach ($rekapNilai as $absen) {
            $rumahSakit = $absen->rumahSakitShortname;
            $stase = $absen->staseNama;
            $kelompok = $absen->kelompokNama;
        }

        $row = 1;
        $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row, 'Rekap Nilaisi ' . $kelompok . ' Stase ' . $stase . ' Di ' . $rumahSakit)->mergeCells("A" . $row . ":E" . $row)->getStyle("A" . $row . ":E" . $row)->getFont()->setBold(true);
        $row++;
        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $row, 'No.')
            ->setCellValue('B' . $row, 'Mahasiswa')
            ->setCellValue('C' . $row, 'Tanggal/Waktu')
            ->setCellValue('D' . $row, 'Lokasi Nilai')
            ->setCellValue('E' . $row, 'Keterangan')->getStyle("A2:E2")->getFont()->setBold(true);
        $row++;
        $no = 1;
        foreach ($rekapNilai as $absen) {
            $this->spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $absen->kelompokDetNama . " (" . $absen->kelompokDetNim . ")")
                ->setCellValue('C' . $row, gmdate('Y-m-d H:i:s', ($absen->absensiTanggal / 1000)))
                ->setCellValue('D' . $row, $absen->absensiLokasi)
                ->setCellValue('E' . $row, $absen->absensiKeterangan);
            $row++;
        }
        $writer = new Xlsx($this->spreadsheet);

        $rekapNilai = $this->penilaianModel->getFilterNilai($jadwalRumkitDetId, $kelompokId)->getResult();
        foreach ($rekapNilai as $absen) {
            $rumahSakit = $absen->rumahSakitShortname;
            $stase = $absen->staseNama;
            $kelompok = $absen->kelompokNama;
        }

        $fileName = 'Rekap Nilaisi ' . $kelompok . ' Stase ' . $stase . ' Di ' . $rumahSakit;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        // session()->setFlashdata('success', 'Berhasil Export Data Tunggakan !');
        $writer->save('php://output');
    }
}
