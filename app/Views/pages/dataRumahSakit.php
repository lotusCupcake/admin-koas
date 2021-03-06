<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Rumah Sakit</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/dataRumahSakit"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahRumkit"><i class="fas fa-plus"></i> Tambah Data</button>
        </div>
        <div class="card-body">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitNama')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitLat')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitLat')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitLong')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitLong')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitTelp')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitTelp')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitShortname')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitShortname')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitEmail')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitEmail')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama Rumah Sakit</th>
                  <th scope="col">Alamat</th>
                  <th width="15%" scope="col">No. Telp</th>
                  <th scope="col">Email</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($dataRumahSakit as $row) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= $row->rumahSakitNama; ?></td>
                    <td><?= $row->rumahSakitAlamat; ?></td>
                    <td><?= $row->rumahSakitTelp; ?></td>
                    <td><?= $row->rumahSakitEmail; ?></td>
                    <td style="text-align:center">
                      <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editRumkit<?= $row->rumahSakitId; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusRumkit<?= $row->rumahSakitId; ?>"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahRumkit">
  <div class="modal-dialog" role="document">
    <form action="/dataRumahSakit" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data <strong>Rumah Sakit</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Rumah Sakit</label>
            <input name="rumahSakitNama" type=" text" class="form-control">
          </div>
          <div class="form-group">
            <label>Nama Singkat Rumah Sakit</label>
            <input name="rumahSakitShortname" type="text" class="form-control" placeholder="Cth: RSUD Deli Serdang/RS Haji ">
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Koordinat Latitude</label>
              <input name="rumahSakitLat" type="text" class="form-control" placeholder="3.586991674711143">
            </div>
            <div class="form-group col-md-6">
              <label>Koordinat Longitude</label>
              <input name="rumahSakitLong" type="text" class="form-control" placeholder="98.6724470774826">
            </div>
          </div>
          <div class="form-group">
            <label>No. Telp</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-phone"></i>
                </div>
              </div>
              <input name="rumahSakitTelp" type="text" class="form-control phone-number">
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-envelope"></i>
                </div>
              </div>
              <input name="rumahSakitEmail" type="text" class="form-control">
            </div>
          </div>
          <input type="hidden" name="rumahSakitWarna" value="<?php printf("%06X\n", mt_rand(0, 0xFFFFFF)); ?>">
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
<?php foreach ($dataRumahSakit as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editRumkit<?= $edit->rumahSakitId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/dataRumahSakit/<?= $edit->rumahSakitId; ?>/edit" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data <strong>Rumah Sakit</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Rumah Sakit</label>
              <input name="rumahSakitNama" type="text" class="form-control" value="<?= $edit->rumahSakitNama; ?>">
            </div>
            <div class="form-group">
              <label>Nama Singkat Rumah Sakit</label>
              <input name="rumahSakitShortname" type="text" class="form-control" value="<?= $edit->rumahSakitShortname; ?>">
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Koordinat Latitude</label>
                <input name="rumahSakitLat" type="text" class="form-control" value="<?= explode(",", $edit->rumahSakitLatLong)[0]; ?>" placeholder=" 3.586991674711143">
              </div>
              <div class="form-group col-md-6">
                <label>Koordinat Longitude</label>
                <input name="rumahSakitLong" type="text" class="form-control" value="<?= explode(",", $edit->rumahSakitLatLong)[1]; ?>" placeholder=" 98.6724470774826">
              </div>
            </div>
            <div class="form-group">
              <label>No. Telp</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-phone"></i>
                  </div>
                </div>
                <input name="rumahSakitTelp" type="text" class="form-control phone-number" value="<?= $edit->rumahSakitTelp; ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Email</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-envelope"></i>
                  </div>
                </div>
                <input name="rumahSakitEmail" type="text" class="form-control" value="<?= $edit->rumahSakitEmail; ?>">
              </div>
            </div>
            <input type="hidden" name="rumahSakitWarna" value="<?= $edit->rumahSakitWarna; ?>">
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
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($dataRumahSakit as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusRumkit<?= $delete->rumahSakitId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data <strong>Rumah Sakit</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data <strong><?= $delete->rumahSakitNama; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/dataRumahSakit/<?= $delete->rumahSakitId; ?>" method="post">
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