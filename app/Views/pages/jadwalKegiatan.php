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
          <?php if (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambahJadwalKegiatan"><i class="fas fa-plus"></i> Tambah Data</button>
          <?php endif; ?>
          <h4></h4>
          <div class="card-header-form col-md-4">
            <form action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Tahun Akademik/Rumah Sakit/Stase/Kelompok" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                <div class=" input-group-btn">
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
          <?php if ($validation->hasError('jumlahWeek')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('jumlahWeek')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('jamMasuk')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('jamMasuk')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('jamKeluar')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('jamKeluar')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitId')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('staseId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('staseId')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('kelompokId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('kelompokId')]]); ?>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Tahun Akademik</th>
                  <th scope="col">Tanggal Mulai/Akhir</th>
                  <th scope="col">Jam Operasional</th>
                  <th scope="col">Rumah Sakit</th>
                  <th scope="col">Stase</th>
                  <th scope="col">Kelompok</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($jadwalKegiatan)) : ?>
                  <?php
                  $no = 1  + ($numberPage * ($currentPage - 1));
                  foreach ($jadwalKegiatan as $row_jadwal) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row_jadwal->jadwalTahunAkademik; ?></td>
                      <td><a href="#!">
                          <span data-toggle="modal" data-target="#detailRumahSakit<?= $row_jadwal->kelompokId; ?>" class="text-primary"><?= gmdate('d-m-Y', minDateKel($row_jadwal->jadwalKelompokId, $row_jadwal->staseId) / 1000); ?> s/d <?= gmdate('d-m-Y', maxDateKel($row_jadwal->jadwalKelompokId, $row_jadwal->staseId) / 1000); ?>
                          </span></a>
                      </td>
                      <td><?= $row_jadwal->jadwalJamMasuk . " - " . $row_jadwal->jadwalJamKeluar ?></td>
                      <td><?= getRumkit($row_jadwal->jadwalKelompokId, $row_jadwal->staseId) ?></td>
                      <td><?= $row_jadwal->staseNama; ?></td>
                      <td><a href="#!"><span data-toggle="modal" data-target="#detail<?= $row_jadwal->jadwalId; ?>" class="text-primary"><?= $row_jadwal->kelompokNama ?></span></a></td>
                    </tr>
                  <?php endforeach ?>
                <?php else : ?>
                  <?= view('layout/templateEmpty', ['jumlahSpan' => 7]); ?>
                <?php endif ?>
              </tbody>
            </table>
            <?= $pager->links('jadwal', 'pager') ?>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- start modal detail rumah sakit -->
<?php foreach ($jadwalKegiatan as $detail) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="detailRumahSakit<?= $detail->kelompokId; ?>">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail <strong>Rumah Sakit Pada Jadwal</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Tanggal Mulai/Akhir</th>
                  <th scope="col">Rumah Sakit</th>
                  <th scope="col">Kelompok</th>
                  <?php if (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
                    <th width="15%" style="text-align:center" scope="col">Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach (getDetailJadwalKelStase($detail->jadwalKelompokId, $detail->staseId) as $key) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= gmdate('d-m-Y', $key->jadwalTanggalMulai / 1000); ?>/<?= gmdate('d-m-Y', $key->jadwalTanggalSelesai / 1000); ?></td>
                    <td><?= $key->rumahSakitShortname ?></td>
                    <td><a href="#!"><span data-toggle="modal" data-target="#detailMahasiswa<?= $key->jadwalId; ?>" class="text-primary"><?= $key->kelompokNama ?></a></td>
                    <?php if (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
                      <td style="text-align:center">
                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editJadwalKegiatan<?= $key->jadwalId; ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusJadwalKegiatan<?= $key->jadwalId; ?>"><i class="fas fa-trash"></i></button>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal detail rumah sakit -->

<!-- start modal detail mahasiswa di depan-->
<?php foreach ($jadwalKegiatan as $detail) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="detail<?= $detail->jadwalId; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail <strong>Mahasiswa</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">Nama/NPM Mahasiswa</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($kelompokDetail as $row) : ?>
                  <?php if ($row->kelompokDetKelompokId  == $detail->kelompokId) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                    </tr>
                  <?php endif ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal detail mahasiswa di depan -->

<!-- start modal detail mahasiswa -->
<?php foreach ($jadwalKegiatan as $detail) : ?>
  <?php foreach (getDetailJadwalKelStase($detail->jadwalKelompokId, $detail->staseId) as $stase) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="detailMahasiswa<?= $stase->jadwalId; ?>">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detail <strong>Mahasiswa Di <?= $stase->rumahSakitShortname; ?></strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="text-align:center" scope="col">No.</th>
                    <th scope="col">Nama/NPM Mahasiswa</th>
                    <th width="40%" scope="col">Tanggal Mulai/Akhir</th>
                    <?php if (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
                      <th style="text-align:center" scope="col">Action</th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($mhsDetail as $row) : ?>
                    <?php if ($row->jadwalDetailJadwalId == $stase->jadwalId) : ?>
                      <tr>
                        <td style="text-align:center" scope="row"><?= $no++; ?></td>
                        <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                        <td><?= gmdate('d-m-Y', ($row->jadwalDetailTanggalMulai / 1000)); ?> s/d <?= gmdate('d-m-Y', ($row->jadwalDetailTanggalSelesai / 1000)); ?></td>
                        <?php if (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
                          <td style="text-align:center">
                            <?php if ($row->skipNpm == null && $row->skipTanggalAktifKembali == null || $row->skipNpm != null && $row->skipTanggalAktifKembali != null) : ?>
                              <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#skipJadwal<?= $row->jadwalDetailId; ?>"><i class="fas fa-pause"></i></button>
                            <?php else : ?>
                              <button class="btn btn-icon icon-left btn-success" data-toggle="modal" data-target="#aktifJadwal<?= $row->jadwalDetailId; ?>"><i class="fas fa-check"></i></button>
                            <?php endif; ?>
                          </td>
                        <?php endif; ?>
                      </tr>
                    <?php endif ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>
<?php endforeach ?>
<!-- end modal detail mahasiswa -->

<!-- start modal skip jadwal -->
<?php foreach ($mhsDetail as $row) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="skipJadwal<?= $row->jadwalDetailId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/jadwalKegiatan/skip" method="POST">
        <?= csrf_field() ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tunda <strong>Jadwal Kegiatan</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="skipJadwalDetailId" value="<?= $row->jadwalDetailId; ?>">
            <input type="hidden" name="skipNpm" value="<?= $row->jadwalDetailNpm; ?>">
            <input type="hidden" value="<?= ($row->oneSignalPlayerId) == null ? null : $row->oneSignalPlayerId; ?>" name="playerId">
            <div class="form-group">
              <label>Tanggal Awal</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                  </div>
                </div>
                <input type="text" class="form-control datepicker" name="skipTanggalAwal">
              </div>
            </div>
            <div class="form-group">
              <label>Tanggal Akhir</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                  </div>
                </div>
                <input type="text" class="form-control datepicker" value="<?= date("Y-m-d", strtotime("+1 week")) ?>" name="skipTanggalAkhir">
              </div>
            </div>
            <div class="form-group">
              <label>Alasan Penundaan</label>
              <div class="input-group">
                <textarea name="skipAlasan" id="" class="form-control" style="height: 140px;"></textarea>
              </div>
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
<?php endforeach; ?>
<!-- end modal skip jadwal -->

<!-- start modal aktif jadwal -->
<?php foreach ($mhsDetail as $row) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="aktifJadwal<?= $row->jadwalDetailId; ?>">
    <div class="modal-dialog" role="document">
      <form action="/jadwalKegiatan/<?= $row->skipId; ?>/aktif" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" value="<?= ($row->oneSignalPlayerId) == null ? null : $row->oneSignalPlayerId; ?>" name="playerId">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Aktif <strong>Jadwal Kegiatan</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Tanggal Aktif Kembali</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                  </div>
                </div>
                <input type="text" class="form-control datepicker" name="skipTanggalAktifKembali">
              </div>
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
<?php endforeach; ?>
<!-- end modal aktif jadwal -->


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
            <label>Durasi (Minggu)</label>
            <div class="input-group">
              <input type="number" class="form-control" value="" name="jumlahWeek">
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
<?php foreach ($jadwalKegiatan as $edit_jadwal) : ?>
  <?php foreach (getDetailJadwalKelStase($edit_jadwal->jadwalKelompokId, $edit_jadwal->staseId) as $stase) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editJadwalKegiatan<?php echo $stase->jadwalId; ?>">
      <div class="modal-dialog" role="document">
        <form action="/jadwalKegiatan/<?= $stase->jadwalId; ?>/edit" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit<strong> Jadwal Kegiatan <?= $stase->rumahSakitShortname; ?></strong></h5>
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
                  <input type="text" class="form-control datepicker" name="tanggalAwal" value="<?= gmdate('Y-m-d', ($stase->jadwalTanggalMulai / 1000)); ?>">
                </div>
              </div>

              <div class="form-group">
                <label>Durasi (Minggu)</label>
                <div class="input-group">
                  <input type="number" class="form-control" value="<?php echo $stase->jadwalJumlahWeek;  ?>" name="jumlahWeek">
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
                  <input type="text" class="form-control timepicker" name="jamMasuk" value="<?php echo $stase->jadwalJamMasuk;  ?>">
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
                  <input type="text" class="form-control timepicker" name="jamKeluar" value="<?php echo $stase->jadwalJamKeluar;  ?>">
                </div>
              </div>

              <div class="form-group">
                <label>Rumah Sakit</label>
                <select class="form-control select2" name="rumahSakit">
                  <option value="<?php echo $stase->rumahSakitId;  ?>" selected="selected"><?php echo $stase->rumahSakitNama;  ?></option>
                  <?php foreach ($dataRumahSakit as $row) : ?>
                    <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitNama; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label>Stase</label>
                <select class="form-control select2" name="stase">
                  <option value="<?php echo $stase->rumkitDetId;  ?>" selected="selected"><?php echo $stase->staseNama;  ?></option>
                </select>
              </div>

              <div class="form-group">
                <label>Kelompok</label>
                <select class="form-control select2" name="kelompok">
                  <option value="<?php echo $stase->kelompokId;  ?>" selected="selected"><?php echo $stase->kelompokNama;  ?></option>
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
  <?php endforeach; ?>
<?php endforeach; ?>
<!-- end modal Edit -->

<!-- start modal hapus  -->
<?php foreach ($jadwalKegiatan as $hapus) : ?>
  <?php foreach (getDetailJadwalKelStase($hapus->jadwalKelompokId, $hapus->staseId) as $hapus_jadwal) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapusJadwalKegiatan<?= $hapus_jadwal->jadwalId; ?>">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Hapus Data <strong>Jadwal Kegiatan <?= $hapus_jadwal->rumahSakitShortname; ?></strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="/jadwalKegiatan/<?= $hapus_jadwal->jadwalId; ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="DELETE">
            <div class="modal-body">
              <p>Apakah kamu ingin menghapus jadwal kegiatan <?= $hapus_jadwal->kelompokNama; ?>?</p>
              <p class="text-warning"><small>This action cannot be undone</small></p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="submit" class="btn btn-danger">Delete</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endforeach; ?>
<!-- end modal hapus -->

<?= view('layout/templateFooter'); ?>



<?= $this->endSection(); ?>