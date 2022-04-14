<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nilai Akhir</title>
    <style>
        table.mhs th {
            border: 1px solid black;
        }

        table.mhs td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <br>
    <h3 align="center"><strong>Nilai Akhir</strong></h3>
    <br>
    <table>
        <tr>
            <td width="140px"><strong>NPM</strong></td>
            <td>:</td>
            <td>&nbsp;<?= $dataMhs[0]->kelompokDetNim; ?></td>
        </tr>
        <tr>
            <td><strong>Nama Lengkap</strong></td>
            <td>:</td>
            <td>&nbsp;<?= $dataMhs[0]->kelompokDetNama; ?></td>
        </tr>
        <tr>
            <td><strong>Stase</strong></td>
            <td>:</td>
            <td>&nbsp;<?= $dataStase[0]->staseNama; ?></td>
        </tr>
    </table>
    <br>
    <table class="mhs" width="100%" style="text-align:center;border-collapse: collapse">
        <thead>
            <tr bgcolor="silver">
                <th align="center">No.</th>
                <th align="center">Jenis Kegiatan</th>
                <th align="center">Nilai Akhir (Bobot X Nilai)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $nilaiAkhir = 0;
            foreach ($dataMhs as $detail) {
                foreach ($dataKomp as $komp) : ?>
                    <?php $nilaiAkhir += getNilai(json_decode($komp->penilaian), $detail->kelompokDetNim, $detail->staseId); ?>
                    <tr>
                        <td align="center"><?= $no++; ?>.</td>
                        <td><?= getPenilaian($komp->penilaian)[0]->penilaianNamaSingkat ?></td>
                        <td><?= number_format(getNilai(json_decode($komp->penilaian), $detail->kelompokDetNim, $detail->staseId), 2) ?></td>
                    </tr>
                <?php endforeach ?>

        </tbody>
        <thead>
            <tr>
                <th colspan="2" style="text-align:center">Total Nilai</th>
                <th><?= number_format($nilaiAkhir, 2) ?> / <?= getKonversi($nilaiAkhir) ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center"><?= $no++; ?></td>
                <td><?= "Attitude/" . getPenilaian("[\"12\"]")[0]->penilaianNamaSingkat ?></td>
                <td>
                    <strong>
                        <?php if (getNilaiGr(12, $detail->kelompokDetNim, $detail->staseId)[0] < 1) : ?>
                            <del>Sufficient</del>/Unsufficient
                        <?php else : ?>
                            Sufficient/<del>Unsufficient</del>
                        <?php endif ?>
                    </strong>
                </td>
            </tr>
        </tbody>
        <thead>
            <tr>
                <th colspan="3" style="text-align:center">Sanksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" style="text-align:center"><?= getNilaiGr(12, $detail->kelompokDetNim, $detail->staseId)[1] ?></td>
            </tr>
        </tbody>
    <?php } ?>
    </table>
    <br>
    <br>
    <br>
    <table width="100%">
        <tr>
            <td align="center"><strong>Mengetahui,</strong></td>
            <td></td>
            <td align="center"><strong>Menyetujui,</strong></td>
        </tr>
        <tr>
            <td align="center"><strong>Ka. SMF RS</strong><br><br><br><br><br><br>
                (...................................................)
            </td>
            <td></td>
            <td align="center"><strong>Komkordik</strong><br><br><br><br><br><br>
                (...................................................)</td>
        </tr>
    </table>
</body>

</html>