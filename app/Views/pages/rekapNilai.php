<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Rekap Nilai</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <form action="/rekapNilai/proses" method="POST">
        <?php csrf_field() ?>
        <div class="form-row">
          <div class="form-group col-md-3">
            <select class="form-control" name="rumahSakitIdAbsen">
              <option value="" selected="selected">Pilih Rumah Sakit</option>
              <?php if (in_groups('Koordik')) : ?>
                <option value="<?= getRs()[0]->dopingRumkitId; ?>"><?= getRs()[0]->rumahSakitShortname; ?></option>
              <?php elseif (in_groups(['Superadmin', 'Admin Prodi'])) : ?>
                <?php foreach ($dataRumahSakit as $row) : ?>
                  <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitShortname; ?></option>
                <?php endforeach; ?>
              <?php endif ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <select class="form-control" name="staseIdAbsen">
              <option value="">Pilih Stase</option>
            </select>
          </div>
          <div class="form-group col-md-3">
            <select class="form-control" name="kelompokIdAbsen">
              <option value="">Pilih Kelompok</option>
            </select>
          </div>
          <div style="display: inline-block; margin-top: 4px; margin-left: 5px;" class="buttons">
            <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-search"></i> Cari</button>
          </div>
        </div>
      </form>
      <div class="card">
        <div class="card-body">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('staseNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('staseNama')]]); ?>
          <?php endif; ?>
          <?php if (count($dataMhs) < 1) : ?>
            <div style="padding-top:10px; padding-bottom:10px">
              <center>
                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_5xuxt5wv.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
              </center>
            </div>
          <?php else : ?>
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="text-align:center" scope="col">No.</th>
                    <th scope="col">Mahasiswa</th>
                    <?php foreach ($dataKomp as $komp) : ?>
                      <th scope="col"><?= getPenilaian($komp->penilaian)[0]->penilaianNamaSingkat ?></th>
                    <?php endforeach ?>
                    <th style="text-align:center">Action</th>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($dataMhs as $mahasiswa) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $mahasiswa->kelompokDetNama; ?> (<?= $mahasiswa->kelompokDetNim; ?>)</td>
                      <?php foreach ($dataKomp as $k) : ?>
                        <td style="text-align:center"><?= getNilai(json_decode($k->penilaian), $mahasiswa->kelompokDetNim, $mahasiswa->staseId) ?></td>
                      <?php endforeach ?>
                      <td style="text-align:center">
                        <input type="hidden" name="staseIdNilai" value="<?= $dataFilter[0]; ?>">
                        <input type="hidden" name="npm" value="<?= $mahasiswa->kelompokDetNim; ?>">
                        <button class="btn btn-icon btn-primary" data-toggle="modal" data-target="#detailNilai<?= $mahasiswa->kelompokDetNim; ?>"><i class="fas fa-print"></i> Export</button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- start modal detail nilai -->
<?php foreach ($dataMhs as $detail) : ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="detailNilai<?= $detail->kelompokDetNim; ?>">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nilai Akhir<strong> </strong></h5>
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
                  <th scope="col">Jenis Kegiatan</th>
                  <th scope="col">Nilai Akhir</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                $nilaiAkhir = 0;
                foreach ($dataKomp as $komp) : ?>
                  <?php $nilaiAkhir += getNilai(json_decode($komp->penilaian), $detail->kelompokDetNim, $detail->staseId); ?>
                  <tr>
                    <td style="text-align:center"><?= $no++; ?></td>
                    <td><?= getPenilaian($komp->penilaian)[0]->penilaianNamaSingkat ?></td>
                    <td><?= getNilai(json_decode($komp->penilaian), $detail->kelompokDetNim, $detail->staseId) ?></td>
                  </tr>
                <?php endforeach ?>

              </tbody>
              <thead>
                <tr>
                  <th colspan="2" style="text-align:center">Total Nilai</th>
                  <th><?= $nilaiAkhir ?> / <?= getKonversi($nilaiAkhir) ?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align:center"><?= $no++; ?></td>
                  <td><?= "Attitude/" . getPenilaian("[\"12\"]")[0]->penilaianNamaSingkat ?></td>
                  <td>
                    <strong>
                      <?php if (getNilaiGr(12, $detail->kelompokDetNim, $detail->staseId)[0] < 1) : ?>
                        <del>Sufficient</del>/Unsufficient
                      <?php else : ?>
                        Sufficient/<del>Unsufficient</del>
                      <?php endif ?>
                    </strong>
                  </td>
                </tr>
              </tbody>
              <thead>
                <tr>
                  <th colspan="3" style="text-align:center">Sanksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="3" style="text-align:center"><?= getNilaiGr(12, $detail->kelompokDetNim, $detail->staseId)[1] ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <form action="/rekapNilai/<?= $dataFilter[0]; ?>/cetak" method="post">
          <?= csrf_field(); ?>
          <input type="hidden" name="nim" value="<?= $detail->kelompokDetNim ?>">
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Export</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end modal detail nilai -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>