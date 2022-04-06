<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\JadwalKegiatanModel;
use App\Models\DataKelompokModel;
use App\Models\StaseModel;
use App\Models\DataRumahSakitModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapNilai extends BaseController
{
    protected $jadwalKegiatanModel;
    protected $dataKelompokModel;
    protected $staseModel;
    protected $dataRumahSakitModel;
    protected $penilaianModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->jadwalKegiatanModel = new JadwalKegiatanModel();
        $this->dataKelompokModel = new DataKelompokModel();
        $this->staseModel = new StaseModel();
        $this->dataRumahSakitModel = new DataRumahSakitModel();
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
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'dataMhs' => [],
            'dataKomp' => [],
            'dataFilter' => [null, null]
        ];
        return view('pages/rekapNilai', $data);
    }

    public function rekapNilaiStase()
    {
        $rumahSakitId = $this->request->getPost('rumahSakitId');
        $staseRumkit = $this->jadwalKegiatanModel->rekapNilaiStase($rumahSakitId);
        $rumahSakit = $this->dataRumahSakitModel->getWhere(['rumahSakitId' => $rumahSakitId])->getResult()[0]->rumahSakitShortname;
        if ($staseRumkit == null) {
            session()->setFlashdata('danger', 'Nilai Kelompok Di Rumah Sakit <strong>' . $rumahSakit . '</strong> Belum Ada ,Coba Lagi Nanti!');
            return view('pages/rekapNilai');
        } else {
            $lists = "<option value=''>Pilih Stase</option>";
            foreach ($staseRumkit->getResult() as $data) {
                $lists .= "<option value='" . $data->rumkitDetId . "'>" . $data->staseNama . "</option>";
            }
            $callback = array('list_stase_rumkit' => $lists);
            echo json_encode($callback);
        }
    }

    public function proses()
    {
        if (!$this->validate([
            'staseIdAbsen' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stase Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to('rekapNilai')->withInput();
        }

        $rumahSakitId = trim($this->request->getPost('rumahSakitIdAbsen'));
        $staseId = trim($this->request->getPost('staseIdAbsen'));
        $kelompokId = trim($this->request->getPost('kelompokIdAbsen'));

        $dataMhs = $this->penilaianModel->getFilterNilai(['kelompok.kelompokId' => $kelompokId, 'stase.staseId' => $staseId])->getResult();

        $data = [
            'title' => "Rekap Nilai",
            'appName' => "Dokter Muda",
            'breadcrumb' => ['Administrasi', 'Rekap Nilai'],
            'menu' => $this->fetchMenu(),
            'validation' => \Config\Services::validation(),
            'dataRumahSakit' => $this->jadwalKegiatanModel->getRumkit()->getResult(),
            'dataMhs' => $dataMhs,
            'dataKomp' => json_decode(getStatus(['setting_bobot.settingBobotStaseId' => $staseId])[0]->settingBobotKomposisiNilai),
            'dataFilter' => [$staseId, $kelompokId, $rumahSakitId]
        ];

        $stase = $this->staseModel->getWhere(['staseId' => $staseId])->getResult()[0]->staseNama;
        $rumahSakit = $this->dataRumahSakitModel->getWhere(['rumahSakitId' => $rumahSakitId])->getResult()[0]->rumahSakitShortname;
        $kelompok = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokId])->getResult()[0]->kelompokNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $kelompokId])->getResult()[0]->kelompokTahunAkademik;

        if ($dataMhs == null) {
            session()->setFlashdata('danger', 'Nilai <strong> ' . $kelompok . '- TA.' . $tahunAkademik . '</strong>, Stase <strong>' . $stase . '</strong> Di <strong>' . $rumahSakit . '</strong> Belum Ada ,Coba Lagi Nanti!');
        } else {
            session()->setFlashdata('success', 'Nilai <strong> ' . $kelompok . '- TA.' . $tahunAkademik . '</strong>, Stase <strong>' . $stase . '</strong> Di <strong>' . $rumahSakit . '</strong> Sudah Ditemukan ,Klik Export Untuk Download!');
        }
        return view('pages/rekapNilai', $data);
    }

    public function exportRekapNilai($mhs)
    {
        $dataMhs = $this->penilaianModel->getFilterNilai(['kelompok.kelompokId' => $this->request->getPost('kelompokId'), 'stase.staseId' => $this->request->getPost('staseId'), 'kelompok_detail.kelompokDetNim' => $mhs])->getResult();
        foreach ($dataMhs as $mahasiswa) {
            $mhsNama = $mahasiswa->kelompokDetNama;
            $mhsNpm = $mahasiswa->kelompokDetNim;
        }
        $stase = $this->staseModel->getWhere(['staseId' => $this->request->getPost('staseId')])->getResult()[0]->staseNama;
        $tahunAkademik = $this->dataKelompokModel->getWhere(['kelompokId' => $this->request->getPost('kelompokId')])->getResult()[0]->kelompokTahunAkademik;

        $spreadsheet = new Spreadsheet();

        $default = 1;
        $konten = 0;
        $konten = $default + $konten;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $konten, $mhsNama . ' ( ' . $mhsNpm . ')' . ' - ' . $stase . ' - ' . $tahunAkademik)->mergeCells("A" . $konten . ":" . "C" . $konten)->getStyle("A" . $konten . ":" . "C" . $konten)->getFont()->setBold(true);
        $konten++;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $konten, 'No.')
            ->setCellValue('B' . $konten, 'Jenis Kegiatan')
            ->setCellValue('C' . $konten, 'Nilai Akhir (Bobot X Nilai)')->getStyle("A" . $konten . ":" . "C" . $konten)->getFont()->setBold(true);

        $konten++;
        $nilaiAkhir = 0;
        $dataKomp = json_decode(getStatus(['setting_bobot.settingBobotStaseId' => $this->request->getPost('staseId')])[0]->settingBobotKomposisiNilai);
        $no = 1;
        foreach ($dataMhs as $detail) {
            foreach ($dataKomp as $komp) {
                $nilaiAkhir += getNilai(json_decode($komp->penilaian), $detail->kelompokDetNim, $detail->staseId);
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $konten, $no++)
                    ->setCellValue('B' . $konten, getPenilaian($komp->penilaian)[0]->penilaianNamaSingkat)
                    ->setCellValue('C' . $konten, number_format(getNilai(json_decode($komp->penilaian), $detail->kelompokDetNim, $detail->staseId), 2))->getStyle("A" . $konten . ":" . "C" . $konten);
                $konten++;
            }
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $konten, 'Total')->mergeCells("A" . $konten . ":" . "B" . $konten)->getStyle("A" . $konten . ":" . "C" . $konten)->getFont()->setBold(true);
            $spreadsheet->setActiveSheetIndex(0)->getStyle("A" . $konten . ":" . "C" . $konten)->getAlignment()->setHorizontal('center');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $konten, $nilaiAkhir . ' / ' . getKonversi($nilaiAkhir))->getStyle('C' . $konten)->getFont()->setBold(true);
            $konten++;

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $konten, $no++)
                ->setCellValue('B' . $konten, "Attitude/" . getPenilaian("[\"12\"]")[0]->penilaianNamaSingkat)
                ->setCellValue('C' . $konten, (getNilaiGr(12, $detail->kelompokDetNim, $detail->staseId)[0] < 1) ? 'Unsufficient' : 'Sufficient')->getStyle("A" . $konten . ":" . "B" . $konten);
            $spreadsheet->setActiveSheetIndex(0)->getStyle("C" . $konten)->getAlignment()->setHorizontal('center');
            $konten++;

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $konten, 'Sanksi')->mergeCells("A" . $konten . ":" . "C" . $konten)->getStyle("A" . $konten . ":" . "C" . $konten)->getFont()->setBold(true);
            $spreadsheet->setActiveSheetIndex(0)->getStyle("A" . $konten . ":" . "C" . $konten)->getAlignment()->setHorizontal('center');
            $konten++;

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $konten, getNilaiGr(12, $detail->kelompokDetNim, $detail->staseId)[1])->mergeCells("A" . $konten . ":" . "C" . $konten);
            $spreadsheet->setActiveSheetIndex(0)->getStyle("A" . $konten . ":" . "C" . $konten)->getAlignment()->setHorizontal('center');
            // $konten++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Nilai Akhir ' . $mhsNama . ' ( ' . $mhsNpm . ')' . ' - ' . $stase . ' - ' . $tahunAkademik;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function cetakPdf()
    {
        $nim = $this->request->getPost('nim');
        $staseId = $this->request->getPost('staseId');
        $kelompokId = $this->request->getPost('kelompokId');
        $rumahSakitId = $this->request->getPost('rumahSakitId');

        $dataMhs = $this->penilaianModel->getFilterNilai(['kelompok.kelompokId' => $this->request->getPost('kelompokId'), 'stase.staseId' => $this->request->getPost('staseId'), 'kelompok_detail.kelompokDetNim' => $nim])->getResult();
        $stase = $this->staseModel->getWhere(['staseId' => $this->request->getPost('staseId')])->getResult();
        $rumahSakit = $this->dataRumahSakitModel->getWhere(['rumahSakitId' => $this->request->getPost('rumahSakitId')])->getResult();
        $cetakNilaiAkhir = array(
            'dataMhs' => $dataMhs,
            'dataKomp' => json_decode(getStatus(['setting_bobot.settingBobotStaseId' => $staseId])[0]->settingBobotKomposisiNilai),
            'dataFilter' => [$staseId, $kelompokId, $rumahSakitId],
            'dataStase' => $stase,
            'dataRumkit' => $rumahSakit
        );
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML(view('pages/laporanNilaiAkhir', $cetakNilaiAkhir));
        return redirect()->to($mpdf->Output('laporan_Nilai_Akhir.pdf', 'I'));
    }
}
