<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara</title>
</head>

<body>
    <h3 align="center">Berita Acara</h3>
    <h3 align="center">KEGIATAN KEPANITERAAN KLINIK</h3>

    <table>
        <tr>
            <td width="150px">Minggu KKS</td>
            <td>:</td>
            <td>.........................................</td>
        </tr>
        <tr>
            <td>Jenis Kegiatan</td>
            </td>
            <td>:</td>
            <td>.........................................</td>
        </tr>
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td width="150px">Topik/Judul</td>
            <td>:</td>
            <td>...........................................</td>
        </tr>
        <tr>
            <td>Hari/Tanggal</td>
            <td>:</td>
            <td>......................./....................</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>.......................s/d....................WIB</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td>..............................................</td>
        </tr>
        <tr>
            <td>Department</td>
            <td>:</td>
            <td>..............................................</td>
        </tr>
    </table>
    <br>
    <table border="1px" style="border-collapse: collapse;">
        <tr>
            <th>NO</th>
            <th>NPM</th>
            <th>NAMA</th>
            <th>TANDA TANGAN</th>
            <th>KETERANGAN</th>
        </tr>
        <?php //$no = 1;
        //foreach ($dataMahasiswa as $mhs) : 
        ?>
        <tr>
            <td><? //= $no++; 
                ?></td>
            <td><? //= $mhs->kelompokDetNim; 
                ?></td>
            <td><? //= $mhs->kelompokDetNama; 
                ?></td>
            <td></td>
            <td></td>
        </tr>
        <?php //endforeach  
        ?>
    </table>
</body>

</html>