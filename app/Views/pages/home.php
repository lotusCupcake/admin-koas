<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Selamat Datang di Aplikasi Dokter Muda UMSU</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <center>
          <lottie-player src=" https://assets9.lottiefiles.com/packages/lf20_shc5hxwh.json" background="transparent" speed="1" style="width: 100%; height: 500px;" loop autoplay></lottie-player>
          <a href="#!" class="btn btn-primary" data-toggle="modal" data-target="#signature">Signature</a>
        </center>
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