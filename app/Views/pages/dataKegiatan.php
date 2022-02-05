<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Kegiatan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/dataKegiatan"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahDataKegiatan"><i class="fas fa-plus"></i> Tambah Data</button>
          <h4></h4>
          <div class="card-header-form col-md-4">
            <form action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Kegiatan" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
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
                  <th scope="col">Nama Kegiatan</th>
                  <th style="text-align:center" scope="col">Status</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($dataKegiatan)) : ?>
                  <?php
                  $no = 1 + ($numberPage * ($currentPage - 1));
                  foreach ($dataKegiatan as $row) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row->kegiatanNama; ?></td>
                      <td style="text-align:center"><span class="badge <?= $row->kegiatanStatus == 1 ? "badge-success" : "badge-danger"; ?>"><?= $row->kegiatanStatus == 1 ? "Tersedia" : "Tidak Tersedia"; ?></span></td>
                      <td style="text-align:center">
                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editDataKegiatan<?= $row->kegiatanId; ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusDataKegiatan<?= $row->kegiatanId; ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('kegiatan', 'pager') ?>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahDataKegiatan">
  <div class="modal-dialog" role="document">
    <form action="/dataKegiatan" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data <strong>Kegiatan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Kegiatan</label>
            <input name="kegiatanNama" type="text" class="form-control">
          </div>
          <div class="form-group">
            <div class="control-label">Status Kegiatan</div>
            <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
              <input type="checkbox" name="kegiatanStatus" class="custom-switch-input">
              <span class="custom-switch-indicator"></span>
            </label>
            <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Tersedia/Tidak Tersedia)</span>
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
<!-- end modal tambah -->

<!-- start modal edit  -->
<?php foreach ($dataKegiatan as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editDataKegiatan<?= $edit->kegiatanId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data <strong>Kegiatan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/dataKegiatan/<?= $edit->kegiatanId; ?>/edit" method="post">
          <?= csrf_field() ?>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Kegiatan</label>
              <input name="kegiatanNama" type="text" class="form-control" value="<?= $edit->kegiatanNama; ?>">
            </div>
            <div class="form-group">
              <div class="control-label">Status Kegiatan</div>
              <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                <input type="checkbox" name="kegiatanStatus" <?= ($edit->kegiatanStatus == 1) ? "checked" : ""; ?> value="<?= $edit->kegiatanStatus; ?>" class="custom-switch-input">
                <span class="custom-switch-indicator"></span>
              </label>
              <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Tersedia/Tidak Tersedia)</span>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($dataKegiatan as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusDataKegiatan<?= $delete->kegiatanId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data <strong>Kegiatan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data kegiatan <strong><?= $delete->kegiatanNama; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/dataKegiatan/<?= $delete->kegiatanId; ?>" method="post">
          <?= csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal hapus -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>