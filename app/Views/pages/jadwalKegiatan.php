<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Jadwal Kegiatan</h1>
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
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Tanggal Mulai</th>
                  <th scope="col">Tanggal Akhir</th>
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
                    <td><?= $row_jadwal->jadwalTanggalMulai; ?></td>
                    <td><?= $row_jadwal->jadwalTanggalSelesai; ?></td>
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
          <h5 class="modal-title">Tambah<strong> Data Jadwal Kegiatan</strong></h5>
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
              <option value="" selected="selected">Pilih Rumah Sakit</option>
              <?php foreach ($dataRumahSakit as $row) : ?>
                <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitNama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Stase</label>
            <select class="form-control select2" name="staseId">
              <option value="" selected="selected">Pilih Stase</option>
            </select>
          </div>

          <div class="form-group">
            <label>Kelompok</label>
            <select class="form-control select2" name="kelompokId">
              <option value="" selected="selected">Pilih Kelompok</option>
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
              </div>
              <input type="text" class="form-control datepicker">
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
              <input type="text" class="form-control timepicker" value="08.00">
            </div>
          </div>
          <div class="form-group">
            <label>Jam Keluar</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-clock"></i>
                </div>
              </div>
              <input type="text" class="form-control timepicker" value="16.00">
            </div>
          </div>

          <div class="form-group">
            <label>Rumah Sakit</label>
            <select class="form-control select2" name="rumahSakitId" id="rumahSakitId">
              <option value="">--Select--</option>
              <?php foreach ($dataRumahSakit as $row) : ?>
                <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitNama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Stase</label>
            <select class="form-control select2" name="staseId" id="staseId">
              <option>Option 1</option>
              <option>Option 2</option>
              <option>Option 3</option>
            </select>
          </div>

          <div class="form-group">
            <label>Kelompok</label>
            <select class="form-control select2" name="kelompokId" id="kelompokId">
              <option>Option 1</option>
              <option>Option 2</option>
              <option>Option 3</option>
              <option>Option 4</option>
              <option>Option 5</option>
              <option>Option 6</option>
            </select>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<!-- end modal Edit -->

<!-- start modal hapus  -->
<div class="modal fade" tabindex="-1" role="dialog" id="hapusJadwalKegiatan">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus<strong> Data Jadwal Kegiatan</strong></h5>
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
      </div>
    </div>
  </div>
</div>
<!-- end modal hapus -->

<?= view('layout/templateFooter'); ?>



<?= $this->endSection(); ?>