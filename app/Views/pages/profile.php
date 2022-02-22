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
              <a href="#" class="btn btn-primary mt-3 follow-btn" data-follow-action="alert('follow clicked');" data-unfollow-action="alert('unfollow clicked');">Follow</a>
            </div>
            <div class="author-box-details">
              <div class="author-box-name">
                <a href="#">Hasan Basri</a>
              </div>
              <div class="author-box-job">Web Developer</div>
              <div class="author-box-description">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  consequat.</p>
              </div>
              <img class="img-responsive" src="" alt="signature">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>