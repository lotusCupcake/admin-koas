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
        <div class="card-body">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <?php if ($menuNilai == null) : ?>
            <div class="alert alert-primary alert-has-icon alert-dismissible show fade">
              <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                <div class="alert-title">Tips</div>
                Penilaian mahasiswa belum tersedia, coba kembali nanti ya!
              </div>
            </div>
            <center>
              <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_96fkffkf.json" background="transparent" speed="1" style="width: 100%; height: 600px;" loop autoplay></lottie-player>
            </center>
          <?php else : ?>
            <ul class="nav nav-tabs" id="myTab3" role="tablist">
              <?php $urut = 1;
              foreach ($menuNilai as $menu) : ?>
                <li class="nav-item">
                  <a class="nav-link <?= ($urut == 1) ? "active" : "" ?>" id="<?= $menu->penilaianSlug ?>" data-toggle="tab" href="#<?= $menu->penilaianHref ?>" role="tab" aria-controls="contact" aria-selected="<?= ($urut == 1) ? true : false ?>"><?= $menu->penilaianNamaSingkat ?></a>
                </li>
              <?php $urut++;
              endforeach ?>
            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
              <?php $urut = 1;
              foreach ($menuNilai as $menu) : ?>
                <div class="tab-pane fade show <?= ($urut == 1) ? "active" : "" ?>" id="<?= ($menu->penilaianHref) ?>" role="tabpanel" aria-labelledby="<?= ($menu->penilaianSlug) ?>">
                  <?= view('layout/templateAlert', ['msg' => ['info', "<strong>Failed ! </strong>" . $menu->penilaianNama]]); ?>
                  <div class="table table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="text-align:center" scope="col">No.</th>
                          <th scope="col">Nim</th>
                          <th scope="col">Nama Lengkap</th>
                          <th style="text-align:center" scope="col">Action</th>
                          <th style="text-align:center" scope="col">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach (eval('return $mhs' . $menu->penilaianTarget . ';') as $mhs) : ?>
                          <tr>
                            <td style="text-align:center"><?= $no++ ?></td>
                            <td><?= $mhs->kelompokDetNim ?></td>
                            <td><?= $mhs->kelompokDetNama ?></td>
                            <td style="text-align:center">
                              <button class="btn btn-icon icon-left btn-info btn-<?= $menu->penilaianTarget ?>" data-toggle="modal" data-target="#<?= ($menu->penilaianTarget) ?><?= $mhs->kelompokDetNim . $mhs->staseId; ?>"><i class="fas fa-marker"></i> Nilai</button>
                            </td>
                            <td style="text-align:center">
                              <?php if ($mhs->gradeApproveStatus == 0) : ?>
                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#setujuiPenilaian<?= $mhs->gradeId; ?>" <?php in_groups('Koordik') ? "" : "disabled" ?>>Belum Disetujui</button>
                              <?php else : ?>
                                <button class="btn btn-icon icon-left btn-success" <?php in_groups('Koordik') ? "" : "disabled" ?>>Disetujui</button>
                              <?php endif ?>
                            </td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              <?php $urut++;
              endforeach ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- start modal nilai  -->
