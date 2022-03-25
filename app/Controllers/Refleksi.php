<?php

namespace App\Controllers;

use App\Models\RefleksiModel;
use App\Models\StaseModel;
use App\Models\DataKelompokModel;
use App\Models\JadwalKegiatanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Refleksi extends BaseController
{
    protected $RefleksiModel;
    protected $staseModel;
    protected $dataKelompokModel;
    protected $jadwalKegiatanModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->staseModel = new StaseModel();
        $this->dataKelompokModel = new DataKelompokModel();
        $this->spreadsheet = new Spreadsheet();
        $this->refleksiModel = new RefleksiModel();
    }

    public function index()
    {
        $where = null;
        if (in_groups('Koordik')) {
            $where = array('rumkit_detail.rumkitDetRumkitId' => getRs()[0]->dopingRumkitId);
        };
        $data = [
            'title' => "Refleksi Diri",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Refleksi Diri'],
            'refleksi' => $this->refleksiModel->findAll(),
            'dataStase' => $this->jadwalKegiatanModel->getStase($where)->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'refleksi' => [],
            'interpretasi' => [],
            'dataKompetensi' => [],
            'dataFilter' => [null, null]
        ];
        // dd($data);
        return view('pages/refleksi', $data);
    }

    public function refleksiKelompok()
    {
        $staseRefleksi = trim($this->request->getPost('staseRefleksi'));
        $kelompokRefleksi = $this->refleksiModel->refleksiKelompok($staseRefleksi);
        $lists = "<option value=''>Pilih Kelompok</option>";
        foreach ($kelompokRefleksi->getResult() as $data) {
            $lists .= "<option value='" . $data->kelompokId . "'>" . $data->kelompokNama . " - TA." . $data->kelompokTahunAkademik .  "</option>";
        }
        $callback = array('list_kelompok_refleksi' => $lists);
        echo json_encode($callback);
    }

    public function proses()
    {
        if (!$this->validate([
            'staseRefleksi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
            'kelompokRefleksi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelompok Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('rekapNilai')->withInput();
        }

        $staseRefleksi = trim($this->request->getPost('staseRefleksi'));
        $kelompokRefleksi = trim($this->request->getPost('kelompokRefleksi'));
        $refleksi = $this->refleksiModel->getFilterRefleksi($staseRefleksi, $kelompokRefleksi)->getResult();
        $namaKomp = [];
        foreach ($this->refleksiModel->getKompetensi()->getResult() as $komp) {
            array_push($namaKomp, $komp->kompetensiNama);
        }


        $where = null;
        if (in_groups('Koordik')) {
            $where = array('rumkit_detail.rumkitDetRumkitId' => getRs()[0]->dopingRumkitId);
        };
        $data = [
            'title' => "Refleksi Diri",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Mahasiswa', 'Refleksi Diri'],
            'dataStase' => $this->jadwalKegiatanModel->getStase($where)->getResult(),
            'validation' => \Config\Services::validation(),
            'menu' => $this->fetchMenu(),
            'kompetensi' => $this->refleksiModel->getKompetensi()->getResult(),
            'interpretasi' => $namaKomp,
            'refleksi' => $refleksi,
            'dataKompetensi' => array_unique($namaKomp),
            'dataFilter' => [$staseRefleksi, $kelompokRefleksi]
        ];

        $stase = $this->staseModel->getWhere(['staseId' => $staseRefleksi])->getResult()[0]->staseNama;
        $kelompok = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokRefleksi])->getResult()[0]->kelompokNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokRefleksi])->getResult()[0]->kelompokTahunAkademik;

        if ($refleksi == null) {
            session()->setFlashdata('danger', 'Refleksi Diri <strong>' . $kelompok . '- TA.' . $tahunAkademik .  '</strong> Di Stase <strong>' . $stase . '</strong> Belum Ada ,Coba Lagi Nanti!');
        } else {
            session()->setFlashdata('success', 'Refleksi Diri <strong>' . $kelompok . '- TA.' . $tahunAkademik .  '</strong> Di Stase <strong>' . $stase . '</strong> Sudah Ditemukan ,Klik Export Untuk Download!');
        }

        return view('pages/refleksi', $data);
    }

    public function exportRefleksi()
    {
        $staseRefleksi = trim($this->request->getPost('staseRefleksi'));
        $kelompokRefleksi = trim($this->request->getPost('kelompokRefleksi'));
        $refleksi = $this->refleksiModel->getFilterRefleksi($staseRefleksi, $kelompokRefleksi)->getResult();
        $stase = $refleksi[0]->staseNama;
        $kelompok = $refleksi[0]->kelompokNama;
        $tahunAkademik = $refleksi[0]->gradeRefleksiTahunAkademik;

        $this->spreadsheet = new Spreadsheet();
        $default = 1;
        $konten = 0;
        foreach ($refleksi as $mhs) {
            $konten = $default + $konten;
            $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $konten, $mhs->kelompokDetNama . ' (' . $mhs->kelompokDetNim . ')')->mergeCells("A" . $konten . ":" . "D" . $konten)->getStyle("A" . $konten . ":" . "D" . $konten)->getFont()->setBold(true);
            $konten = $konten + 1;
            $this->spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $konten, 'No.')
                ->setCellValue('B' . $konten, 'Kompetensi')
                ->setCellValue('C' . $konten, 'Tujuan Pembelajaran	')
                ->setCellValue('D' . $konten, 'Nilai')->getStyle("A" . $konten . ":" . "D" . $konten)->getFont()->setBold(true);

            $konten = $konten + 1;
            $total = 0;
            $no = 1;
            $gradeRefleksi = getRefleksi(['refleksi_grade.gradeRefleksiStaseId' => $mhs->staseId, 'refleksi_grade.gradeRefleksiNpm' => $mhs->kelompokDetNim])[0]->gradeRefleksiNilai;
            $grade = json_decode($gradeRefleksi);
            foreach ($this->refleksiModel->getKompetensi()->getResult() as $data) {
                $this->spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $konten, $no++)
                    ->setCellValue('B' . $konten, $data->kompetensiNama)->getStyle("A" . $konten . ":" . "B" . $konten);
                $this->spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('C' . $konten, $data->tujuanPembelajaran)->getStyle("C" . $konten);
                foreach ($grade as $gr) {
                    if ($data->tujuanId == $gr->tujuan) {
                        $total = $total + $gr->nilai;
                        $this->spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('D' . $konten, $gr->nilai)->getStyle("D" . $konten);
                    }
                }
                $konten++;
            }
            $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $konten, 'Total')->mergeCells("A" . $konten . ":" . "C" . $konten)->getStyle("A" . $konten . ":" . "C" . $konten)->getFont()->setBold(true);
            $this->spreadsheet->setActiveSheetIndex(0)->getStyle("A" . $konten . ":" . "C" . $konten)->getAlignment()->setHorizontal('center');
            $this->spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $konten, $total)->getStyle('D' . $konten)->getFont()->setBold(true);
            $konten = $konten + 1;
        }

        $writer = new Xlsx($this->spreadsheet);

        $fileName = 'Refleksi Diri Kelompok ' . $kelompok . ' ' . $tahunAkademik . ' - ' . $stase;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
