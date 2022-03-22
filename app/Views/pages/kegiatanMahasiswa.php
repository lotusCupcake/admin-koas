<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Kegiatan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/kegiatanMahasiswa"><?= $breadcrumb[0]; ?></a></div>
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
                <input type="text" class="form-control" placeholder="Search Tahun Akademik/Nama/NPM/Rumah Sakit/Stase/Kegiatan/Dosen" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
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
                  <th width="15%" scope="col">Tahun Akademik</th>
                  <th width="15%" scope="col">Minggu ke / Tanggal</th>
                  <th width="15%" scope="col">Mahasiswa</th>
                  <th width="20%" scope="col">Rumah Sakit</th>
                  <th scope="col">Kegiatan</th>
                  <th scope="col">Topik</th>
                  <th width="15%" scope="col">Dosen Pembimbing</th>
                  <th width="20%" style="text-align:center" scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($kegiatan)) : ?>
                  <?php
                  $no = 1 + ($numberPage * ($currentPage - 1));
                  foreach ($kegiatan as $row) :
                    $mingguke = week($row->kelompokDetNim, $row->staseId, ($row->logbookTanggal / 1000));
                  ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td scope="row"><?= $row->logbookTahunAkademik; ?></td>
                      <td><sup><strong><?= $mingguke; ?></sup></strong> / <sub><?= date("d-m-Y", ($row->logbookTanggal / 1000)); ?></sub></td>
                      <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                      <td><?= $row->rumahSakitShortname; ?> / <?= $row->staseNama; ?></td>
                      <td><?= $row->kegiatanNama; ?></td>
                      <td><a href="#!"><span data-toggle="modal" data-target="#deskripsiKegiatan<?= $row->logbookId; ?>" class="text-primary"><?= $row->logbookJudulDeskripsi; ?></span></a></td>
                      <td><?= $row->dopingNamaLengkap; ?></td>
                      <td style="text-align:center">
                        <?php if ($row->logbookIsVerify == 0) : ?>
                          <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#setujuiKegiatan<?= $row->logbookId; ?>" <?= ($row->dopingEmail == user()->email) ? "" : "disabled" ?>>Belum Disetujui</button>
                        <?php else : ?>
                          <button class="btn btn-icon icon-left btn-success" <?= ($row->dopingEmail == user()->email) ? "" : "disabled" ?>>Disetujui</button>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 9]); ?>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('kegiatan', 'pager') ?>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal deskripsi -->
<?php foreach ($kegiatan as $deskripsi) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="deskripsiKegiatan<?= $deskripsi->logbookId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Topik <strong>Kegiatan</strong></h5>
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
<?php foreach ($kegiatan as $setujui) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="setujuiKegiatan<?= $setujui->logbookId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/kegiatanMahasiswa/<?= $setujui->logbookId; ?>/setujui" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" value="<?= ($setujui->oneSignalPlayerId) == null ? null : $setujui->oneSignalPlayerId; ?>" name="playerId">
        <input type="hidden" value="<?= $setujui->kegiatanNama; ?>" name="kegiatan">
        <input type="hidden" value="<?= $setujui->dopingNamaLengkap; ?>" name="dopingKegiatan">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Kegiatan<strong> Mahasiswa</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Apakah kamu yakin untuk menyetujui kegiatan <strong><?= $setujui->kelompokDetNama; ?> (<?= $setujui->kelompokDetNim; ?>)</strong>?</p>
            <p class="text-warning"><small>Jika kegiatan sudah disetujui, maka tidak akan bisa diubah lagi!</small></p>
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