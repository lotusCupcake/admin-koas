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
        <form action="logout" method="POST">
          <div class="buttons">
            <a style="display: inline-block;  margin-left: 18px; margin-bottom: 20px;" href="/home" class="btn btn-icon btn-secondary"></i> Cancel</a>
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
      <a href="/home">Admin Dokter Muda</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    </div>
    <ul class="sidebar-menu">
      <?= $menus ?>
      <!-- <li class="menu-header">Dashboard</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
          <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
        </ul>
      </li>
      <li class="menu-header">Starter</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
          <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
          <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
        </ul>
      </li>
      <li class="active"><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Bootstrap</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="bootstrap-alert.html">Alert</a></li>
          <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
          <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
          <li><a class="nav-link" href="bootstrap-buttons.html">Buttons</a></li>
          <li><a class="nav-link" href="bootstrap-card.html">Card</a></li>
          <li><a class="nav-link" href="bootstrap-carousel.html">Carousel</a></li>
          <li><a class="nav-link" href="bootstrap-collapse.html">Collapse</a></li>
          <li><a class="nav-link" href="bootstrap-dropdown.html">Dropdown</a></li>
          <li><a class="nav-link" href="bootstrap-form.html">Form</a></li>
          <li><a class="nav-link" href="bootstrap-list-group.html">List Group</a></li>
          <li><a class="nav-link" href="bootstrap-media-object.html">Media Object</a></li>
          <li><a class="nav-link" href="bootstrap-modal.html">Modal</a></li>
          <li><a class="nav-link" href="bootstrap-nav.html">Nav</a></li>
          <li><a class="nav-link" href="bootstrap-navbar.html">Navbar</a></li>
          <li><a class="nav-link" href="bootstrap-pagination.html">Pagination</a></li>
          <li><a class="nav-link" href="bootstrap-popover.html">Popover</a></li>
          <li><a class="nav-link" href="bootstrap-progress.html">Progress</a></li>
          <li><a class="nav-link" href="bootstrap-table.html">Table</a></li>
          <li><a class="nav-link" href="bootstrap-tooltip.html">Tooltip</a></li>
          <li><a class="nav-link" href="bootstrap-typography.html">Typography</a></li>
        </ul>
      </li> -->
  </aside>
</div>