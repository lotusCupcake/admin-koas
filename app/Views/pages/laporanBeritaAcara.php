<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara</title>
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
    <br>
    <h3 align="center"> BERITA ACARA</h3>
    <h3 align="center">KEGIATAN KEPANITERAAN KLINIK</h3>
    <p></p>
    <table>
        <tr>
            <td width="150px"><b>
                    <font color="black">Minggu KKS</font>
                </b></td>
            <td>:</td>
            <td>&nbsp; Minggu Ke - <?= week($dataInit[0]->kelompokDetNim, $dataInit[0]->staseId, ($dataInit[0]->logbookTanggal / 1000)); ?></td>
        </tr>
        <tr>
            <td><strong>
                    <font color="black">Jenis Kegiatan</font>
                </strong></td>
            </td>
            <td>:</td>
            <td>&nbsp; <?= $dataInit[0]->kegiatanNama; ?></td>
        </tr>
    </table>
    <br><br>
    <table>
        <tr>
            <td width="150px">Topik/Judul</td>
            <td>:</td>
            <td>&nbsp; <?= $dataInit[0]->logbookJudulDeskripsi; ?></td>
        </tr>
        <tr>
            <td>Hari/Tanggal</td>
            <td>:</td>
            <td>&nbsp; <?= gmdate('D / d-m-Y', $dataInit[0]->logbookTanggal / 1000); ?></td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>&nbsp; <?= gmdate('H:i:s', $dataInit[0]->logbookTanggal / 1000); ?> WIB</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td>&nbsp; <?= $dataInit[0]->rumahSakitShortname; ?></td>
        </tr>
        <tr>
            <td>Department</td>
            <td>:</td>
            <td>&nbsp; <?= $dataInit[0]->staseNama; ?></td>
        </tr>
    </table>
    <br>
    <table class="mhs" border="1" width="100%" style="text-align:center;border-collapse: collapse">
        <tr>
            <th align="center">&nbsp;NO&nbsp;</th>
            <th align="center">NPM</th>
            <th align="center">NAMA MAHASISWA</th>
            <th align="center">TANDA TANGAN</th>
            <th align="center">&nbsp;KETERANGAN&nbsp;</th>
        </tr>
        <?php $no = 1;
        foreach ($dataMahasiswa as $mhs) :
        ?>
            <tr>
                <td>&nbsp; <?= $no++;  ?> &nbsp;</td>
                <td>&nbsp; <?= $mhs->kelompokDetNim; ?> &nbsp;</td>
                <td>&nbsp; <?= $mhs->kelompokDetNama; ?> &nbsp;</td>
                <td></td>
                <td></td>
            </tr>
        <?php endforeach
        ?>
    </table>
    <br><br>
    <table align="right">
        <tr>
            <td><strong>Pembimbing (Preceptor)</strong></td>
        </tr>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <tr>
            <td><img src="<?= base_url() ?>/signature-image/622c56a329b83.png" width="150px" height="120px" /></td>
            <td>(...........................................)</td>
        </tr>
    </table>
    <br><br>
    <table align="center">
        <tr>
            <td>Mengetahui,</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <!-- <td align="center">&nbsp;&nbsp;</td> -->
            <td align="center"><strong>Ka. SMF RS / Komkoordik</strong></td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center"><strong>Wakil Dekan I/Ka. Prodi Profesi</strong></td>
        </tr>
    </table>

    <br>
    <br>
    <br>
    <br>
    <br>
    <table>
        <tr>
            <!-- <td align="center">&nbsp;&nbsp;</td> -->
            <td>(...........................................)</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>(...........................................)</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table>
        <tr>
            <td>Pertinggal:</td>
        </tr>
        <ul>
            <tr>
                <td>
                    <li>FK UMSU</li>
                </td>
            </tr>
            <tr>
                <td>
                    <li>SMF RS Pendidikan</li>
                </td>
            </tr>
            <tr>
                <td>
                    <li>Diklat/Komkoordik RS Pendidikan</li>
                </td>
            </tr>
        </ul>
        <br>
        <tr>
            <td>Keterangan:</td>
        </tr>
        <tr>
            <td>Tanda tangan dapat menggunakan foto tanda-tangan/tertanda</td>
        </tr>
    </table>
</body>

</html>