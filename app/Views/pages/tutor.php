<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Panduan Admin</h4>
                                    <p>Berupa kumpulan video tutorial untuk admin yang berkaitan dengan panduan penggunaan aplikasi .</p>
                                    <a href="/tutorAdmin" class="card-cta">Go Watching <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Panduan Koordik</h4>
                                    <p>Berupa kumpulan video tutorial untuk koordik rumah sakit yang berkaitan dengan panduan penggunaan aplikasi .</p>
                                    <a href="/tutorKoordik" class="card-cta">Go Watching <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Panduan Dosen</h4>
                                    <p>Berupa kumpulan video tutorial untuk dosen pembimbing yang berkaitan dengan panduan penggunaan aplikasi .</p>
                                    <a href="/tutorDosen" class="card-cta">Go Watching <i class="fas fa-chevron-right"></i></a>
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