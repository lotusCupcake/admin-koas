<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Penilaian</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <!-- <div class="card-header">
          <h4>Bordered Tab</h4>
        </div> -->
        <div class="card-body">
          <ul class="nav nav-tabs" id="myTab3" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pre-test" data-toggle="tab" href="#pretest" role="tab" aria-controls="contact" aria-selected="true">Pretest</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tutorial-klinik" data-toggle="tab" href="#tutorialKlinik" role="tab" aria-controls="contact" aria-selected="false">Tutorial Klinik</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="jurnal-reading" data-toggle="tab" href="#jurnalReading" role="tab" aria-controls="contact" aria-selected="false">Jurnal Reading</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="refa-rat" data-toggle="tab" href="#refarat" role="tab" aria-controls="contact" aria-selected="false">Refarat</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="refleksi-kasus" data-toggle="tab" href="#refleksiKasus" role="tab" aria-controls="contact" aria-selected="false">Laporan/Refleksi Kasus</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="mid-test" data-toggle="tab" href="#midTest" role="tab" aria-controls="contact" aria-selected="false">Mid Test</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="follow-up" data-toggle="tab" href="#followUp" role="tab" aria-controls="contact" aria-selected="false">Mini Cex/Follow Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="post-test" data-toggle="tab" href="#postTest" role="tab" aria-controls="contact" aria-selected="false">Post Test</a>
            </li>
          </ul>
          <div class="tab-content tab-bordered" id="myTab3Content">
            <div class="tab-pane fade show active" id="pretest" role="tabpanel" aria-labelledby="pre-test">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">Tanggal</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Kelompok</th>
                      <th scope="col">Stase</th>
                      <th style="text-align:center" scope="col">Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mhs->logbookTanggal ?></td>
                        <td><?= $mhs->kelompokDetNim ?></td>
                        <td><?= $mhs->kelompokDetNama ?></td>
                        <td><?= $mhs->kelompokNama ?></td>
                        <td><?= $mhs->staseNama ?></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade show" id="tutorialKlinik" role="tabpanel" aria-labelledby="tutorial-klinik">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Sikap & Tanggungjawab</th>
                      <th scope="col">Peran Aktif & Komunikasi</th>
                      <th scope="col">Sumber Informasi</th>
                      <th scope="col">Informasi yang disampaikan</th>
                      <th scope="col">Penalaran Klinis</th>
                      <th style="text-align:center" scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mhs->kelompokDetNim ?></td>
                        <td><?= $mhs->kelompokDetNama ?></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td>
                          <h1>80</h1>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade show" id="jurnalReading" role="tabpanel" aria-labelledby="jurnal-reading">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">Tanggal</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Kelompok</th>
                      <th scope="col">Stase</th>
                      <th style="text-align:center" scope="col">Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mhs->logbookTanggal ?></td>
                        <td><?= $mhs->kelompokDetNim ?></td>
                        <td><?= $mhs->kelompokDetNama ?></td>
                        <td><?= $mhs->kelompokNama ?></td>
                        <td><?= $mhs->staseNama ?></td>
                        <td><button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#nilaiJurnalReading"><i class="fas fa-edit"></i></button></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade show" id="refarat" role="tabpanel" aria-labelledby="refarat">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">Tanggal</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Kelompok</th>
                      <th scope="col">Stase</th>
                      <th style="text-align:center" scope="col">Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mhs->logbookTanggal ?></td>
                        <td><?= $mhs->kelompokDetNim ?></td>
                        <td><?= $mhs->kelompokDetNama ?></td>
                        <td><?= $mhs->kelompokNama ?></td>
                        <td><?= $mhs->staseNama ?></td>
                        <td><button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#nilaiRefarat"><i class="fas fa-edit"></i></button></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade show" id="refleksiKasus" role="tabpanel" aria-labelledby="refleksi-kasus">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">Tanggal</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Kelompok</th>
                      <th scope="col">Stase</th>
                      <th style="text-align:center" scope="col">Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mhs->logbookTanggal ?></td>
                        <td><?= $mhs->kelompokDetNim ?></td>
                        <td><?= $mhs->kelompokDetNama ?></td>
                        <td><?= $mhs->kelompokNama ?></td>
                        <td><?= $mhs->staseNama ?></td>
                        <td><button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#nilaiRefleksiKasus"><i class="fas fa-edit"></i></button></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade show" id="midTest" role="tabpanel" aria-labelledby="mid-test">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">Tanggal</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Kelompok</th>
                      <th scope="col">Stase</th>
                      <th style="text-align:center" scope="col">Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mhs->logbookTanggal ?></td>
                        <td><?= $mhs->kelompokDetNim ?></td>
                        <td><?= $mhs->kelompokDetNama ?></td>
                        <td><?= $mhs->kelompokNama ?></td>
                        <td><?= $mhs->staseNama ?></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade show" id="followUp" role="tabpanel" aria-labelledby="follow-up">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Aspek Penilaian</th>
                      <th style="text-align:center" scope="col">Nilai</th>
                      <th style="text-align:center" scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td rowspan="2"><?= $no++ ?></td>
                        <td rowspan="2"><?= $mhs->kelompokDetNim ?></td>
                        <td rowspan="2"><?= $mhs->kelompokDetNama ?></td>
                        <td>Sistematika penulisan catatan medis (SOAP)</td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td rowspan="2">
                          <h1>80</h1>
                        </td>
                      </tr>
                      <tr>
                        <td>Pemahaman Dasar Pengetahuan Terkait Kasus</td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade show" id="postTest" role="tabpanel" aria-labelledby="post-test">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">Tanggal</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Kelompok</th>
                      <th scope="col">Stase</th>
                      <th style="text-align:center" scope="col">Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mhs->logbookTanggal ?></td>
                        <td><?= $mhs->kelompokDetNim ?></td>
                        <td><?= $mhs->kelompokDetNama ?></td>
                        <td><?= $mhs->kelompokNama ?></td>
                        <td><?= $mhs->staseNama ?></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
</section>
</div>

<!-- start modal jurnal reading  -->
<div class="modal fade" tabindex="-1" role="dialog" id="nilaiJurnalReading">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data <strong>Kegiatan</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="post">
        <?= csrf_field() ?>
        <div class="modal-body">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align:center" scope="col">No.</th>
                <th scope="col">Nama Komponen</th>
                <th style="text-align:center" scope="col">Nilai</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($penilainJurnalReading as $nilai) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $nilai->komponenNilaiNama ?></td>
                  <td><input class="form-control" type="text" name="" id=""></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal jurnal reading -->

<!-- start modal refarat  -->
<div class="modal fade" tabindex="-1" role="dialog" id="nilaiRefarat">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data <strong>Kegiatan</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="post">
        <?= csrf_field() ?>
        <div class="modal-body">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align:center" scope="col">No.</th>
                <th scope="col">Nama Komponen</th>
                <th style="text-align:center" scope="col">Nilai</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($penilainRefarat as $nilai) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $nilai->komponenNilaiNama ?></td>
                  <td><input class="form-control" type="text" name="" id=""></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal refarat-->

<!-- start modal refarat  -->
<div class="modal fade" tabindex="-1" role="dialog" id="nilaiRefleksiKasus">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data <strong>Kegiatan</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="post">
        <?= csrf_field() ?>
        <div class="modal-body">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align:center" scope="col">No.</th>
                <th scope="col">Nama Komponen</th>
                <th style="text-align:center" scope="col">Nilai</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($penilainRefleksiKasus as $nilai) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $nilai->komponenNilaiNama ?></td>
                  <td><input class="form-control" type="text" name="" id=""></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal refarat-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>