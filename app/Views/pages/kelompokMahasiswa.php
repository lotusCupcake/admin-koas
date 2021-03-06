<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Kel. Mahasiswa</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/kelompokMahasiswa"><?= $breadcrumb[1]; ?></a></div>
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
                <input type="text" class="form-control" placeholder="Search Tahun/Kelompok/Nama/NPM" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-body">
          <div class="alert alert-primary alert-has-icon alert-dismissible show fade">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>&times;</span>
              </button>
              <div class="alert-title">Tips</div>
              Untuk edit dan menambahkan mahasiswa ke dalam kelompok bisa melalui halaman <strong>Kelompok</strong> atau klik <a href="/dataKelompok">disini.</a>
            </div>
          </div>
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="10%" style="text-align:center" scope="col">No.</th>
                  <th scope="col">Tahun</th>
                  <th scope="col">Kelompok Mahasiswa</th>
                  <th scope="col">Nama/NPM Mahasiswa</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($kelompokDetail)) : ?>
                  <?php
                  $no = 1  + ($numberPage * ($currentPage - 1));
                  foreach ($kelompokDetail as $row) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td scope="row"><?= $row->kelompokTahunAkademik; ?></td>
                      <td><?= $row->kelompokNama; ?></td>
                      <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                      <td style="text-align:center">
                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusKelompokMahasiswa<?= $row->kelompokDetId; ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 5]); ?>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('kelompok', 'pager') ?>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal hapus  -->
<?php foreach ($kelompokDetail as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusKelompokMahasiswa<?= $delete->kelompokDetId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data <strong>Mahasiswa Di Kelompok</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data <strong><?= $delete->kelompokDetNama; ?> (<?= $delete->kelompokDetNim; ?>)</strong>?</p>
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