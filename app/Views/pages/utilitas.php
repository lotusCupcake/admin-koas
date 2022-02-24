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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Announcement</h4>
                                    <p>Digunakan untuk menampilkan pengumuman di dalam aplikasi.</p>
                                    <a href="/announce" class="card-cta">Go Setting <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Notifikasi</h4>
                                    <p>Digunakan untuk menyiarkan notifikasi ke semua mahasiswa ataupun semua mahasiswa.</p>
                                    <a href="/notif" class="card-cta">Go Setting <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>