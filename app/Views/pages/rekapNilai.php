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
              <?php foreach ($dataRumahSakit as $row) : ?>
                <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitShortname; ?></option>
              <?php endforeach; ?>
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
            <form action="/rekapNilai/cetak" method="POST">
              <?= csrf_field() ?>
              <input type="hidden" name="staseIdNilai" value="<?= $dataFilter[0]; ?>">
              <input type="hidden" name="kelompokIdNilai" value="<?= $dataFilter[1]; ?>">
              <div style="display: inline-block; margin-top: 4px; margin-left: 5px;" class="buttons">
                <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Print</button>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="text-align:center" scope="col">No.</th>
                    <th scope="col">Mahasiswa</th>
                    <?php foreach ($dataKomp as $komp) : ?>
                      <th scope="col"><?= getPenilaian(['penilaian.penilaianId' => $komp->penilaian])[0]->penilaianNamaSingkat ?></th>
                    <?php endforeach ?>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($dataMhs as $mahasiswa) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $mahasiswa->kelompokDetNama; ?> (<?= $mahasiswa->kelompokDetNim; ?>)</td>
                      <?php foreach ($dataKomp as $k) : ?>
                        <td><?= getNilai($k->penilaian, $mahasiswa->kelompokDetNim, $mahasiswa->staseId) ?>
                        </td>
                      <?php endforeach ?>
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

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>