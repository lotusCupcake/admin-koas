<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Jadwal Kegiatan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahJadwalKegiatan"><i class="fas fa-plus"></i> Tambah Data</button>
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
          <?php if ($validation->hasError('tanggalAwal')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('tanggalAwal'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('jamMasuk')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('jamMasuk'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('jamKeluar')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('jamKeluar'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitId')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('rumahSakitId'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('staseId')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('staseId'); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($validation->hasError('kelompokId')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <strong>Failed ! </strong><?= $validation->getError('dosenKelompokNama'); ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Tanggal Mulai/Akhir</th>
                  <th scope="col">Durasi (Minggu)</th>
                  <th scope="col">Jam Operasional</th>
                  <th scope="col">Rumah Sakit</th>
                  <th scope="col">Stase</th>
                  <th scope="col">Kelompok</th>
                  <th width="15%" style="text-align:center" scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($jadwalKegiatan->getResult() as $row_jadwal) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= $row_jadwal->jadwalTanggalMulai . " s/d " . $row_jadwal->jadwalTanggalSelesai; ?></td>
                    <td><?= $row_jadwal->staseJumlahWeek; ?></td>
                    <td><?= $row_jadwal->jadwalJam; ?></td>
                    <td><?= $row_jadwal->rumahSakitNama; ?></td>
                    <td><?= $row_jadwal->staseNama; ?></td>
                    <td><?= $row_jadwal->Mahasiswa; ?></td>
                    <td style="text-align:center">
                      <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editJadwalKegiatan<?= $row_jadwal->jadwalId; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusJadwalKegiatan<?= $row_jadwal->jadwalId; ?>"><i class="fas fa-trash"></i></button>
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
<div class="modal fade" tabindex="-1" role="dialog" id="tambahJadwalKegiatan">
  <div class="modal-dialog" role="document">
    <form action="/jadwalKegiatan" method="POST">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data <strong>Jadwal Kegiatan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Tanggal Awal</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-calendar"></i>
                </div>
              </div>
              <input type="text" class="form-control datepicker" name="tanggalAwal">
            </div>
          </div>
          <div class="form-group">
            <label>Jam Masuk</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-clock"></i>
                </div>
              </div>
              <input type="text" class="form-control timepicker" value="08.00" name="jamMasuk">
            </div>
          </div>
          <div class=" form-group">
            <label>Jam Keluar</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-clock"></i>
                </div>
              </div>
              <input type="text" class="form-control timepicker" value="16.00" name="jamKeluar">
            </div>
          </div>

          <div class="form-group">
            <label>Rumah Sakit</label>
            <select class="form-control select2" name="rumahSakitId">
              <option value="" selected="selected">--Select--</option>
              <?php foreach ($dataRumahSakit as $row) : ?>
                <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitNama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Stase</label>
            <select class="form-control select2" name="staseId">
              <option value="" selected="selected">--Select--</option>
            </select>
          </div>

          <div class="form-group">
            <label>Kelompok</label>
            <select class="form-control select2" name="kelompokId">
              <option value="" selected="selected">--Select--</option>
            </select>
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
<?php foreach ($jadwalKegiatan->getResult() as $edit_jadwal) { ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editJadwalKegiatan<?php echo $edit_jadwal->jadwalId; ?>">
    <div class="modal-dialog" role="document">
<<<<<<< HEAD
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data<strong> Jadwal Kegiatan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Tanggal Awal</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-calendar"></i>
=======
      <form action="/jadwalKegiatan/<?= $edit_jadwal->jadwalId; ?>/edit" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit<strong> Jadwal Kegiatan</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Tanggal Awal</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                  </div>
>>>>>>> 69d14708d08e63f0164534ee291d24ece1303fc5
                </div>
                <input type="text" class="form-control datepicker" name="tanggalAwal" value="<?php echo $edit_jadwal->jadwalTanggalMulai;  ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Jam Masuk</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
                <input type="text" class="form-control timepicker" name="jamMasuk" value="<?php echo $edit_jadwal->jadwalJamMasuk;  ?>">
              </div>
            </div>
            <div class=" form-group">
              <label>Jam Keluar</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
                <input type="text" class="form-control timepicker" name="jamKeluar" value="<?php echo $edit_jadwal->jadwalJamKeluar;  ?>">
              </div>
            </div>

            <div class="form-group">
              <label>Rumah Sakit</label>
              <select class="form-control select2" name="rumahSakit">
                <option value="<?php echo $edit_jadwal->rumahSakitId;  ?>" selected="selected"><?php echo $edit_jadwal->rumahSakitNama;  ?></option>
                <?php foreach ($dataRumahSakit as $row) : ?>
                  <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitNama; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Stase</label>
              <select class="form-control select2" name="stase">
                <option value="<?php echo $edit_jadwal->rumkitDetId;  ?>" selected="selected"><?php echo $edit_jadwal->staseNama;  ?></option>
              </select>
            </div>

            <div class="form-group">
              <label>Kelompok</label>
              <select class="form-control select2" name="kelompok">
                <option value="<?php echo $edit_jadwal->kelompokId;  ?>" selected="selected"><?php echo $edit_jadwal->kelompokNama;  ?></option>
              </select>
            </div>
          </div>

          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>
<!-- end modal Edit -->

<!-- start modal hapus  -->
<<<<<<< HEAD
<div class="modal fade" tabindex="-1" role="dialog" id="hapusJadwalKegiatan">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Data <strong>Jadwal Kegiatan</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah kamu benar ingin menghapus data jadwal kegiatan?</p>
        <p class="text-warning"><small>This action cannot be undone</small></p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
=======
<?php foreach ($jadwalKegiatan->getResult() as $hapus_jadwal) { ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusJadwalKegiatan<?php echo $hapus_jadwal->jadwalId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus<strong> Data Jadwal Kegiatan</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu ingin menghapus jadwal kegiatan <?php echo $hapus_jadwal->kelompokNama; ?>?</p>
          <p class="text-warning"><small>This action cannot be undone</small></p>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
>>>>>>> 69d14708d08e63f0164534ee291d24ece1303fc5
      </div>
    </div>
  </div>
<?php } ?>
<!-- end modal hapus -->

<?= view('layout/templateFooter'); ?>



<?= $this->endSection(); ?>