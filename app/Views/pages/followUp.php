<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Follow Up</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/followUp"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4></h4>
          <div class="card-header-form col-md-5">
            <form action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Tahun Akademik/Nama/NPM/Rumah Sakit/Stase/Dosen" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                <div class="input-group-btn">
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
                  <th width="10%" scope="col">Rumah Sakit</th>
                  <th width="10%" scope="col">Kasus</th>
                  <th width="20%" scope="col">Dosen Pembimbing</th>
                  <th width="25%" style="text-align:center" scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($followUp)) : ?>
                  <?php
                  $no = 1 + ($numberPage * ($currentPage - 1));
                  foreach ($followUp as $row) : $mingguke = week($row->kelompokDetNim, $row->staseId, ($row->followUpTglPeriksa / 1000)) ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row->followUpTahunAkademik; ?></td>
                      <td><sup><strong><?= $mingguke; ?></strong></sup> / <sub><?= date("d-m-Y", ($row->followUpTglPeriksa / 1000)); ?></sub></td>
                      <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                      <td><?= $row->rumahSakitShortname; ?> / <?= $row->staseNama; ?></td>
                      <td><a href="#!"><span data-toggle="modal" data-target="#deskripsiFollowUp<?= $row->followUpId; ?>" class="text-primary">Klik Untuk Lihat</span></a></td>
                      <td><?= $row->dopingNamaLengkap; ?></td>
                      <td style="text-align:center">
                        <?php if ($row->followUpVerify == 0) : ?>
                          <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#setujuiLogbook<?= $row->followUpId; ?>" <?= ($row->dopingEmail == user()->email) ? "" : "disabled" ?>>Belum Disetujui</button>
                        <?php else : ?>
                          <button class="btn btn-icon icon-left btn-success" <?= ($row->dopingEmail == user()->email) ? "" : "disabled" ?>>Disetujui</button>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('followUp', 'pager') ?>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal deskripsi -->
<?php foreach ($followUp as $deskripsi) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="deskripsiFollowUp<?= $deskripsi->followUpId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Kasus <strong>Yang Ditangani</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= $deskripsi->followUpKasusSOAP; ?>
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
<?php foreach ($followUp as $setujui) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="setujuiLogbook<?= $setujui->followUpId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/followUp/<?= $setujui->followUpId; ?>/setujui" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" value="<?= ($setujui->oneSignalPlayerId) == null ? null : $setujui->oneSignalPlayerId; ?>" name="playerId">
        <input type="hidden" value="<?= $setujui->dopingNamaLengkap; ?>" name="followUpDoping">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Kasus<strong> Yang Ditangani</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Apakah kamu yakin untuk menyetujui follow up <strong><?= $setujui->kelompokDetNama; ?> (<?= $setujui->kelompokDetNim; ?>)</strong>?</p>
            <p class="text-warning"><small>Jika follow up sudah disetujui, maka tidak akan bisa diubah lagi!</small></p>
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