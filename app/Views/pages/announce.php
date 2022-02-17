<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Announcement</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/announce"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <div class="card-header-action">
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahPengumuman"><i class="fas fa-plus"></i> Tambah Data</button>
          </div>
        </div>
        <div class="card-body">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('pengumumanJudul')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('pengumumanJudul')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('pengumumanIsi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('pengumumanIsi')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th width="15%" scope="col">Judul</th>
                  <th scope="col">Isi</th>
                  <th width="15%" scope="col">Tanggal Mulai</th>
                  <th width="15%" scope="col">Tanggal Akhir</th>
                  <th width="15%" style="text-align:center" scope="col">Status Aktif</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($announcement)) : ?>
                  <?php
                  $no = 1;
                  foreach ($announcement as $row) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row->pengumumanJudul; ?></td>
                      <td><?= $row->pengumumanIsi; ?></td>
                      <td><?= gmdate('d-m-Y', ($row->pengumumanTanggalMulai / 1000)); ?></td>
                      <td><?= gmdate('d-m-Y', ($row->pengumumanTanggalAkhir / 1000)); ?></td>
                      <td style="text-align:center"><span class="badge <?= $row->pengumumanIsForceToShow == 1 ? "badge-success" : "badge-danger"; ?>"><?= $row->pengumumanIsForceToShow == 1 ? "Forced" : "Unforced"; ?></td>
                      <td style="text-align:center">
                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editPengumuman<?= $row->pengumumanId; ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusPengumuman<?= $row->pengumumanId; ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
                <?php endif ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- start modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahPengumuman">
  <div class="modal-dialog" role="document">
    <form action="/announce" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data <strong>Announcement</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Judul</label>
            <div class="input-group">
              <input class="form-control" value="" name="pengumumanJudul">
            </div>
          </div>
          <div class="form-group">
            <label>Isi</label>
            <textarea class="form-control" style="height: 72px;" name="pengumumanIsi"></textarea>
          </div>
          <div class="form-group">
            <label>Tanggal Mulai</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-calendar"></i>
                </div>
              </div>
              <input type="text" class="form-control datepicker" name="pengumumanTanggalMulai">
            </div>
          </div>
          <div class="form-group">
            <label>Tanggal Akhir</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-calendar"></i>
                </div>
              </div>
              <input type="text" class="form-control datepicker" name="pengumumanTanggalAkhir">
            </div>
          </div>
          <div class="form-group">
            <div class="control-label">Status Aktif</div>
            <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
              <input type="checkbox" name="pengumumanIsForceToShow" class="custom-switch-input">
              <span class="custom-switch-indicator"></span>
            </label>
            <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Forced/Unforced)</span>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- end modal tambah -->

<!-- start modal Edit -->
<?php foreach ($announcement as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editPengumuman<?= $edit->pengumumanId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/announce/<?= $edit->pengumumanId; ?>/edit" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data <strong>Announcement</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Judul</label>
              <div class="input-group">
                <input class="form-control" value="<?= $edit->pengumumanJudul; ?>" name="pengumumanJudul">
              </div>
            </div>
            <div class="form-group">
              <label>Isi</label>
              <textarea class="form-control" style="height: 72px;" name="pengumumanIsi"><?= $edit->pengumumanIsi; ?></textarea>
            </div>
            <div class="form-group">
              <label>Tanggal Mulai</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                  </div>
                </div>
                <input type="text" class="form-control datepicker" name="pengumumanTanggalMulai" value="<?= gmdate('Y-m-d', ($edit->pengumumanTanggalMulai / 1000)); ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Tanggal Akhir</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                  </div>
                </div>
                <input type="text" class="form-control datepicker" name="pengumumanTanggalAkhir" value="<?= gmdate('Y-m-d', ($edit->pengumumanTanggalAkhir / 1000)); ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="control-label">Status Aktif</div>
              <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                <input type="checkbox" <?= ($edit->pengumumanIsForceToShow == 1) ? "checked" : ""; ?> value="<?= $edit->pengumumanIsForceToShow; ?>" name="pengumumanIsForceToShow" class="custom-switch-input">
                <span class="custom-switch-indicator"></span>
              </label>
              <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Forced/Unforced)</span>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php endforeach; ?>
<!-- end modal Edit -->

<!-- start modal hapus -->
<?php foreach ($announcement as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusPengumuman<?= $delete->pengumumanId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data <strong>Announcement</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu ingin menghapus announcement <strong><?= $delete->pengumumanJudul; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/announce/<?= $delete->pengumumanId; ?>" method="post">
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
<?php endforeach; ?>
<!-- end modal hapus -->
<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>