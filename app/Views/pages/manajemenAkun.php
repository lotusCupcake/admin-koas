<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Manajemen Akun</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
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
          <?php if ($validation->hasError('userEmail')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('userEmail'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('userName')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('userName'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('userRole')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('userRole'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped">
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
                <?php
                $no = 1;
                foreach ($users as $user) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= $user->email; ?></td>
                    <td><?= $user->username; ?></td>
                    <td><?= $user->name; ?></td>
                    <td style="text-align:center"><span class="badge <?= $user->active == 1 ? "badge-success" : "badge-danger"; ?>"><?= $user->active == 1 ? "Aktif" : "Tidak Aktif"; ?></span></td>
                    <td style="text-align:center">
                      <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editAkun<?= $user->userid; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusAkun<?= $user->userid; ?>"><i class="fas fa-trash"></i></button>
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

<!-- start modal edit  -->
<?php foreach ($users as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editAkun<?= $edit->userid; ?>">
    <div class="modal-dialog" role="document">
      <form action="/manajemenAkun/<?= $edit->userid; ?>/edit" method="POST">
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
                  <option value="<?= $groups->id; ?>" <?php if ($groups->id == $edit->groups_id) echo "selected" ?>><?= $groups->name; ?></option>
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
<?php foreach ($users as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusAkun<?= $delete->userid; ?>">
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
        <form action="/manajemenAkun/<?= $delete->userid; ?>" method="post">
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