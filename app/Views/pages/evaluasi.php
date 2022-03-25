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
      <form action="/evaluasi/proses" method="POST">
        <?php csrf_field() ?>
        <div class="form-row">
          <div class="form-group col-md-3">
            <select class="form-control" name="rumahSakitEvaluasi">
              <option value="">Pilih Rumah Sakit</option>
              <?php if (in_groups('Koordik')) : ?>
                <option value="<?= getRs()[0]->dopingRumkitId; ?>"><?= getRs()[0]->rumahSakitShortname; ?></option>
              <?php elseif (in_groups(['Superadmin', 'Admin Prodi', 'Dosen'])) : ?>
                <?php foreach ($dataRumahSakit as $row) : ?>
                  <option value="<?= $row->rumahSakitId; ?>"><?= $row->rumahSakitShortname; ?></option>
                <?php endforeach; ?>
              <?php endif ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <select class="form-control" name="staseEvaluasi">
              <option value="">Pilih Stase</option>
            </select>
          </div>
          <div class="form-group col-md-3">
            <select class="form-control" name="dopingEvaluasi">
              <option value="">Pilih Dosen Pembimbing</option>
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
          <?php if (!empty(session()->getFlashdata('danger'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', session()->getFlashdata('danger')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('rumahSakitEvaluasi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('rumahSakitEvaluasi')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('staseEvaluasi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('staseEvaluasi')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('dopingEvaluasi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('dopingEvaluasi')]]); ?>
          <?php endif; ?>
          <?php if (count($dataResult) < 1) : ?>
            <div style="padding-top:10px; padding-bottom:10px">
              <center>
                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_5xuxt5wv.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
              </center>
            </div>
          <?php else : ?>
            <form action="/evaluasi/cetak" method="POST">
              <?= csrf_field() ?>
              <div class="buttons">
                <input type="hidden" name="rumahSakitEvaluasi" value="<?= $dataFilter[0]; ?>">
                <input type="hidden" name="staseEvaluasi" value="<?= $dataFilter[1]; ?>">
                <input type="hidden" name="dopingEvaluasi" value="<?= $dataFilter[2]; ?>">
                <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Export</button>
              </div>
            </form>
            <?php foreach ($dataResult as $data) : ?>
              <div class="card">
                <div class="card-body">
                  <?php $keterangan = ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik']; ?>
                  <table>
                    <tr>
                      <th>Mahasiswa</th>
                      <td>: <?= $data->kelompokDetNama; ?> (<?= $data->kelompokDetNim; ?>)</td>
                    <tr>
                      <th>Dosen</th>
                      <td>: <?= $data->dopingNamaLengkap; ?></td>
                    </tr>
                    <tr>
                      <th>Stase</th>
                      <td>: <?= $data->staseNama; ?></td>
                    </tr>
                    <tr>
                      <th>Rumah Sakit</th>
                      <td>: <?= $data->rumahSakitShortname; ?></td>
                    </tr>
                  </table>
                  <br>
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="text-align:center" scope="col">No.</th>
                          <th scope="col">Aspek Nilai</th>
                          <?php foreach ($keterangan as $ket) : ?>
                            <th style="text-align:center" scope="col"><?= $ket; ?></th>
                          <?php endforeach ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $evaluasi = getEvaluasi(['evaluasi_grade.gradeEvaluasiStaseId' => $data->staseId, 'evaluasi_grade.gradeEvaluasiNpm' => $data->kelompokDetNim, 'evaluasi_grade.gradeEvaluasiDopingEmail' => $data->dopingEmail])[0]->gradeEvaluasiNilai ?>
                        <?php $no = 1;
                        foreach (json_decode($evaluasi) as $eval) : ?>
                          <tr>
                            <td style="text-align:center"><?= $no++ ?></td>
                            <td><?= getAspekEvaluasi(['evaluasiId' => $eval->aspek])[0]->evaluasiAspek ?></td>
                            <?php $nilai = 1;
                            foreach ($keterangan as $ket) : ?>
                              <td style="text-align:center" scope="col">
                                <?= ($nilai++ == $eval->nilai) ? "<span class='fas fa-check'></span>" : "" ?>
                              </td>
                            <?php endforeach ?>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif ?>
        </div>
      </div>
    </div>
  </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>