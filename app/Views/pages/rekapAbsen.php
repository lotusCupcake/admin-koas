<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Rekap Absensi</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <form action="/rekapAbsen/proses" method="POST">
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
          <?php if ($validation->hasError('rumahSakitIdAbsen')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitIdAbsen')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('staseIdAbsen')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('staseIdAbsen')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('kelompokIdAbsen')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('kelompokIdAbsen')]]); ?>
          <?php endif; ?>
          <?php if (count($dataResult) < 1) : ?>
            <br>
            <br>
            <center>
              <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_5xuxt5wv.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
            </center>
            <br>
            <br>
          <?php else : ?>
            <form action="/rekapAbsen/cetak" method="POST">
              <?= csrf_field() ?>
              <input type="hidden" name="staseIdAbsen" value="<?= $dataFilter[0]; ?>">
              <input type="hidden" name="kelompokIdAbsen" value="<?= $dataFilter[1]; ?>">
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
                    <?php $no = 0;
                    $mn = $minDate;
                    $mx = $maxDate;
                    while (strtotime($mn) <= strtotime($mx)) : ?>
                      <th><?= date("d", strtotime($mn)) ?></th>
                    <?php $mn = date("Y-m-d", (int)strtotime("+1 day", strtotime($mn)));
                    endwhile ?>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $mn2 = $minDate;
                  $mx2 = $maxDate;
                  foreach ($mahasiswa as $mahasiswa) : ?>
                    <tr>
                      <td style="text-align:center" scope="row"><?= $no++; ?></td>
                      <td><?= $mahasiswa->kelompokDetNama; ?> (<?= $mahasiswa->kelompokDetNim; ?>)</td>
                      <?php while (strtotime($mn2) <= strtotime($mx2)) : ?>
                        <td class="bg-<?= jumlahPresensi($dataResult, $mahasiswa->kelompokDetNim, $mn2) ?>"></td>
                      <?php $mn2 = date("Y-m-d", (int)strtotime("+1 day", strtotime($mn2)));
                      endwhile ?>
                    </tr>
                  <?php $mn2 = $minDate;
                  endforeach ?>
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