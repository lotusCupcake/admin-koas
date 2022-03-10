<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Notifikasi</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/notif"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <div class="card-header-action">
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahNotifikasi"><i class="fas fa-plus"></i> Tambah Data</button>
          </div>
        </div>
        <div class="card-body">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('notifJudul')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('notifJudul')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('notifIsi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('notifIsi')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Judul</th>
                  <th scope="col">Isi</th>
                  <th scope="col">Penerima</th>
                  <th width=25%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($notif)) : ?>
                  <?php
                  $no = 1;
                  foreach ($notif as $row) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row->notifJudul; ?></td>
                      <td><?= $row->notifIsi; ?></td>
                      <td><?= ($row->notifPenerima) == 999 ? 'Semua Pengguna' : $row->notifPenerima; ?></td>
                      <td style="text-align:center">
                        <button class="btn btn-icon icon-left btn-light" data-toggle="modal" data-target="#kirimNotifikasi<?= $row->notifId; ?>"><i class="fas fa-paper-plane"></i></button>
                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editNotifikasi<?= $row->notifId; ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusNotifikasi<?= $row->notifId; ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 5]); ?>
                <?php endif ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- start modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahNotifikasi">
  <div class="modal-dialog" role="document">
    <form action="/notif" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data <strong>Notifikasi</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Judul</label>
            <div class="input-group">
              <input class="form-control" value="" name="notifJudul">
            </div>
          </div>
          <div class="form-group">
            <label>Isi</label>
            <textarea class="form-control" style="height: 72px;" name="notifIsi"></textarea>
          </div>
          <div class="form-group">
            <label>Penerima</label>
            <select name="notifPenerima[]" class="form-control select2" multiple="">
              <option value="999">Semua Pengguna</option>
              <?php foreach ($oneSignal as $row) : ?>
                <option value="<?= $row->oneSignalNpm; ?>"><?= $row->oneSignalNpm; ?></option>
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

<!-- start modal edit -->
<?php foreach ($notif as $edit) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editNotifikasi<?= $edit->notifId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data <strong>Notifikasi</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/notif/<?= $edit->notifId; ?>/edit" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
            <div class="form-group">
              <label>Judul</label>
              <div class="input-group">
                <input class="form-control" value="<?= $edit->notifJudul; ?>" name="notifJudul">
              </div>
            </div>
            <div class="form-group">
              <label>Isi</label>
              <textarea class="form-control" style="height: 72px;" name="notifIsi"><?= $edit->notifIsi; ?></textarea>
            </div>
            <div class="form-group">
              <label>Penerima</label>
              <select name="notifPenerima" class="form-control select2">
                <option value="999" <?= ($edit->notifPenerima == "999") ? "selected" : " " ?>>Semua Pengguna</option>
                <?php foreach ($oneSignal as $row) : ?>
                  <option value="<?= $row->oneSignalNpm; ?>" <?= ($row->oneSignalNpm == $edit->notifPenerima) ? "selected" : " " ?>><?= $row->oneSignalNpm; ?></option>
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
<?php endforeach; ?>
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($notif as $delete) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusNotifikasi<?= $delete->notifId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data<strong> Notifikasi</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin menghapus data notifikasi<strong> <?= $delete->notifJudul; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/notif/<?= $delete->notifId; ?>" method="post">
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

<!-- start modal kirim  -->
<?php foreach ($notif as $send) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="kirimNotifikasi<?= $send->notifId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Kirim Data<strong> Notifikasi</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu benar ingin mengirim notifikasi<strong> <?= $send->notifJudul; ?></strong> ke <strong> <?= ($send->notifPenerima == 999) ? "Semua Pengguna" : $send->notifPenerima; ?></strong>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <form action="/notif/send" method="post">
          <?= csrf_field(); ?>
          <input type="hidden" value="<?= $send->notifJudul; ?>" name="notifJudul">
          <input type="hidden" value="<?= $send->notifIsi; ?>" name="notifIsi">
          <input type="hidden" value="<?= $send->notifPenerima; ?>" name="notifPenerima">
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal kirim -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>