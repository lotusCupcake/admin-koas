<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title; ?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <?php if (getUser(user()->id)->dopingSignature == null) : ?>
      <div class="section-body">
        <div class="card">
          <div class="card author-box card-primary">
            <div class="card-body">
              <div class="author-box-left">
                <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-1.png" class="rounded-circle author-box-picture">
                <div class="clearfix"></div>
                <a href="#!" class="btn btn-primary mt-3" data-toggle="modal" data-target="#signature">Signature</a>
              </div>
              <div class="author-box-details">
                <div class="author-box-name">
                  <h3 class="text-primary"><?= getUser(user()->id)->dopingNamaLengkap; ?></h3>
                </div>
                <div class="author-box-job"><?= getUser(user()->id)->rumahSakitShortname; ?> (<?= getUser(user()->id)->name; ?>) / <?= user()->email ?></div>
                <div class="author-box-description">
                  <section>
                    <div class="boxarea">
                      <div id="previewsign1" class="previewsign">
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php else : ?>
      <div class="section-body">
        <div class="row mt-4">
          <div class="col-12 col-md-6">
            <div class="card profile-widget">
              <div class="profile-widget-header">
                <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
                <div class="profile-widget-items">
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Rumah Sakit</div>
                    <div class="profile-widget-item-value"><?= getUser(user()->id)->rumahSakitShortname; ?></div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Role</div>
                    <div class="profile-widget-item-value"><?= getUser(user()->id)->name; ?></div>
                  </div>
                </div>
              </div>
              <div class="profile-widget-description">
                <div class="profile-widget-name text-primary"><?= getUser(user()->id)->dopingNamaLengkap; ?></div>
                <div class="row">
                  <div class="form-group col-md-6 col-12">
                    <label>Email</label>
                    <input type="text" class="form-control" value="<?= getUser(user()->id)->dopingEmail; ?>" readonly>
                  </div>
                  <div class="form-group col-md-6 col-12">
                    <label>Username</label>
                    <input type="text" class="form-control" value="<?= getUser(user()->id)->username; ?>" readonly>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-7 col-12">
                    <label>Alamat</label>
                    <input type="email" class="form-control" value="<?= getUser(user()->id)->dopingAlamat; ?>" readonly>
                  </div>
                  <div class="form-group col-md-5 col-12">
                    <label>Phone</label>
                    <input type="tel" class="form-control" value="<?= getUser(user()->id)->dopingNoHandphone; ?>" readonly>
                  </div>
                </div>
                <div class="row">
                  <div class=" form-group col-md-12 col-12">
                    <label>Reset password terakhir</label>
                    <p><?= (getUser(user()->id)->reset_at == null) ? 'Belum Pernah Direset' : 'getUser(user()->id)->reset_at'; ?></p>
                  </div>
                </div>
              </div>
              <div class="card-footer text-center">
                <a href="#!" class="btn btn-primary mt-3" data-toggle="modal" data-target="#ubahPassword">Ubah Password</a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <?php if (in_groups('Koordik')) : ?>
              <h2 class="section-title">Quick User Manual</h2>
              <p class="section-lead">
                Karna Kamu adalah <strong>Koordik</strong>, dibawah ini adalah hal wajib Kamu lakukan
              </p>
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Koordik</h4>
                </div>
                <div class="card-body">
                  <p>
                    Setelah proses koas berjalan, selanjutnya Kamu harus:
                  </p>
                  <ul>
                    <li>Memverifikasi follow up dan kegiatan mahasiswa (jika dosen). <a href="https://youtu.be/bzNf3nfWthc" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Melakukan penilaian kegiatan mahasiswa (jika dosen). <a href="https://youtu.be/UzC8XbIniq0" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Memverifikasi penilaian yang dibuat oleh dosen. <a href="https://youtu.be/WGoE1RG5w-k" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Membuat berita acara kegiatan (jika dosen). <a href="https://youtu.be/GCKTL7gDsXE" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Merekap Absensi Mahasiswa . <a href="https://youtu.be/Cxf6EOscrGY" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Melihat Evaluasi Mahasiswa Terhadap Dosen . <a href="https://youtu.be/ygEdpJlHEsc" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Melihat Refleksi Diri Mahasiswa . <a href="https://youtu.be/LPEMk0j47gg" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Merekap Nilai Mahasiswa . <a href="https://youtu.be/h8YtWH46iwg" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                  </ul>
                </div>
                <div class="modal-footer">
                  <a href="/tutor" type="button" class="btn btn-icon icon-left btn-primary"><i class="fas fa-chalkboard-teacher"></i>Tutorial Video Lengkap</a>
                </div>
              </div>
            <?php else : ?>
              <h2 class="section-title">Quick User Manual</h2>
              <p class="section-lead">
                Karna Kamu adalah <strong>Dosen</strong>, dibawah ini adalah hal wajib Kamu lakukan
              </p>
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Dosen</h4>
                </div>
                <div class="card-body">
                  <p>
                    Setelah proses koas berjalan, selanjutnya Kamu harus:
                  </p>
                  <ul>
                    <li>Memverifikasi follow up dan kegiatan mahasiswa. <a href="https://youtu.be/bzNf3nfWthc" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Melakukan penilaian kegiatan mahasiswa. <a href="https://youtu.be/UzC8XbIniq0" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Membuat berita acara kegiatan. <a href="https://youtu.be/GCKTL7gDsXE" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                    <li>Melihat Evaluasi Mahasiswa Terhadap Dosen. <a href="https://youtu.be/1hH_8AYUfh8" target="_blank" class="text-primary">klik disini untuk tutorial</a></li>
                  </ul>
                </div>
                <div class="modal-footer">
                  <a href="/tutor" type="button" class="btn btn-icon icon-left btn-primary"><i class="fas fa-chalkboard-teacher"></i>Tutorial Video Lengkap</a>
                </div>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </section>
</div>

<!-- start modal signature -->
<div class=" modal fade" tabindex="-1" role="dialog" id="signature">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Draw <strong>Signature</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-warning">
          <strong>Perhatian !!!</strong> Aktivitas ini hanya bisa dilakukan sekali, untuk menghindari pemalsuan dokumen, pastikan paraf anda sesuai sebelum di simpan
        </p>
        <input type="hidden" value="<?php echo rand(); ?>" id="rowno">
        <div class="signature-pad" id="signature-pad">
          <div class="m-signature-pad">
            <div class="m-signature-pad-body">
              <canvas width="450" height="250"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button id="clear" class="btn btn-danger">Clear</button>
        <button id="save2" data-action="save" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal signature -->

<!-- start modal ubah password -->
<div class=" modal fade" tabindex="-1" role="dialog" id="ubahPassword">
  <div class="modal-dialog" role="document">
    <form action="<?= route_to('forgot') ?>" method="post">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah <strong>Password</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= view('\App\Views\auth\_message_block') ?>
          <div class="form-group">
            <label>Email</label>
            <input name="email" aria-describedby="emailHelp" value="<?= getUser(user()->id)->dopingEmail; ?>" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>">
            <div class="invalid-feedback">
              <?= session('errors.email') ?>
            </div>
          </div>
        </div>
        <div class=" modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary"><?= lang('Auth.sendInstructions') ?></button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- end modal ubah password -->

<?= view('layout/templateFooter'); ?>


<?= $this->endSection(); ?>