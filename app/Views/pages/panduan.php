<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Panduan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/panduan"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <?php if (in_groups(['Admin Prodi', 'Superadmin'])) : ?>
          <div class="card-header">
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahPanduan"><i class="fas fa-plus"></i> Tambah Data</button>
          </div>
        <?php endif; ?>
        <div class="card-body">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('panduanNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('panduanNama')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('panduanFile')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('panduanFile')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="10%" style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama Panduan</th>
                  <?php if (in_groups(['Admin Prodi', 'Koordik', 'Superadmin'])) : ?>
                    <th scope="col">Ditujukan Untuk</th>
                  <?php endif; ?>
                  <?php if (in_groups(['Admin Prodi', 'Superadmin'])) : ?>
                    <th style="text-align:center" scope="col">Status</th>
                  <?php endif; ?>
                  <th width="20%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($panduan as $row) : ?>
                  <?php if (in_groups(['Admin Prodi', 'Superadmin'])) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row->panduanNama; ?></td>
                      <td><?= $row->panduanPeruntukan == 'semua' ? ('Semua') : ($row->panduanPeruntukan == 'dosen' ? ('Dosen') : ('Mahasiswa')) ?></td>
                      <td style="text-align:center"><span class="badge <?= $row->panduanStatus == 1 ? "badge-success" : "badge-danger"; ?>"><?= $row->panduanStatus == 1 ? "Berlaku" : "Tidak Berlaku"; ?></td>
                      <td style="text-align:center">
                        <button class="btn btn-icon icon-left btn-light" data-toggle="modal" data-target="#lihatPanduan<?= $row->panduanId; ?>"><i class="far fa-file-alt"></i></button>
                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editPanduan<?= $row->panduanId; ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusPanduan<?= $row->panduanId; ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php elseif (in_groups('Koordik')) : ?>
                    <?php if ($row->panduanStatus == 1) : ?>
                      <tr>
                        <td style="text-align:center" scope="row"><?= $no++; ?></td>
                        <td><?= $row->panduanNama; ?></td>
                        <td><?= $row->panduanPeruntukan == 'semua' ? ('Semua') : ($row->panduanPeruntukan == 'dosen' ? ('Dosen') : ('Mahasiswa')) ?></td>
                        <td style="text-align:center">
                          <button class="btn btn-icon icon-left btn-light" data-toggle="modal" data-target="#lihatPanduan<?= $row->panduanId; ?>"><i class="far fa-file-alt"></i></button>
                        </td>
                      </tr>
                    <?php endif; ?>
                  <?php else : ?>
                    <?php if ($row->panduanStatus == 1 && $row->panduanPeruntukan == 'dosen' || $row->panduanPeruntukan == 'semua') : ?>
                      <tr>
                        <td style="text-align:center" scope="row"><?= $no++; ?></td>
                        <td><?= $row->panduanNama; ?></td>
                        <td style="text-align:center">
                          <button class="btn btn-icon icon-left btn-light" data-toggle="modal" data-target="#lihatPanduan<?= $row->panduanId; ?>"><i class="far fa-file-alt"></i></button>
                        </td>
                      </tr>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- start modal tambah panduan -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahPanduan">
  <div class="modal-dialog" role="document">
    <form action="/panduan" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah<strong> Panduan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Panduan</label>
            <input name="panduanNama" type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>File Panduan</label>
            <div class="custom-file">
              <input name="panduanFile" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          </div>
          <div class="form-group">
            <label>Ditujukan Untuk</label>
            <select class="form-control select2" name="panduanPeruntukan">
              <option value="semua">Semua</option>
              <option value="dosen">Dosen</option>
              <option value="mahasiswa">Mahasiswa</option>
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
<!-- end modal tambah panduan -->

<!-- start modal edit panduan -->
<?php foreach ($panduan as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editPanduan<?= $edit->panduanId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/panduan/<?= $edit->panduanId; ?>/edit" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="fileLama" value="<?= $edit->panduanFile; ?>">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit<strong> Panduan</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Panduan</label>
              <input name="panduanNama" type="text" class="form-control" value="<?= $edit->panduanNama; ?>">
            </div>
            <label>File Panduan</label>
            <div class="form-group">
              <div class="custom-file">
                <input name="panduanFile" type="file" accept="application/pdf" class="custom-file-input" value="<?= $edit->panduanFile; ?>" id="customFile<?= $edit->panduanId; ?>" onchange="labelDokumenEdit(<?= $edit->panduanId; ?>)">
                <label class="custom-file-label custom-file-label<?= $edit->panduanId; ?>" for="customFile"><?= $edit->panduanFile; ?></label>
              </div>
            </div>
            <div class="form-group">
              <div class="control-label">Status File</div>
              <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                <input type="checkbox" name="panduanStatus" <?= ($edit->panduanStatus == 1) ? "checked" : ""; ?> value="<?= $edit->panduanStatus; ?>" class="custom-switch-input">
                <span class="custom-switch-indicator"></span>
              </label>
              <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Berlaku/Tidak Berlaku)</span>
            </div>
            <div class="form-group">
              <label>Ditujukan Untuk</label>
              <select class="form-control select2" name="panduanPeruntukan">
                <option value="semua" <?= ($edit->panduanPeruntukan == "semua") ? "selected" : "" ?>>Semua</option>
                <option value="dosen" <?= ($edit->panduanPeruntukan == "dosen") ? "selected" : "" ?>>Dosen</option>
                <option value="mahasiswa" <?= ($edit->panduanPeruntukan == "mahasiswa") ? "selected" : "" ?>>Mahasiswa</option>
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
<!-- end modal edit panduan -->

<!-- start modal hapus -->
<?php foreach ($panduan as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusPanduan<?= $delete->panduanId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus<strong> Panduan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data panduan<strong> <?= $delete->panduanNama; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/panduan/<?= $delete->panduanId; ?>" method="post">
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

<!-- start modal lihat  -->
<?php foreach ($panduan as $lihat) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="lihatPanduan<?= $lihat->panduanId; ?>">
    <div class="modal-dialog modal-xl" role="banner">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">File<strong> Panduan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <embed src="<?= base_url() ?>/dokumen/<?= $lihat->panduanFile; ?>" frameborder="0" width="100%" height="500px">
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal lihat  -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>