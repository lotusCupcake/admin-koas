<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dosen Pembimbing</h1>
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
          <?php if ($validation->hasError('dopingNamaLengkap')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('dopingNamaLengkap'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('dopingEmail')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('dopingEmail'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('dopingNoHandphone')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('dopingNoHandphone'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('dopingAlamat')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('dopingAlamat'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama Dan Gelar</th>
                  <th scope="col">Email</th>
                  <th scope="col">No. Telp</th>
                  <th scope="col">Alamat</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($dosenPembimbing as $row) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= $row->dopingNamaLengkap; ?></td>
                    <td><?= $row->dopingEmail; ?></td>
                    <td><?= $row->dopingNoHandphone; ?></td>
                    <td><?= $row->dopingAlamat; ?></td>
                    <td style="text-align:center">
                      <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editDosenPembimbing<?= $row->dopingId; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusDosenPembimbing<?= $row->dopingId; ?>"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
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
          <h5 class="modal-title">Tambah<strong> Data Dosen Pembimbing</strong></h5>
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
            <label>Email</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-envelope"></i>
                </div>
              </div>
              <input name="dopingEmail" type="text" class="form-control phone-number">
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
            <h5 class="modal-title">Edit<strong> Data Dosen Pembimbing</strong></h5>
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
              <label>Email</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-envelope"></i>
                  </div>
                </div>
                <input name="dopingEmail" type="text" class="form-control phone-number" value="<?= $edit->dopingEmail; ?>">
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
                <input name="dopingNoHandphone" type="text" class="form-control phone-number" value="<?= $edit->dopingNoHandphone; ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input name="dopingAlamat" type="text" class="form-control" value="<?= $edit->dopingAlamat; ?>">
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
<?php foreach ($dosenPembimbing as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusDosenPembimbing<?= $delete->dopingId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus<strong> Data Dosen Pembimbing</strong></h5>
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