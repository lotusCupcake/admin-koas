<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <?php if (in_groups('Koordik')) : ?>
        <h1>Dosen Pembimbing</h1>
      <?php else : ?>
        <h1>Dosen/Koordik</h1>
      <?php endif; ?>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/dosenPembimbing"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahDosenPembimbing"><i class="fas fa-plus"></i> Tambah Data</button>
          <h4></h4>
          <div class="card-header-form">
            <form action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Nama" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
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
          <?php if ($validation->hasError('dopingNamaLengkap')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('dopingNamaLengkap')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('dopingEmail')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('dopingEmail')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('dopingNoHandphone')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('dopingNoHandphone')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('dopingAlamat')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('dopingAlamat')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('dopingRumkitId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('dopingRumkitId')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('username')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('username')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('password')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('password')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama Dan Gelar</th>
                  <th scope="col">No. Telp</th>
                  <th scope="col">Email</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Rumah Sakit</th>
                  <?php if (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
                    <th scope="col">Status</th>
                  <?php endif; ?>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($dosenPembimbing)) : ?>
                  <?php
                  $no = 1 + ($numberPage * ($currentPage - 1));
                  foreach ($dosenPembimbing as $row) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row->dopingNamaLengkap; ?></td>
                      <td><?= $row->dopingNoHandphone; ?></td>
                      <td><?= $row->dopingEmail; ?></td>
                      <td><?= $row->dopingAlamat; ?></td>
                      <td><?= $row->rumahSakitShortname; ?></td>
                      <?php if (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
                        <td><?= $row->type; ?></td>
                      <?php endif; ?>
                      <td style="text-align:center">
                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editDosenPembimbing<?= $row->dopingId; ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusDosenPembimbing<?= $row->dopingId; ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <tr>
                    <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('doping', 'pager') ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahDosenPembimbing">
  <div class="modal-dialog" role="document">
    <form action="/dosenPembimbing" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <?php if (in_groups('Koordik')) : ?>
            <h5 class="modal-title">Tambah Data <strong>Dosen Pembimbing</strong></h5>
          <?php else : ?>
            <h5 class="modal-title">Tambah Data <strong>Dosen/Koordik</strong></h5>
          <?php endif; ?>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Dan Gelar</label>
            <input name="dopingNamaLengkap" type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input name="username" type="text" class="form-control" value="">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input name="password" type="text" class="form-control" value="#UnggulCerdas">
          </div>
          <div class="form-group">
            <label>Email</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-envelope"></i>
                </div>
              </div>
              <input name="dopingEmail" type="text" class="form-control">
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
              <input name="dopingNoHandphone" type="text" class="form-control phone-number">
            </div>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input name="dopingAlamat" type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Rumah Sakit</label>
            <select class="form-control select2" name="dopingRumkitId">
              <option value="" selected="selected">--Select--</option>
              <?php foreach ($dataRumahSakit as $row) : ?>
                <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitNama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <?php if (in_groups('Koordik')) : ?>
              <input name="type" type="hidden" value="Dosen" class="form-control">
            <?php else : ?>
              <label>Status</label>
              <select class="form-control select2" name="type">
                <option value="">--Select--</option>
                <option value="Dosen">Dosen</option>
                <option value="Koordik">Koordik</option>
              </select>
            <?php endif; ?>
          </div>
          <?php if (in_groups('Koordik')) : ?>
            <p class="text-warning"><small>Menambahkan Data Dosen Pembimbing Sekaligus Membuat Akun</small></p>
          <?php else : ?>
            <p class="text-warning"><small>Menambahkan Data Dosen/Koordik Sekaligus Membuat Akun</small></p>
          <?php endif; ?>
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
<?php foreach ($dosenPembimbing as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editDosenPembimbing<?= $edit->dopingId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/dosenPembimbing/<?= $edit->dopingId; ?>/edit" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <?php if (in_groups('Koordik')) : ?>
              <h5 class="modal-title">Edit Data <strong>Dosen Pembimbing</strong></h5>
            <?php else : ?>
              <h5 class="modal-title">Edit Data <strong>Dosen/Koordik</strong></h5>
            <?php endif; ?>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Dan Gelar</label>
              <input name="dopingNamaLengkap" type="text" class="form-control" value="<?= $edit->dopingNamaLengkap; ?>">
            </div>
            <div class="form-group">
              <label>No. Telp</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-phone"></i>
                  </div>
                </div>
                <input name="dopingNoHandphone" type="text" class="form-control phone-number" value="<?= $edit->dopingNoHandphone; ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input name="dopingAlamat" type="text" class="form-control" value="<?= $edit->dopingAlamat; ?>">
            </div>
            <div class="form-group">
              <label>Rumah Sakit</label>
              <select class="form-control select2" name="dopingRumkitId">
                <?php foreach ($dataRumahSakit as $row) : ?>
                  <option value="<?= $row->rumahSakitId; ?>" <?php if ($row->rumahSakitId == $edit->dopingRumkitId) echo " selected" ?>><?= $row->rumahSakitNama; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php if (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
              <div class="form-group">
                <label>Status</label>
                <select class="form-control select2" name="type">
                  <option value="Dosen" <?= ($edit->type = "Dosen") ? "selected" : "" ?>>Dosen</option>
                  <option value="Koordik" <?= ($edit->type = "Koordik") ? "selected" : "" ?>>Koordik</option>
                </select>
              </div>
            <?php endif; ?>
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
<?php foreach ($dosenPembimbing as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusDosenPembimbing<?= $delete->dopingId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <?php if (in_groups('Koordik')) : ?>
            <h5 class="modal-title">Hapus Data <strong>Dosen Pembimbing</strong></h5>
          <?php else : ?>
            <h5 class="modal-title">Hapus Data <strong>Dosen/Koordik</strong></h5>
          <?php endif; ?>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data dosen <strong><?= $delete->dopingNamaLengkap; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/dosenPembimbing/<?= $delete->dopingId; ?>" method="post">
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