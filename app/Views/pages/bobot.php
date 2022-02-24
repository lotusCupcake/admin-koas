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
        <div class="breadcrumb-item"><a href="/bobot"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
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
          <?php if (!empty(session()->getFlashdata('danger'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', session()->getFlashdata('danger')]]); ?>
          <?php endif; ?>
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="10%" style="text-align:center" scope="col">No.</th>
                  <th scope="col">Stase</th>
                  <th width="35%" style="text-align:center" scope="col">Action</th>
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
                          <button class="btn btn-icon icon-left btn-light" data-toggle="modal" data-target="#settingPenilaian<?= $row->settingBobotId; ?>"><i class="fas fa-marker"></i> Edit Penilaian</button>
                          <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#settingBobot<?= $row->staseId; ?>"><i class="fas fa-plus"></i> Tambahkan Bobot</button>
                        <?php else : ?>
                          <button class="btn btn-icon icon-left btn-success" data-toggle="modal" data-target="#settingBobot<?= $row->staseId; ?>"><i class=" fas fa-check"></i> Tersedia</button>
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
            <h5 class="modal-title">Tambah <strong>Penilaian Stase <?= $tambah->staseNama ?></strong></h5>
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

<!-- start modal tambah bobot  -->
<?php $no = 1;
foreach ($bobot as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="settingBobot<?= $edit->staseId; ?>">
    <?php $komposisi = (count(getStatus(['settingBobotStaseId' => $edit->staseId])) > 0) ? $status = getStatus(['settingBobotStaseId' => $edit->staseId])[0]->settingBobotKomposisiNilai : $status =  '[]' ?>
    <div class="modal-dialog modal-xl" role="document">
      <form action="/bobot/<?= $edit->staseId; ?>/save" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah <strong>Bobot Penilaian Stase <?= $edit->staseNama ?></strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="width:20%" scope="col">Penilaian</th>
                    <th scope="col" colspan="20" style="text-align:center">Bobot (%)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($komposisi)) : ?>
                    <?php foreach (json_decode($komposisi) as $nilai) : ?>
                      <tr>
                        <td><?= getPenilaian(['penilaianId' => $nilai->penilaian])[0]->penilaianNamaSingkat ?></td>
                        <?php for ($i = 5; $i <= 50; $i = $i + 5) : ?>
                          <td>
                            <div class="selectgroup selectgroup-pills">
                              <label class="selectgroup-item">
                                <input type="radio" name="<?= $nilai->penilaian ?>" value="<?= $i ?>" class="selectgroup-input form-control" required <?= ($nilai->bobot == $i) ? 'checked' : '' ?>>
                                <span class="selectgroup-button selectgroup-button-icon"><?= $i ?></span>
                              </label>
                            </div>
                          </td>
                        <?php endfor ?>
                      </tr>
                    <?php endforeach ?>
                  <?php else : ?>
                    <?= view('layout/templateEmpty', ['jumlahSpan' => 2]); ?>
                  <?php endif ?>
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
<!-- end modal tambah bobot -->

<!-- start modal tambah ulang/setting penilaian  -->
<?php foreach ($bobot as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="settingPenilaian<?= $edit->settingBobotId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit <strong>Penilaian Stase <?= $edit->staseNama; ?></strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin mengedit ulang penilaian stase <strong><?= $edit->staseNama; ?></strong>?</p>
        </div>
        <form action="/penilaian/<?= $edit->settingBobotId; ?>" method="post">
          <?= csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal tambah ulang/setting penilaian -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>