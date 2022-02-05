<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Manajemen Akun</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/manajemenAkun"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4></h4>
          <div class="card-header-form col-md-4">
            <form action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Email/Username/Role" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
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
          <?php if ($validation->hasError('userEmail')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('userEmail')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('userName')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('userName')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('userRole')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('userRole')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Email</th>
                  <th scope="col">Username</th>
                  <th scope="col">Role</th>
                  <th style="text-align:center" scope="col">Status</th>
                  <th width="20%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($akun)) : ?>
                  <?php
                  $no = 1 + ($numberPage * ($currentPage - 1));
                  foreach ($akun as $user) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $user->email; ?></td>
                      <td><?= $user->username; ?></td>
                      <td><?= $user->name; ?></td>
                      <td style="text-align:center"><span class="badge <?= $user->active == 1 ? "badge-success" : "badge-danger"; ?>"><?= $user->active == 1 ? "Aktif" : "Tidak Aktif"; ?></span></td>
                      <td style="text-align:center">
                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editAkun<?= $user->user_id; ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusAkun<?= $user->user_id; ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('akun', 'pager') ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- start modal edit  -->
<?php foreach ($akun as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editAkun<?= $edit->user_id; ?>">
    <div class="modal-dialog" role="document">
      <form action="/manajemenAkun/<?= $edit->user_id; ?>/edit" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit<strong> Data Akun</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Email</label>
              <input name="userEmail" type="text" class="form-control" value="<?= $edit->email; ?>">
            </div>
            <div class="form-group">
              <label>Username</label>
              <input name="userName" type="text" class="form-control" value="<?= $edit->username; ?>">
            </div>
            <div class="form-group">
              <label>Role</label>
              <select name="userRole" class="form-control select2">
                <?php foreach ($authGroups as $groups) : ?>
                  <option value="<?= $groups->id; ?>" <?php if ($groups->id == $edit->id) echo "selected" ?>><?= $groups->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <div class="control-label">Status</div>
              <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                <input type="checkbox" name="userActive" <?= ($edit->active == 1) ? "checked" : ""; ?> value="<?= $edit->active; ?>" class=" custom-switch-input">
                <span class="custom-switch-indicator"></span>
              </label>
              <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Aktif/Tidak Aktif)</span>
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
<?php foreach ($akun as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusAkun<?= $delete->id; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus<strong> Data Akun</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data akun <strong><?= $delete->email; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/manajemenAkun/<?= $delete->id; ?>" method="post">
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