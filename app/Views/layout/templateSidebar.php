<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    <?php if (in_groups(['Koordik', 'Dosen'])) : ?>
      <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
        <div class="dropdown-menu dropdown-list dropdown-menu-right">
          <div class="dropdown-header">Reminders
            <div class="float-right">
              <a href="#">Close</a>
            </div>
          </div>
          <div class="dropdown-list-content dropdown-list-icons">
            <a href="/followUp" class="dropdown-item dropdown-item-unread">
              <div class="dropdown-item-icon bg-primary text-white">
                <i class="fas fa-notes-medical"></i>
              </div>
              <div class="dropdown-item-desc">
                Jumlah Follow Up yang belum kamu verifikasi
                <div class="time text-primary"><?= jumlahFollowUp(); ?> Follow Up</div>
              </div>
            </a>
            <a href="/kegiatanMahasiswa" class="dropdown-item">
              <div class="dropdown-item-icon bg-info text-white">
                <i class="fas fa-book-medical"></i>
              </div>
              <div class="dropdown-item-desc">
                Jumlah Kegiatan yang belum kamu verifikasi
                <div class="time text-primary"><?= jumlahKegiatan(); ?> Kegiatan</div>
              </div>
            </a>
            <a href="/penilaian" class="dropdown-item">
              <div class="dropdown-item-icon bg-primary text-white">
                <i class="fas fa-book-medical"></i>
              </div>
              <div class="dropdown-item-desc">
                Jumlah Kegiatan yang belum kamu Nilai
                <div class="time text-primary"><?= count(jumlahKegiatanNilai()); ?> Kegiatan</div>
              </div>
            </a>
            <?php if (in_groups('Koordik')) :
            ?>
              <a href="/penilaian" class="dropdown-item">
                <div class="dropdown-item-icon bg-info text-white">
                  <i class="fas fa-marker"></i>
                </div>
                <div class="dropdown-item-desc">
                  Jumlah Penilaian yang belum kamu verifikasi
                  <div class="time text-primary"><?= count(getPenilaianRs()); ?> Penilaian</div>
                </div>
              </a>
            <?php endif;
            ?>
            <a href="/penilaian" class="dropdown-item">
              <div class="dropdown-item-icon bg-<?= (in_groups('Koordik')) ? "primary" : "info" ?> text-white">
                <i class="fas fa-marker"></i>
              </div>
              <div class="dropdown-item-desc">
                Jumlah Penilaian kamu yang sudah di verifikasi
                <div class="time text-primary"><?= count(getPenilaianDosen()); ?> Penilaian</div>
              </div>
            </a>
          </div>
        </div>
      </li>
    <?php endif; ?>
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, <?= user()->username; ?></div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title"></div>
        <form action="/logout" method="POST">
          <div class="buttons">
            <?php if (in_groups(['Koordik', 'Dosen'])) : ?>
              <a style="display: inline-block;  margin-left: 18px; width:80%;" href="/profile" class="btn btn-icon btn-primary"></i> Profile</a>
            <?php endif; ?>
            <a style="display: inline-block;  margin-left: 18px; margin-bottom: 20px;" href="/home" class="btn btn-icon btn-secondary"></i> Close</a>
            <button type="submit" style="display: inline-block; margin-bottom: 20px;" class="btn btn-icon icon-left btn-danger"><i class="fas fa-sign-out-alt"></i> logout</button>
          </div>
        </form>
      </div>
    </li>
  </ul>
</nav>
<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="/home">Dokter Muda</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    </div>
    <ul class="sidebar-menu">
      <?= $menus ?>
  </aside>
</div>