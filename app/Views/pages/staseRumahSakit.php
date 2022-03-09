<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Stase Di RS</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/staseRumahSakit"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahStaseRumahSakit"><i class="fas fa-plus"></i> Tambah Data</button>
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
          <?php if ($validation->hasError('detRumkit')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('detRumkit'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('detStatus')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('detStatus'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Rumah Sakit</th>
                  <th scope="col">Stase</th>
                  <th style="text-align:center" scope="col">Status</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($dataRumahSakit as $row) : ?>
                  <tr>
                    <td rowspan="<?= array_count_values($dataNamaRs)[$row->rumahSakitNama] ?>"><strong><?= $no++ ?></strong></td>
                    <td rowspan="<?= array_count_values($dataNamaRs)[$row->rumahSakitNama] ?>"><strong><?= $row->rumahSakitNama ?></strong></td>
                    <?php $u = 0;
                    foreach ($staseRumahSakit as $r) : ?>
                      <?php if ($r->rumkitDetRumkitId == $row->rumahSakitId) : ?>
                        <?php if ($u < 1) : ?>
                          <td><?= $r->staseNama; ?></td>
                          <td style="text-align:center" scope="row"><span class="badge <?= $r->rumkitDetStatus == 1 ? "badge-success" : "badge-danger"; ?>"><?= $r->rumkitDetStatus == 1 ? "Tersedia" : "Tidak Tersedia"; ?></span></td>
                          <td style="text-align:center">
                            <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editStaseRumahSakit<?= $r->rumkitDetId; ?>"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusStaseRumahSakit<?= $r->rumkitDetId; ?>"><i class="fas fa-trash"></i></button>
                          </td>
                  </tr>
                <?php else : ?>
                  <tr>
                    <td><?= $r->staseNama; ?></td>
                    <td style="text-align:center" scope="row"><span class="badge <?= $r->rumkitDetStatus == 1 ? "badge-success" : "badge-danger"; ?>"><?= $r->rumkitDetStatus == 1 ? "Tersedia" : "Tidak Tersedia"; ?></span></td>
                    <td style="text-align:center">
                      <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editStaseRumahSakit<?= $r->rumkitDetId; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusStaseRumahSakit<?= $r->rumkitDetId; ?>"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                <?php $u++;
                        endif ?>
              <?php endif ?>
            <?php endforeach ?>
          <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahStaseRumahSakit">
  <div class="modal-dialog" role="document">
    <form action="/staseRumahSakit" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data<strong> Stase Di RS</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Rumah Sakit</label>
            <select name="detRumkit" class="form-control select2">
              <option value="">--Select--</option>
              <?php foreach ($dataRumahSakit->findAll() as $row) : ?>
                <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitNama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Stase</label>
            <select name="detStase" class="form-control select2">
              <option value="">--Select--</option>
              <?php foreach ($dataBagian->findAll() as $row) : ?>
                <option value="<?= $row->staseId; ?>"><?= $row->staseNama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <div class="control-label">Status Stase</div>
            <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
              <input type="checkbox" name="detStatus" class="custom-switch-input">
              <span class="custom-switch-indicator"></span>
            </label>
            <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Tersedia/Tidak Tersedia)</span>
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

<!-- start modal edit  -->
<?php foreach ($staseRumahSakit as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editStaseRumahSakit<?= $edit->rumkitDetId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/staseRumahSakit/<?= $edit->rumkitDetId; ?>/edit" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data<strong> Stase Di RS</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Rumah Sakit</label>
              <select name="detRumkit" class="form-control select2">
                <?php foreach ($dataRumahSakit->findAll() as $row) : ?>
                  <option value="<?= $row->rumahSakitId; ?>" <?php if ($row->rumahSakitId == $edit->rumkitDetRumkitId) echo "selected" ?>><?= $row->rumahSakitNama; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Stase</label>
              <select name="detStase" class="form-control select2">

                <?php foreach ($dataBagian->findAll() as $row) : ?>
                  <option value="<?= $row->staseId; ?>" <?php if ($row->staseId == $edit->rumkitDetStaseId) echo "selected" ?>><?= $row->staseNama; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <div class="control-label">Status Stase</div>
              <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                <input type="checkbox" name="detStatus" <?= ($edit->rumkitDetStatus == 1) ? "checked" : ""; ?> value="<?= $edit->rumkitDetStatus; ?>" class=" custom-switch-input">
                <span class="custom-switch-indicator"></span>
              </label>
              <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Tersedia/Tidak Tersedia)</span>
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
<?php endforeach ?>
<!-- end modal Edit -->

<!-- start modal hapus  -->
<?php foreach ($staseRumahSakit as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusStaseRumahSakit<?= $delete->rumkitDetId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data<strong> Stase Di RS</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data <strong>stase <?= $delete->staseNama; ?></strong> di <strong><?= $delete->rumahSakitNama; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/staseRumahSakit/<?= $delete->rumkitDetId; ?>" method="post">
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