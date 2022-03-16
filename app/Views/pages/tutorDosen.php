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
                    <h2 class="section-title">Articles</h2>
                    <p class="section-lead">This article component is based on card and flexbox.</p>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="../assets/img/news/img08.jpg">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="#">Excepteur sint occaecat cupidatat non proident</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. </p>
                                    <div class="article-cta">
                                        <a href="#" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="../assets/img/news/img04.jpg">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="#">Excepteur sint occaecat cupidatat non proident</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. </p>
                                    <div class="article-cta">
                                        <a href="#" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="../assets/img/news/img04.jpg">
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="#">Excepteur sint occaecat cupidatat non proident</a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. </p>
                                    <div class="article-cta">
                                        <a href="#" class="btn btn-primary">Read More</a>
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