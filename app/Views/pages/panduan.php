<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Panduan Profesi</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/panduan"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahPanduan"><i class="fas fa-plus"></i> Tambah Data</button>
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
          <?php if ($validation->hasError('panduanNama')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('panduanNama'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('panduanFile')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('panduanFile'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th width="10%" style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama Panduan Profesi</th>
                  <th scope="col">Status</th>
                  <th width="20%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($panduan as $row) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= $row->panduanNama; ?></td>
                    <td><span class="badge <?= $row->panduanStatus == 1 ? "badge-success" : "badge-danger"; ?>"><?= $row->panduanStatus == 1 ? "Berlaku" : "Tidak Berlaku"; ?></td>
                    <td style="text-align:center">
                      <button class="btn btn-icon icon-left btn-light" data-toggle="modal" data-target="#lihatPanduan<?= $row->panduanId; ?>"><i class="far fa-file-alt"></i></button>
                      <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editPanduan<?= $row->panduanId; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusPanduan<?= $row->panduanId; ?>"><i class="fas fa-trash"></i></button>
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

<!-- start modal tambah panduan -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahPanduan">
  <div class="modal-dialog" role="document">
    <form action="/panduan" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah<strong> Panduan Profesi</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Panduan Profesi</label>
            <input name="panduanNama" type="text" class="form-control">
          </div>
          <label>File Panduan Profesi</label>
          <div class="form-group">
            <div class="custom-file">
              <input name="panduanFile" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
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
            <h5 class="modal-title">Edit<strong> Panduan Profesi</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Panduan Profesi</label>
              <input name="panduanNama" type="text" class="form-control" value="<?= $edit->panduanNama; ?>">
            </div>
            <label>File Panduan Profesi</label>
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
          <h5 class="modal-title">Hapus<strong> Panduan Profesi</strong></h5>
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
    <div class="modal-dialog modal-lg" role="banner">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">File<strong> Panduan Profesi</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <embed src="dokumen<?= $lihat->panduanFile; ?>" frameborder="0" width="100%" height="500px">
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal lihat  -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>