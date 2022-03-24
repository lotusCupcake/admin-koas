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
            <select class="form-control" name="staseRefleksi">
              <option value="">Pilih Stase</option>
              <?php foreach ($dataStase as $row) : ?>
                <option value="<?= $row->staseId; ?>"><?= $row->staseNama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <select class="form-control" name="kelompokRefleksi">
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
          <?php if (!empty(session()->getFlashdata('danger'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', session()->getFlashdata('danger')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('staseRefleksi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('staseRefleksi')]]); ?>
          <?php endif; ?>
          <?php if ($validation->hasError('kelompokRefleksi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('kelompokRefleksi')]]); ?>
          <?php endif; ?>
          <?php if (count($refleksi) < 1) : ?>
            <div style="padding-top:10px; padding-bottom:10px">
              <center>
                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_5xuxt5wv.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
              </center>
            </div>
          <?php else : ?>
            <form action="/refleksi/cetak" method="POST">
              <?= csrf_field() ?>
              <input type="hidden" name="staseRefleksi" value="<?= $dataFilter[0]; ?>">
              <input type="hidden" name="kelompokRefleksi" value="<?= $dataFilter[1]; ?>">
              <div class="buttons">
                <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Export</button>
              </div>
            </form>
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
                          <th scope="col">Jumlah</th>
                          <th scope="col">Interpretasi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $gradeRefleksi = getRefleksi(['refleksi_grade.gradeRefleksiStaseId' => $reflek->staseId, 'refleksi_grade.gradeRefleksiNpm' => $reflek->kelompokDetNim])[0]->gradeRefleksiNilai ?>
                        <?php $grade = json_decode($gradeRefleksi) ?>
                        <?php $no = 1;
                        $total = 0;
                        $namakom = "";
                        foreach ($kompetensi as $data) : ?>
                          <tr>
                            <?php if ($namakom != $data->kompetensiNama) :  ?>
                              <td style="text-align:center" rowspan="<?= array_count_values($interpretasi)[$data->kompetensiNama] ?>"><?= $no++; ?></td>
                              <td scope="col" rowspan="<?= array_count_values($interpretasi)[$data->kompetensiNama] ?>"><?= $data->kompetensiNama; ?></td>
                            <?php endif; ?>
                            <td scope="col"><?= $data->tujuanPembelajaran; ?></td>
                            <?php foreach ($grade as $gr) : ?>
                              <?php if ($data->tujuanId == $gr->tujuan) : $total = $total + $gr->nilai ?>
                                <td style="text-align:center" scope="col"><?= $gr->nilai; ?></td>
                              <?php endif ?>
                            <?php endforeach ?>
                            <?php if ($namakom != $data->kompetensiNama) :  ?>
                              <td scope="col" style="text-align:center" rowspan="<?= array_count_values($interpretasi)[$data->kompetensiNama] ?>"><?= getSubtotalNilaiRefleksi(['gradeRefleksiNpm' => $reflek->kelompokDetNim, 'gradeRefleksiStaseId' => $reflek->staseId], $data->kompetensiNama)  ?></td>
                              <td scope="col" rowspan="<?= array_count_values($interpretasi)[$data->kompetensiNama] ?>">
                                <?php if (array_count_values($interpretasi)[$data->kompetensiNama] == 3) : ?>
                                  <strong>1-3</strong>= sangat buruk<br>
                                  <strong>4-6</strong>= buruk<br>
                                  <strong>7-9</strong>= cukup<br>
                                  <strong>10-12</strong>= baik<br>
                                  <strong>13-15</strong>= sangat baik
                                <?php elseif (array_count_values($interpretasi)[$data->kompetensiNama] == 4) : ?>
                                  <strong>1-4</strong>= sangat buruk<br>
                                  <strong>5-8</strong>= buruk<br>
                                  <strong>9-12</strong>= cukup<br>
                                  <strong>13-16</strong>= baik<br>
                                  <strong>17-20</strong>= sangat baik
                                <?php elseif (array_count_values($interpretasi)[$data->kompetensiNama] == 6) : ?>
                                  <strong>1-6</strong>= sangat buruk<br>
                                  <strong>7-12</strong>= buruk<br>
                                  <strong>13-18</strong>= cukup<br>
                                  <strong>19-24</strong>= baik<br>
                                  <strong>25-30</strong>= sangat baik
                                <?php else : ?>
                                  <strong>1-7</strong>= sangat buruk<br>
                                  <strong>8-14</strong>= buruk<br>
                                  <strong>15-12</strong>= cukup<br>
                                  <strong>22-28</strong>= baik<br>
                                  <strong>29-35</strong>= sangat baik
                                <?php endif; ?>
                              </td>
                            <?php $namakom = $data->kompetensiNama;
                            endif ?>
                          </tr>
                        <?php endforeach; ?>
                        <tr>
                          <td style="text-align:center" colspan="4"><strong>Total</strong></td>
                          <td style="text-align:center"><strong><?= $total; ?></td>
                          <td><strong>1-34</strong>= sangat buruk<br>
                            <strong>35-68</strong>= buruk<br>
                            <strong>69-102</strong>= cukup<br>
                            <strong>103-136</strong>= baik<br>
                            <strong>137-170 </strong>= sangat baik
                          </td>
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