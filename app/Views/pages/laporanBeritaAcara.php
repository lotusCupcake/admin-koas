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

        /*
        .satu {
	   font-size: 12px;
	   }
	   .dua {
	   font-size: 20px;
	   }
	   .tiga {
	   font-size: 8px;
	   }*/
    </style>
</head>

<body>
    <br>
    <br>
    <br>
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
            <td>&nbsp; Minggu Ke - ....</td>
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
            <td>&nbsp; <?= date('D / d-m-Y', $dataInit[0]->logbookTanggal / 1000); ?></td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>&nbsp; <?= date('H:i:s', $dataInit[0]->logbookTanggal / 1000); ?> WIB</td>
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
    <table width="100%">
        <tr>
            <td width="40%"></td>
            <td width="20%"></td>
            <td width="40%" align="center">
                <strong>Pembimbing (Preceptor)</strong>
                <br><img class="my-image-signature" src="https://koas.umsu.ac.id/signature-image/<?= $dataInit[0]->dopingSignature; ?>" width="200px" /><br>
                ( <?= $dataInit[0]->dopingNamaLengkap ?>)
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center"><br><br>Mengetahui,<br><br><br></td>
            <td></td>
        </tr>
        <tr>
            <td align="center"><strong>Ka. SMF RS / Komkoordik</strong><br><br><br><br><br><br>
                (...........................................)
            </td>
            <td></td>
            <td align="center"><strong>Wakil Dekan I/Ka. Prodi Profesi</strong><br><br><br><br><br><br>
                (...........................................)</td>
        </tr>
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td colspan="2" style="font-size: 12px;">Pertinggal :</td>
        </tr>
        <tr>
            <td>-</td>
            <td style="font-size: 11px;">&nbsp;&nbsp;&nbsp;FK UMSU</td>
        </tr>
        <tr>
            <td>-</td>
            <td style="font-size: 11px;">&nbsp;&nbsp;&nbsp;SMF RS Pendidikan</td>
        </tr>
        <tr>
            <td>-</td>
            <td style="font-size: 11px;">&nbsp;&nbsp;&nbsp;Diklat/Komkordik RS Pendidikan</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="font-size: 12px;">Keterangan :</td>
        </tr>
        <tr>
            <td style="font-size: 11px;">Tanda tangan dapat menggunakan foto tanda-tangan/tertanda</td>
        </tr>

    </table>


</body>

</html>