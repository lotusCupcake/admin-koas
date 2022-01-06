<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Kelompok Mahasiswa</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/kelompokDosen"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahKelompokMahasiswa"><i class="fas fa-plus"></i> Tambah Data</button>
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
          <?php if ($validation->hasError('kelompokDetKelompokId')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('kelompokDetKelompokId'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('kelompokDetNim')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('kelompokDetNim'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th width="10%" style="text-align:center" scope="col">No.</th>
                  <th scope="col">Kelompok Mahasiswa</th>
                  <th scope="col">NPM Mahasiswa</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($kelompok as $row) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= $row->kelompokNama; ?></td>
                    <td><?= $row->kelompokDetNim; ?></td>
                    <td style="text-align:center">
                      <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editKelompokMahasiswa<?= $row->kelompokDetId; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusKelompokMahasiswa<?= $row->kelompokDetId; ?>"><i class="fas fa-trash"></i></button>
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
<div class="modal fade" tabindex="-1" role="dialog" id="tambahKelompokMahasiswa">
  <div class="modal-dialog" role="document">
    <form action="/kelompokMahasiswa" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data<strong> Kelompok Mahasiswa</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Kelompok Mahasiswa</label>
            <select name="kelompokDetKelompokId" class="form-control select2">
              <option value="">--Select--</option>
              <?php foreach ($dataKelompok as $row) : ?>
                <option value="<?= $row->kelompokId; ?>"><?= $row->kelompokNama; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label>NPM Mahasiswa</label>
            <select name="kelompokDetNim" class="form-control select2">
              <option value="">--Select--</option>
              <?php foreach ($mahasiswaProfesi as $mahasiswa) : ?>
                <option value="<?= $mahasiswa->Nim; ?>"><?= $mahasiswa->Nim; ?></option>
              <?php endforeach; ?>
            </select>
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
<?php foreach ($kelompok as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editKelompokMahasiswa<?= $edit->kelompokDetId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/kelompokMahasiswa/<?= $edit->kelompokDetId; ?>/edit" method="post">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data <strong>Kelompok Mahasiswa</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Kelompok Mahasiswa</label>
              <select name="kelompokDetKelompokId" class="form-control select2">
                <?php foreach ($dataKelompok as $row) : ?>
                  <option value="<?= $row->kelompokId; ?>" <?php if ($row->kelompokId == $edit->kelompokDetKelompokId) echo "selected" ?>><?= $row->kelompokNama; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>NPM Mahasiswa</label>
              <select name="kelompokDetNim" class="form-control select2">
                <?php foreach ($mahasiswaProfesi as $mahasiswa) : ?>
                  <option value="<?= $mahasiswa->Nim; ?>" <?php if ($mahasiswa->Nim == $edit->kelompokDetNim) echo "selected" ?>><?= $mahasiswa->Nim; ?></option>
                <?php endforeach; ?>
              </select>
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
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($kelompok as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusKelompokMahasiswa<?= $delete->kelompokDetId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data <strong>Kelompok Mahasiswa</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data <strong> <?= $delete->kelompokDetNim; ?></strong> di <strong><?= $delete->kelompokNama; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/kelompokMahasiswa/<?= $delete->kelompokDetId; ?>" method="post">
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