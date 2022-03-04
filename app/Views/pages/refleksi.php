<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $breadcrumb[1]; ?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <form action="/refleksi/proses" method="POST">
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
              <option value="">Pilih Mahasiswa</option>
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
          <?php if (count($refleksi) < 1) : ?>
            <div style="padding-top:10px; padding-bottom:10px">
              <center>
                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_5xuxt5wv.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
              </center>
            </div>
          <?php else : ?>
            <?php foreach ($refleksi as $reflek) : ?>
              <div class="card">
                <div class="card-body">
                  <table>
                    <tr>
                      <th>Nama/NPM Mahasiswa</th>
                      <td>: <?= $reflek->kelompokDetNama; ?>/<?= $reflek->kelompokDetNim; ?></td>
                    </tr>
                    <tr>
                      <th>Stase</th>
                      <td>: <?= $reflek->staseNama; ?></td>
                    </tr>
                  </table>
                  <br>
                  <p><strong>Keterangan Nilai:</strong><br>
                    <strong>1</strong> = Sangat Buruk; <strong>2</strong> = Buruk; <strong>3</strong> = Cukup; <strong>4</strong> = Baik; <strong>5</strong> = Sangat Baik
                  </p>
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="text-align:center" scope="col">No.</th>
                          <th scope="col">Kompetensi</th>
                          <th scope="col">Tujuan Pembelajaran</th>
                          <th scope="col">Nilai</th>
                          <th scope="col">Interpretasi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $gradeRefleksi = getRefleksi(['refleksi_grade.gradeRefleksiStaseId' => $reflek->staseId, 'refleksi_grade.gradeRefleksiNpm' => $reflek->kelompokDetNim])[0]->gradeRefleksiNilai ?>
                        <?php $grade = json_decode($gradeRefleksi) ?>
                        <?php $no = 1;
                        foreach ($kompetensi as $data) : ?>
                          <tr>
                            <td style="text-align:center"><?= $no++; ?></td>
                            <td scope="col"><?= $data->kompetensiNama; ?></td>
                            <td scope="col"><?= $data->tujuanPembelajaran; ?></td>
                            <?php foreach ($grade as $gr) : ?>
                              <?php if ($data->tujuanId == $gr->tujuan) : ?>
                                <td scope="col"><?= $gr->nilai; ?></td>
                              <?php endif ?>
                            <?php endforeach ?>
                            <td scope="col"></td>
                          </tr>
                        <?php endforeach; ?>
                        <tr>
                          <td style="text-align:center" colspan="3"><strong>Total</strong></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>