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
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', session()->getFlashdata('success')]]); ?>
          <?php endif; ?>
          <ul class="nav nav-tabs" id="myTab3" role="tablist">
            <?php foreach ($menuNilai as $menu) : ?>
              <li class="nav-item">
                <a class="nav-link <?= $menu->penilaianStatus ?>" id="<?= $menu->penilaianSlug ?>" data-toggle="tab" href="#<?= $menu->penilaianHref ?>" role="tab" aria-controls="contact" aria-selected="<?= ($menu->penilaianStatus) ? true : false ?>"><?= $menu->penilaianNamaSingkat ?></a>
              </li>
            <?php endforeach ?>
          </ul>
          <div class="tab-content tab-bordered" id="myTab3Content">
            <?php foreach ($menuNilai as $menu) : ?>
              <div class="tab-pane fade show <?= ($menu->penilaianStatus) ?>" id="<?= ($menu->penilaianHref) ?>" role="tabpanel" aria-labelledby="<?= ($menu->penilaianSlug) ?>">
                <?= view('layout/templateAlert', ['msg' => ['info', "<strong>Failed ! </strong>" . $menu->penilaianNama]]); ?>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">No.</th>
                      <th scope="col">Nim</th>
                      <th scope="col">Nama Lengkap</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mhs->kelompokDetNim ?></td>
                        <td><?= $mhs->kelompokDetNama ?></td>
                        <td>
                          <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#<?= ($menu->penilaianTarget) ?><?= $mhs->kelompokDetNim . $mhs->staseId; ?>"><i class="fas fa-marker"></i> Nilai</button>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
</section>
</div>

<!-- start modal laporan kasus  -->
<?php foreach ($menuNilai as $menu) : ?>
  <?php foreach ($mahasiswa as $mhs) :
    $file_header = @get_headers("https://mahasiswa.umsu.ac.id/FotoMhs/20" . substr($mhs->kelompokDetNim, 0, 2) . "/" . $mhs->kelompokDetNim . ".jpg"); ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="<?= $menu->penilaianTarget ?><?= $mhs->kelompokDetNim . $mhs->staseId ?>">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <form action="/penilaian/save" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="npm" value="<?= $mhs->kelompokDetNim ?>">
            <input type="hidden" name="rumkitDetId" value="<?= $mhs->rumkitDetId ?>">
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
              <?php if ($menu->penilaianType != 2) : $colspan = eval('return $' . $menu->penilaianTarget . '[0]->komponenSkorMax;') - eval('return $' . $menu->penilaianTarget . '[0]->komponenSkorMin;') + 1 ?>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col" rowspan="2">No.</th>
                      <th scope="col" rowspan="2">Aspek Penilaian</th>
                      <th scope="col" colspan="<?= $colspan ?>">Nilai</th>
                      <?php if (eval('return $' . $menu->penilaianTarget . '[0]->komponenBobot;') != null) : ?>
                        <th rowspan="2">Bobot</th>
                      <?php endif ?>
                    </tr>
                    <tr>
                      <?php for ($i = eval('return $' . $menu->penilaianTarget . '[0]->komponenSkorMin;'); $i <= eval('return $' . $menu->penilaianTarget . '[0]->komponenSkorMax;'); $i++) : ?>
                        <th><?= $i; ?></th>
                      <?php endfor ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach (eval('return $' . $menu->penilaianTarget . ';') as $komp) : (ceil(eval('return $' . $menu->penilaianTarget . '[0]->komponenSkorMax;')) > 3) ? $half = 1.5 : $half = 2; ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $komp->komponenNama ?></td>
                        <?php for ($i = eval('return $' . $menu->penilaianTarget . '[0]->komponenSkorMin;'); $i <= eval('return $' . $menu->penilaianTarget . '[0]->komponenSkorMax;'); $i++) : ?>
                          <td><input type="radio" id="<?= $komp->komponenNama . $i; ?>" name="<?= $komp->komponenId ?>" value="<?= $i ?>" <?= (ceil(eval('return $' . $menu->penilaianTarget . '[0]->komponenSkorMax;') / $half) == $i) ? "checked" : "" ?>></td>
                        <?php endfor ?>
                        <?php if (eval('return $' . $menu->penilaianTarget . '[0]->komponenBobot;') != null) : ?>
                          <td><?= $komp->komponenBobot ?></td>
                        <?php endif ?>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              <?php else : ?>
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
                    foreach (eval('return $' . $menu->penilaianTarget . ';') as $komp) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $komp->komponenNama ?></td>
                        <?php if (!$komp->komponenIsNumber) : ?>
                          <td style="padding: 10px;">
                            <textarea name="<?= $komp->komponenId ?>" id="" class="form-control" style="height: 100px;"></textarea>
                          </td>
                        <?php else : ?>
                          <td style="padding: 10px;">
                            <input type="number" placeholder="<?= $komp->komponenSkorMin . "-" . $komp->komponenSkorMax ?>" name="<?= $komp->komponenId ?>" id="" class="form-control">
                          </td>
                        <?php endif ?>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
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
<!-- end modal laporan kasus -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>