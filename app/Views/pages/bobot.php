<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title; ?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4></h4>
          <div class="card-header-form col-md-4">
            <form action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Stase" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
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
          <?php if ($validation->hasError('kegiatanNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('kegiatanNama')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="10%" style="text-align:center" scope="col">No.</th>
                  <th scope="col">Stase</th>
                  <th width="25%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($bobot)) : ?>
                  <?php
                  $no = 1 + ($numberPage * ($currentPage - 1));
                  foreach ($bobot as $row) :  ?>
                    <?php (count(getStatus(['settingBobotStaseId' => $row->staseId])) > 0) ? $status = getStatus(['settingBobotStaseId' => $row->staseId])[0]->settingBobotStatus : $status = 99 ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row->staseNama; ?></td>
                      <td style="text-align:center">
                        <?php if ($status == 99) : ?>
                          <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#tambahPenilaian<?= $row->staseId; ?>"><i class="fas fa-plus"></i> Tambahkan Penilaian</button>
                        <?php elseif ($status == 0) : ?>
                          <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#settingBobot<?= $row->staseId; ?>"><i class="fas fa-marker"></i> Setting Bobot</button>
                        <?php else : ?>
                          <button class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Setting Tersedia</button>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 3]); ?>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('bobot', 'pager') ?>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal tambah penilaian stase  -->
<?php foreach ($bobot as $tambah) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="tambahPenilaian<?= $tambah->staseId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/penilaian/<?= $tambah->staseId; ?>/save" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah <strong>Penilaian di Stase <?= $tambah->staseNama ?></strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="text-align:center" scope="col"></th>
                    <th scope="col">Penilaian</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($penilaian as $nilai) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><input type="checkbox" value="<?= $nilai->penilaianId; ?>" name="penilaian[]"></td>
                      <td><?= $nilai->penilaianNama; ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal tambah penilaian stase -->

<!-- start modal edit penilaian stase  -->
<?php $no = 1;
foreach ($bobot as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="settingBobot<?= $edit->staseId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/bobot/<?= $edit->staseId; ?>/save" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit <strong>Penilaian di Stase <?= $edit->staseNama ?></strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Penilaian</th>
                    <th scope="col">Bobot (%)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td></td>
                    <td>
                      <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                          <input type="radio" name="" value="" class="selectgroup-input form-control" required>
                          <span class="selectgroup-button selectgroup-button-icon">100</span>
                        </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal edit penilaian stase -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>