<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Kelompok</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/dataKelompok"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahDataKelompok"><i class="fas fa-plus"></i> Tambah Data</button>
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
          <?php if ($validation->hasError('kelompokNama')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('kelompokNama'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('kelompokDosenKelompokId')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('kelompokDosenKelompokId'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('kelompokTahunAkademik')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('kelompokTahunAkademik'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th width="10%" style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama Kelompok</th>
                  <th scope="col">Kelompok Dosen</th>
                  <th scope="col">Tahun Akademik</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($dosen as $row) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= $row->kelompokNama; ?></td>
                    <td><?= $row->dosenKelompokNama; ?></td>
                    <td><?= $row->kelompokTahunAkademik; ?></td>
                    <td style="text-align:center">
                      <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editDataKelompok<?= $row->kelompokId; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusDataKelompok<?= $row->kelompokId; ?>"><i class="fas fa-trash"></i></button>
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
<div class="modal fade" tabindex="-1" role="dialog" id="tambahDataKelompok">
  <div class="modal-dialog" role="document">
    <form action="/dataKelompok" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah<strong> Data Kelompok</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Kelompok</label>
            <input name="kelompokNama" type=" text" class="form-control">
          </div>
          <div class="form-group">
            <label>Kelompok Dosen</label>
            <select name="kelompokDosenKelompokId" class="form-control select2">
              <option value="">--Select--</option>
              <?php foreach ($kelompokDosen as $row) : ?>
                <option value="<?= $row->dosenKelompokId; ?>"><?= $row->dosenKelompokNama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tahun Akademik</label>
            <input name="kelompokTahunAkademik" type=" text" class="form-control">
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
<?php foreach ($dosen as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editDataKelompok<?= $edit->kelompokId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/dataKelompok/<?= $edit->kelompokId; ?>/edit" method="post">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit<strong> Data Kelompok</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Kelompok</label>
              <input name="kelompokNama" type=" text" class="form-control" value="<?= $edit->kelompokNama; ?>">
            </div>
            <div class="form-group">
              <label>Nama Kelompok</label>
              <select name="kelompokDosenKelompokId" class="form-control select2">
                <?php foreach ($kelompokDosen as $row) : ?>
                  <option value="<?= $row->dosenKelompokId; ?>" <?php if ($row->dosenKelompokId == $edit->kelompokDosenKelompokId) echo "selected" ?>><?= $row->dosenKelompokNama; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Tahun Akademik</label>
              <input name="kelompokTahunAkademik" type="text" class="form-control" value="<?= $edit->kelompokTahunAkademik; ?>">
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
<?php foreach ($dosen as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusDataKelompok<?= $delete->kelompokId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus<strong> Data Kelompok</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data <strong><?= $delete->kelompokNama; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/dataKelompok/<?= $delete->kelompokId; ?>" method="post">
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