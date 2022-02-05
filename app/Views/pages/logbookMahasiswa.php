<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Logbook</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/logbookMahasiswa"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4></h4>
          <div class="card-header-form col-md-6">
            <form action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Nama/NPM/Rumah Sakit/Stase/Kegiatan/Dosen" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                <div class=" input-group-btn">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-body">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Minggu ke / Tanggal</th>
                  <th scope="col">Mahasiswa</th>
                  <th width="20%" scope="col">Rumah Sakit</th>
                  <th scope="col">Kegiatan</th>
                  <th scope="col">Topik</th>
                  <th width="20%" scope="col">Dosen Pembimbing</th>
                  <?php if (in_groups(['Dosen', 'Koordik'])) : ?>
                    <th width="20%" style="text-align:center" scope="col">Status</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($logbook)) : ?>
                  <?php
                  $no = 1 + ($numberPage * ($currentPage - 1));
                  foreach ($logbook as $row) :
                    $mingguke = week($row->kelompokDetNim, $row->staseId, ($row->logbookTanggal / 1000));
                  ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><sup><strong><?= $mingguke; ?></sup></strong> / <sub><?= gmdate("d-m-Y", ($row->logbookTanggal / 1000)); ?></sub></td>
                      <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                      <td><?= $row->rumahSakitShortname; ?> / <?= $row->staseNama; ?></td>
                      <td><?= $row->kegiatanNama; ?></td>
                      <td style="cursor: pointer;" data-toggle="modal" data-target="#deskripsiLogbook<?= $row->logbookId; ?>"><span class="text-primary"><?= $row->logbookJudulDeskripsi; ?></span></td>
                      <td><?= $row->dopingNamaLengkap; ?></td>
                      <?php if (in_groups(['Dosen', 'Koordik'])) : ?>
                        <td style="text-align:center">
                          <?php if ($row->logbookIsVerify == 0) : ?>
                            <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#setujuiLogbook<?= $row->logbookId; ?>" <?= ($row->dopingEmail == user()->email) ? "" : "disabled" ?>>Belum Disetujui</button>
                          <?php else : ?>
                            <button class="btn btn-icon icon-left btn-success" <?= ($row->dopingEmail == user()->email) ? "" : "disabled" ?>>Disetujui</button>
                          <?php endif ?>
                        </td>
                      <?php endif; ?>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('logbook', 'pager') ?>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal deskripsi -->
<?php foreach ($logbook as $deskripsi) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="deskripsiLogbook<?= $deskripsi->logbookId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Topik <strong>Logbook</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= $deskripsi->logbookDeskripsi; ?>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal deskripsi -->

<!-- start modal setujui -->
<?php foreach ($logbook as $setujui) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="setujuiLogbook<?= $setujui->logbookId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/logbookMahasiswa/<?= $setujui->logbookId; ?>/setujui" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Logbook<strong> Mahasiswa</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Apakah kamu yakin untuk menyetujui logbook <strong><?= $setujui->kelompokDetNama; ?> (<?= $setujui->kelompokDetNim; ?>)</strong>?</p>
            <p class="text-warning"><small>Jika logbook sudah disetujui, maka tidak akan bisa diubah lagi!</small></p>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Verified</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal setujui -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>