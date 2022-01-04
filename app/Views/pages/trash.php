 <td><?= $row->staseNama; ?></td>
 <td style="text-align:center">
     <span class="badge <?= $row->rumkitDetStatus == 1 ? "badge-success" : "badge-danger"; ?>"><?= $row->rumkitDetStatus == 1 ? "Tersedia" : "Tidak Tersedia"; ?></span>
 </td>
 </td>
 <td style="text-align:center">
     <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editStaseRumahSakit<?= $row->rumkitDetId; ?>"><i class="fas fa-edit"></i></button>
     <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusStaseRumahSakit<?= $row->rumkitDetId; ?>"><i class="fas fa-trash"></i></button>
 </td>

 <?php foreach ($namars as $row) : ?>
     <tr>
         <td style="text-align:center" scope="row" rowspan="<?= array_count_values($dataNamaRs)[$row] ?>"><?= $no++; ?></td>
         <td rowspan="<?= array_count_values($dataNamaRs)[$row] ?>"><?= $row ?></td>


         <!-- <td rowspan="<?= array_count_values($dataNamaRs)[$row] ?>"><?= $row; ?></td> -->

     </tr>
 <?php endforeach ?>