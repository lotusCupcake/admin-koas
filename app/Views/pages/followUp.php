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
          <div class="card-header-form">
            <form action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-body">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <?php echo session()->getFlashdata('success'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Mahasiswa</th>
                  <th width="20%" scope="col">Rumah Sakit</th>
                  <th width="20%" scope="col">Kasus Yang Ditangani</th>
                  <th width="20%" scope="col">Dosen Pembimbing</th>
                  <th width="15%" style="text-align:center" scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($followUp)) : ?>
                  <?php
                  $no = 1 + (5 * ($currentPage - 1));
                  foreach ($followUp as $row) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= gmdate("Y-m-d", substr($row->followUpTglPeriksa, 0, -3)); ?></td>
                      <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                      <td><?= $row->rumahSakitShortname; ?> / <?= $row->staseNama; ?></td>
                      <td style="cursor: pointer;" data-toggle="modal" data-target="#deskripsiFollowUp<?= $row->followUpId; ?>"><span class="text-primary">Klik Untuk Lihat</span></td>
                      <td><?= $row->dopingNamaLengkap; ?></td>
                      <td style="text-align:center">
                        <?php if ($row->followUpVerify == 0) : ?>
                          <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#setujuiLogbook<?= $row->followUpId; ?>">Belum Disetujui</button>
                        <?php else : ?>
                          <button class="btn btn-icon icon-left btn-success">Disetujui</button>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <tr>
                    <td colspan="7" align="center">Pencarian "<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>" Tidak Ditemukan</td>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('anj', 'pager') ?>
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