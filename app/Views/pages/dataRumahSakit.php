<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Rumah Sakit</h1>
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
            <div class="alert alert-success alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <?php echo session()->getFlashdata('success'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitNama')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('rumahSakitNama'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitLatLong')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('rumahSakitLatLong'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitLatLong')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('rumahSakitLatLong'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitTelp')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('rumahSakitTelp'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama Rumah Sakit</th>
                  <th scope="col">Alamat</th>
                  <th width="15%" scope="col">No. Telp</th>
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
          <h5 class="modal-title">Tambah<strong> Data Rumah Sakit</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Rumah Sakit</label>
            <input name="rumahSakitNama" type=" text" class="form-control">
          </div>
          <!-- <div class="form-group">
            <label>Koordinat Rumah Sakit di Google Maps</label>
            <input name="rumahSakitLatLong" type=" text" class="form-control">
          </div> -->
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
            <h5 class="modal-title">Edit<strong> Data Rumah Sakit</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Rumah Sakit</label>
              <input name="rumahSakitNama" type="text" class="form-control" value="<?= $edit->rumahSakitNama; ?>">
            </div>
            <!-- <div class="form-group">
              <label>Koordinat Rumah Sakit di Google Maps</label>
              <input name="rumahSakitLatLong" type=" text" class="form-control" value="<?= $edit->rumahSakitLatLong; ?>">
            </div> -->
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
          <h5 class="modal-title">Hapus<strong> Data Rumah Sakit</strong></h5>
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