<?php

namespace App\Controllers;

use App\Models\JadwalKegiatanModel;
use App\Models\DataKelompokModel;
use App\Models\StaseModel;
use App\Models\StaseRumahSakitModel;
use App\Models\DataRumahSakitModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapAbsen extends BaseController
{
    protected $jadwalKegiatanModel;
    protected $dataKelompokModel;
    protected $staseModel;
    protected $staseRumahSakitModel;
    protected $dataRumahSakitModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->dataKelompokModel = new DataKelompokModel();
        $this->staseModel = new StaseModel();
        $this->staseRumahSakitModel = new StaseRumahSakitModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
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
            $lists .= "<option value='" . $data->rumkitDetId . "'>" . $data->staseNama . "</option>";
        }
        $callback = array('list_stase_rumkit' => $lists);
        echo json_encode($callback);
    }

    public function rekapAbsenKelompok()
    {
        $kelompokId = [];
        $rumkitDetailId = trim($this->request->getPost('staseId'));

        $jadwalKelompok = $this->jadwalKegiatanModel->rekapAbsenKelompok($rumkitDetailId);
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

        $rumahSakitId = trim($this->request->getPost('rumahSakitIdAbsen'));
        $rumkitDetailId = trim($this->request->getPost('staseIdAbsen'));
        $kelompokId = trim($this->request->getPost('kelompokIdAbsen'));

        $rumkitDetail = $this->staseRumahSakitModel->getWhere(['rumkitDetId' => $rumkitDetailId])->getResult();
        foreach ($rumkitDetail as $rumkitStaseId) {
            $staseId = $rumkitStaseId->rumkitDetStaseId;
        }

        $rekapAbsen = $this->jadwalKegiatanModel->getFilterAbsen($staseId, $kelompokId)->getResult();
        $mahasiswa = $this->jadwalKegiatanModel->getMahasiswa(['kelompok.kelompokId' => $kelompokId])->getResult();

        $data = [
            'title' => "Rekap Absensi",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Absensi'],
            'menu' => $this->fetchMenu(),
            'validation' => \Config\Services::validation(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'dataResult' => $rekapAbsen,
            'mahasiswa' => $mahasiswa,
            'dataFilter' => [$rumkitDetailId, $kelompokId],
            'minDate' => date("Y-m-d", minDateKelByDetail($kelompokId, $rumkitDetailId) / 1000),
            'maxDate' => date("Y-m-d", maxDateKelByDetail($kelompokId, $rumkitDetailId) / 1000),
        ];


        $stase = $this->staseModel->getWhere(['staseId' => $staseId])->getResult()[0]->staseNama;
        $rumahSakit = $this->dataRumahSakitModel->getWhere(['rumahSakitId' => $rumahSakitId])->getResult()[0]->rumahSakitShortname;
        $kelompok = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokId])->getResult()[0]->kelompokNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokId])->getResult()[0]->kelompokTahunAkademik;

        if ($rekapAbsen == null) {
            session()->setFlashdata('danger', 'Absensi <strong> ' . $kelompok . '- TA.' . $tahunAkademik . '</strong>, Stase <strong>' . $stase . '</strong> Di <strong>' . $rumahSakit . '</strong> Belum Ada ,Coba Lagi Nanti!');
        } else {
            session()->setFlashdata('success', 'Absensi <strong> ' . $kelompok . '- TA.' . $tahunAkademik . '</strong>, Stase <strong> ' . $stase . '</strong> Di <strong>' . $rumahSakit . '</strong> Sudah Ditemukan ,Klik Export Untuk Download!');
        }

        return view('pages/rekapAbsen', $data);
    }

    public function exportRekapAbsen()
    {
        $jadwalRumkitDetId = trim($this->request->getPost('staseIdAbsen'));
        $kelompokId = trim($this->request->getPost('kelompokIdAbsen'));

        $rekapAbsen = $this->jadwalKegiatanModel->getFilterAbsen($jadwalRumkitDetId, $kelompokId)->getResult();
        $rumahSakit = $rekapAbsen[0]->rumahSakitShortname;
        $stase = $rekapAbsen[0]->staseNama;
        $kelompok = $rekapAbsen[0]->kelompokNama;
        $tahunAkademik = $rekapAbsen[0]->absensiTahunAkademik;

        $row = 1;
        $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row, 'Rekap Absensi ' . $kelompok . ' ' . $tahunAkademik . ' Di ' . $rumahSakit . ' Stase ' . $stase)->mergeCells("A" . $row . ":E" . $row)->getStyle("A" . $row . ":E" . $row)->getFont()->setBold(true);
        $row++;
        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $row, 'No.')
            ->setCellValue('B' . $row, 'Mahasiswa')
            ->setCellValue('C' . $row, 'Presensi Lengkap')
            ->setCellValue('D' . $row, 'Presensi Sekali')
            ->setCellValue('E' . $row, 'Absen')->getStyle("A2:E2")->getFont()->setBold(true);
        $row++;
        $no = 1;
        $mn2 = date("Y-m-d", minDateKelByDetail($kelompokId, $jadwalRumkitDetId) / 1000);
        $mx2 = date("Y-m-d", maxDateKelByDetail($kelompokId, $jadwalRumkitDetId) / 1000);
        $mahasiswa = $this->jadwalKegiatanModel->getMahasiswa(['kelompok.kelompokId' => $kelompokId])->getResult();
        $rekapAbsen = $this->jadwalKegiatanModel->getFilterAbsen($jadwalRumkitDetId, $kelompokId)->getResult();
        foreach ($mahasiswa as $mhs) {
            $jumlah = 0;
            $hadir = 0;
            $Absen1 = 0;
            while (strtotime($mn2) <= strtotime($mx2)) {
                $jumlah++;
                if (jumlahPresensi($rekapAbsen, $mhs->kelompokDetNim, $mn2)[1] == 2) {
                    $hadir++;
                } else {
                    $hadir = $hadir;
                };
                if (jumlahPresensi($rekapAbsen, $mhs->kelompokDetNim, $mn2)[1] == 1) {
                    $Absen1++;
                } else {
                    $Absen1 = $Absen1;
                }
                $mn2 = date("Y-m-d", (int)strtotime("+1 day", strtotime($mn2)));
            }
            $this->spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $mhs->kelompokDetNama . " (" . $mhs->kelompokDetNim . ")")
                ->setCellValue('C' . $row, "(" . $hadir . "/" . $jumlah . ")")
                ->setCellValue('D' . $row, "(" . $Absen1 . "/" . $jumlah . ")")
                ->setCellValue('E' . $row, "(" . ($jumlah - ($hadir + $Absen1)) . "/" . $jumlah . ")");
            $row++;
            $mn2 = date("Y-m-d", minDateKelByDetail($kelompokId, $jadwalRumkitDetId) / 1000);
        }
        $writer = new Xlsx($this->spreadsheet);

        $fileName = 'Rekap Absensi Kelompok ' . $kelompok . ' ' . $tahunAkademik . ' - ' . $rumahSakit . ' - ' . $stase;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
