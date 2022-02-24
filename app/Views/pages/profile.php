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
          <div class="col-12 col-md-12">
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
                <div class="profile-widget-name text-primary"><?= getUser(user()->id)->dopingNamaLengkap; ?><div class="text-muted d-inline font-weight-normal">
                    <div class="slash"></div><?= getUser(user()->id)->dopingEmail; ?>
                    <div class="slash"></div><?= getUser(user()->id)->username; ?>
                  </div>
                </div>
                <table>
                  <tr>
                    <th>No. Handphone</th>
                    <td>: <?= getUser(user()->id)->dopingNoHandphone; ?></td>
                  <tr>
                    <th>Alamat</th>
                    <td>: <?= getUser(user()->id)->dopingAlamat; ?></td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td>: <?= (getUser(user()->id)->active = 1) ? "Aktif" : "Tidak Aktif"; ?></td>
                  </tr>
                  <tr>
                    <th>Reset Password Terakhir</th>
                    <td>: <?= (getUser(user()->id)->reset_at == null) ? "-" : getUser(user()->id)->reset_at; ?></td>
                  </tr>
                </table>
              </div>
              <div class="card-footer text-center">
                <a href="#!" class="btn btn-primary mt-3" data-toggle="modal" data-target="#ubahPassword">Ubah Password</a>
              </div>
            </div>
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