<?php foreach ($menuNilai as $menu) : ?>
  <?php foreach (eval('return $mhs' . $menu->penilaianTarget . ';') as $mhs) :
    $file_header = @get_headers("https://mahasiswa.umsu.ac.id/FotoMhs/20" . substr($mhs->kelompokDetNim, 0, 2) . "/" . $mhs->kelompokDetNim . ".jpg"); ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="<?= $menu->penilaianTarget ?><?= $mhs->kelompokDetNim . $mhs->staseId ?>">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <form class="needs-validation" action="/penilaian/save" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="npm" value="<?= $mhs->kelompokDetNim ?>">
            <input type="hidden" name="staseId" value="<?= $mhs->staseId ?>">
            <input type="hidden" name="penilaianId" value="<?= $menu->penilaianId ?>">
            <div class="modal-header">
              <h5 class="modal-title">Penilaian <strong><?= $menu->penilaianNama; ?></strong></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" height="100" src="<?= (!$file_header || $file_header[0] == 'HTTP/1.1 404 Not Found') ?  base_url() . "/template/assets/img/avatar/avatar-1.png" : "https://mahasiswa.umsu.ac.id/FotoMhs/20" . substr($mhs->kelompokDetNim, 0, 2) . "/" . $mhs->kelompokDetNim . ".jpg"; ?>" class="rounded-circle profile-widget-picture">

                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">NPM</div>
                        <div class="profile-widget-item-value"><?= $mhs->kelompokDetNim ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">NAMA LENGKAP</div>
                        <div class="profile-widget-item-value"><?= $mhs->kelompokDetNama ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">KELOMPOK</div>
                        <div class="profile-widget-item-value"><?= $mhs->kelompokNama ?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"><?= $mhs->kelompokDetNim ?> <div class="text-muted d-inline font-weight-normal">
                        <div class="slash"></div> <?= $mhs->kelompokDetNama ?>
                      </div>
                    </div>
                    Penilaian kepada <?= $mhs->kelompokDetNama ?> untuk kegiatan <?= $menu->penilaianNama ?> Pada <?= $mhs->rumahSakitNama ?> - Stase <?= $mhs->staseNama ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-body">
              <?php if ($menu->penilaianType != 2) : $colspan = eval('return $nilai' . $menu->penilaianTarget . '[0]->komponenSkorMax;') - eval('return $nilai' . $menu->penilaianTarget . '[0]->komponenSkorMin;') + 1 ?>
                <div class="row">
                  <div class="col-md-12" style="text-align:center">
                    <h1 class='grade'>Nilai Huruf : E</h1>
                  </div>
                </div>
                <div class="table table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align:center" scope="col" rowspan="2">No.</th>
                        <th scope="col" rowspan="2">Aspek Penilaian</th>
                        <th style="text-align:center" scope="col" colspan="<?= $colspan ?>">Nilai</th>
                        <?php if (eval('return $nilai' . $menu->penilaianTarget . '[0]->komponenBobot;') != null) : ?>
                          <th style="text-align:center" rowspan="2">Bobot</th>
                        <?php endif ?>
                      </tr>
                      <tr>
                        <?php for ($i = eval('return $nilai' . $menu->penilaianTarget . '[0]->komponenSkorMin;'); $i <= eval('return $nilai' . $menu->penilaianTarget . '[0]->komponenSkorMax;'); $i++) : ?>
                          <th style="text-align:center"><?= $i; ?></th>
                        <?php endfor ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;
                      foreach (eval('return $nilai' . $menu->penilaianTarget . ';') as $komp) : ?>
                        <tr class="<?= $menu->penilaianTarget ?>">
                          <td style="text-align:center"><?= $no++ ?></td>
                          <td><?= $komp->komponenNama ?></td>
                          <?php for ($i = eval('return $nilai' . $menu->penilaianTarget . '[0]->komponenSkorMin;'); $i <= eval('return $nilai' . $menu->penilaianTarget . '[0]->komponenSkorMax;'); $i++) : ?>
                            <td>
                              <div class="selectgroup selectgroup-pills">
                                <label for="<?= $komp->komponenNama . $i; ?>"></label>
                                <label class="selectgroup-item">
                                  <input type="radio" name="<?= $komp->komponenId ?>" id="<?= $komp->komponenNama . $i; ?>" value="<?= $i ?>" class="selectgroup-input form-control r-<?= $menu->penilaianTarget ?> val-<?= $menu->penilaianTarget . ($no - 1) ?>" data-kompbobot="<?= $komp->komponenBobot ?>" data-skormax="<?= $komp->komponenSkorMax ?>" required>
                                  <span class="selectgroup-button selectgroup-button-icon"><?= $i ?></span>
                                </label>
                              </div>
                            </td>
                          <?php endfor ?>
                          <?php if (eval('return $nilai' . $menu->penilaianTarget . '[0]->komponenBobot;') != null) : ?>
                            <td style="text-align:center"><?= $komp->komponenBobot ?></td>
                          <?php endif ?>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                    <?php if ($menu->penilaianIsGlobalRating != 0) : ?>
                      <thead>
                        <tr>
                          <th style="text-align:center" scope="col" colspan="<?= 2 + $colspan ?>">Global Rating</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="text-align:center" scope="col" colspan="<?= 2 + $colspan ?>">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" name="gr" type="radio" id="inlineradio1" value="0" required>
                              <label class="form-check-label" for="inlineradio1">Tidak Kompeten</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" name="gr" type="radio" id="inlineradio2" value="1" required>
                              <label class="form-check-label" for="inlineradio2">Kompeten</label>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    <?php endif ?>
                  </table>
                </div>
              <?php else : ?>
                <div class="row">
                  <div class="col-md-12" style="text-align:center">
                    <h1 class='grade'>Nilai Huruf : E</h1>
                  </div>
                </div>
                <div class="table table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align:center" scope="col" rowspan="2">No.</th>
                        <th scope="col" rowspan="2">Aspek Penilaian</th>
                        <th scope="col">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;
                      foreach (eval('return $nilai' . $menu->penilaianTarget . ';') as $komp) : ?>
                        <tr class="<?= $menu->penilaianTarget ?>">
                          <td style="text-align:center"><?= $no++ ?></td>
                          <td><?= $komp->komponenNama ?></td>
                          <?php if (!$komp->komponenIsNumber) : ?>
                            <td style="padding: 10px;">
                              <textarea name="<?= $komp->komponenId ?>" id="" class="form-control" style="height: 100px;"></textarea>
                            </td>
                          <?php else : ?>
                            <td style="padding: 10px;">
                              <input type="number" min="<?= $komp->komponenSkorMin ?>" max="<?= $komp->komponenSkorMax ?>" placeholder="<?= $komp->komponenSkorMin . "-" . $komp->komponenSkorMax ?>" name="<?= $komp->komponenId ?>" id="" class="form-control r-<?= $menu->penilaianTarget ?> val-<?= $menu->penilaianTarget . ($no - 1) ?>" data-kompbobot="<?= $komp->komponenBobot ?>" data-skormax="<?= $komp->komponenSkorMax ?>">
                            </td>
                          <?php endif ?>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                    <!-- <thead>
                      <tr>
                        <th style=" text-align:center" scope="col" colspan="<? //= 2 + $colspan 
                                                                            ?>">Global Rating</th>
                        </tr>
                        </thead>
                    <tbody>
                      <tr>
                        <td style="text-align:center" scope="col" colspan="<? //= 2 + $colspan 
                                                                            ?>">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" name="gr" type="radio" id="inlineradio1" value="0" required>
                            <label class="form-check-label" for="inlineradio1">Tidak Kompeten</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" name="gr" type="radio" id="inlineradio2" value="1" required>
                            <label class="form-check-label" for="inlineradio2">Kompeten</label>
                          </div>
                        </td>
                      </tr>
                    </tbody> -->
                  </table>
                </div>
              <?php endif ?>
            </div>
            <div class=" modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach ?>
<?php endforeach ?>
<!-- end modal nilai -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>