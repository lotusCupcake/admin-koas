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
                <a href="#"><?= getUser(user()->id)->dopingNamaLengkap; ?></a>
              </div>
              <div class="author-box-job"><?= getUser(user()->id)->rumahSakitShortname; ?> (<?= getUser(user()->id)->name; ?>) / <?= user()->email ?></div>
              <div class="author-box-description">
                <img class="img-responsive" src="" alt="signature">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class=" modal fade" tabindex="-1" role="dialog" id="signature">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Draw <strong>Signature</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#!" method="POST">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="col-md-12">
            <br />
            <div id="sig"></div>
            <br><br>
            <textarea id="signature" name="signed" style="display: none"></textarea>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button id="clear" class="btn btn-danger">Clear</button>
            <button type="submit" id="clear" class="btn btn-primary">Save changes</button>
          </div>
        </div>
    </div>
    </form>
  </div>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>