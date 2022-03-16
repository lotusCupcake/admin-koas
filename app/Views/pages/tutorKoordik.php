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
                <div class="breadcrumb-item"><a href="/tutor"><?= $breadcrumb[1]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <h2 class="section-title">Panduan Koordik</h2>
                    <p class="section-lead">Dibawah ini adalah kumpulan video panduan untuk koordik dalam menjalankan aplikasi.</p>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="<?= base_url() ?>/asset/tanda-tangan.webp">
                                    </div>
                                    <div class="article-title">
                                        <h2> <a href="https://youtu.be/B5aOIHbGth0" target="_blank">Membuat Tanda Tangan Digital</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Klik tombol dibawah untuk menonton video panduan cara membuat tanda tangan digital. </p>
                                    <div class="article-cta">
                                        <a href="https://youtu.be/B5aOIHbGth0" target="_blank" class="btn btn-primary">watch</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="<?= base_url() ?>/asset/verifikasi-penilaian.webp">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="https://youtu.be/WGoE1RG5w-k" target="_blank">Memverifikasi Penilaian Yang Dibuat Oleh Dosen</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Klik tombol dibawah untuk menonton video panduan cara memverifikasi penilaian dosen. </p>
                                    <div class="article-cta">
                                        <a href="https://youtu.be/WGoE1RG5w-k" target="_blank" class="btn btn-primary">watch</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="<?= base_url() ?>/asset/rekap-absensi.webp">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="#">Merekap Absensi Mahasiswa</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Klik tombol dibawah untuk menonton video panduan cara merekap absensi. </p>
                                    <div class="article-cta">
                                        <a href="#" class="btn btn-primary">watch</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="<?= base_url() ?>/asset/evaluasi-dosen.webp">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="#">Melihat Evaluasi Mahasiswa Terhadap Dosen</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Klik tombol dibawah untuk menonton video panduan cara melihat evaluasi mahasiswa terhaadap dosen. </p>
                                    <div class="article-cta">
                                        <a href="#" class="btn btn-primary">watch</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="<?= base_url() ?>/asset/refleksi-mahasiswa.webp">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="#">Melihat Refleksi Diri Mahasiswa</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Klik tombol dibawah untuk menonton video panduan cara melihat refleksi diri mahasiswa. </p>
                                    <div class="article-cta">
                                        <a href="#" class="btn btn-primary">watch</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="<?= base_url() ?>/asset/rekap-penilaian.webp">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="#">Merekap Nilai Mahasiswa</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Klik tombol dibawah untuk menonton video panduan cara merekap nilai mahasiswa. </p>
                                    <div class="article-cta">
                                        <a href="#" class="btn btn-primary">watch</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>