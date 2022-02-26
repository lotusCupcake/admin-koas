<?php

namespace App\Controllers;

use App\Models\JadwalKegiatanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapAbsen extends BaseController
{
    protected $jadwalKegiatanModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->spreadsheet = new Spreadsheet();
    }

    public function index()
    {
        $data = [
            'title' => "Rekap Absensi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Absensi'],
            'menu' => $this->fetchMenu(),
            'validation' => \Config\Services::validation(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'dataResult' => [],
            'mahasiswa' => [],
            'dataFilter' => [null, null]
        ];
        return view('pages/rekapAbsen', $data);
    }

    public function rekapAbsenStase()
    {
        $rumahSakitId = trim($this->request->getPost('rumahSakitId'));
        $staseRumkit = $this->jadwalKegiatanModel->rekapAbsenStase($rumahSakitId);
        $lists = "<option value=''>Pilih Stase</option>";
        foreach ($staseRumkit->getResult() as $data) {
            $lists .= "<option value='" . $data->rumkitDetStaseId . "'>" . $data->staseNama . "</option>";
        }
        $callback = array('list_stase_rumkit' => $lists);
        echo json_encode($callback);
    }

    public function rekapAbsenKelompok()
    {
        $kelompokId = [];
        $staseId = trim($this->request->getPost('staseId'));

        $jadwalKelompok = $this->jadwalKegiatanModel->rekapAbsenKelompok($staseId);
        // dd($jadwalKelompok);
        foreach ($jadwalKelompok->getResult() as $kelompok_jadwal) {
            array_push($kelompokId, $kelompok_jadwal->jadwalKelompokId);
        }

        if (count($kelompokId) == 0) {
            $kelompokId = [0];
        }
        $kelompok = $this->jadwalKegiatanModel->Show_Kelompok($kelompokId);
        // Proses Get Data Stase Dari Tabel Kelompok
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($jadwalKelompok->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . " - TA." . $data->kelompokTahunAkademik . "</option>"; // Tambahkan tag option ke variabel $lists
        }
        $callback = array('list_kelompok' => $lists); // Masukan Variabel Lists Tadi Ke Dalam Array $callback dengan index array : list_jurusan
        echo json_encode($callback); // konversi variabel $callback menjadi JSON
    }

    public function proses()
    {
        // dd($_POST);
        if (!$this->validate([
            'rumahSakitIdAbsen' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rumah Sakit Harus Dipilih!',
                ]
            ],
            'staseIdAbsen' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
            'kelompokIdAbsen' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('rekapAbsen')->withInput();
        }
        $staseId = trim($this->request->getPost('staseIdAbsen'));
        $kelompokId = trim($this->request->getPost('kelompokIdAbsen'));

        $rekapAbsen = $this->jadwalKegiatanModel->getFilterAbsen($staseId, $kelompokId)->getResult();
        $mahasiswa = $this->jadwalKegiatanModel->getMahasiswa(['kelompok.kelompokId' => $kelompokId])->getResult();
        // dd($mahasiswa);

        $data = [
            'title' => "Rekap Absensi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Absensi'],
            'menu' => $this->fetchMenu(),
            'validation' => \Config\Services::validation(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'dataResult' => $rekapAbsen,
            'mahasiswa' => $mahasiswa,
            'dataFilter' => [$staseId, $kelompokId],
            'minDate' => date("Y-m-d", minDateKelByDetail($kelompokId, $staseId) / 1000),
            'maxDate' => date("Y-m-d", maxDateKelByDetail($kelompokId, $staseId) / 1000),
        ];

        foreach ($rekapAbsen as $absen) {
            $rumahSakit = $absen->rumahSakitShortname;
            $stase = $absen->staseNama;
            $kelompok = $absen->kelompokNama;
        }
        // session()->setFlashdata('success', 'Absensi Sudah Ditemukan ,Klik Export Untuk Download!');
        session()->setFlashdata('success', 'Absensi <strong> ' . $kelompok . ' Stase ' . $stase . ' Di ' . $rumahSakit . ' </strong> Sudah Ditemukan ,Klik Export Untuk Download!');
        return view('pages/rekapAbsen', $data);
    }

    public function exportRekapAbsen()
    {
        $jadwalRumkitDetId = trim($this->request->getPost('staseIdAbsen'));
        $kelompokId = trim($this->request->getPost('kelompokIdAbsen'));

        $rekapAbsen = $this->jadwalKegiatanModel->getFilterAbsen($jadwalRumkitDetId, $kelompokId)->getResult();
        foreach ($rekapAbsen as $absen) {
            $rumahSakit = $absen->rumahSakitShortname;
            $stase = $absen->staseNama;
            $kelompok = $absen->kelompokNama;
        }

        $row = 1;
        $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row, 'Rekap Absensi ' . $kelompok . ' Stase ' . $stase . ' Di ' . $rumahSakit)->mergeCells("A" . $row . ":E" . $row)->getStyle("A" . $row . ":E" . $row)->getFont()->setBold(true);
        $row++;
        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $row, 'No.')
            ->setCellValue('B' . $row, 'Mahasiswa')
            ->setCellValue('C' . $row, 'Tanggal/Waktu')
            ->setCellValue('D' . $row, 'Lokasi Absen')
            ->setCellValue('E' . $row, 'Keterangan')->getStyle("A2:E2")->getFont()->setBold(true);
        $row++;
        $no = 1;
        foreach ($rekapAbsen as $absen) {
            $this->spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $absen->kelompokDetNama . " (" . $absen->kelompokDetNim . ")")
                ->setCellValue('C' . $row, gmdate('Y-m-d H:i:s', ($absen->absensiTanggal / 1000)))
                ->setCellValue('D' . $row, $absen->absensiLokasi)
                ->setCellValue('E' . $row, $absen->absensiKeterangan);
            $row++;
        }
        $writer = new Xlsx($this->spreadsheet);

        $rekapAbsen = $this->jadwalKegiatanModel->getFilterAbsen($jadwalRumkitDetId, $kelompokId)->getResult();
        foreach ($rekapAbsen as $absen) {
            $rumahSakit = $absen->rumahSakitShortname;
            $stase = $absen->staseNama;
            $kelompok = $absen->kelompokNama;
        }

        $fileName = 'Rekap Absensi ' . $kelompok . ' Stase ' . $stase . ' Di ' . $rumahSakit;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        // session()->setFlashdata('success', 'Berhasil Export Data Tunggakan !');
        $writer->save('php://output');
    }
}
