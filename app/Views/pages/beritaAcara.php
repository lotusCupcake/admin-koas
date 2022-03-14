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
            <form action="/beritaAcara/cetak" method="POST" target="_blank">
                <?php csrf_field() ?>
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <select class="form-control" name="staseBeritaAcara">
                            <option value="" selected="selected">Pilih Stase</option>
                            <?php foreach ($stase as $row) : ?>
                                <option value="<?= $row->logbookRumkitDetId; ?>"><?= $row->staseNama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <select class="form-control" name="kegiatanId">
                            <option value="" selected="selected">Pilih Kegiatan</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <select class="form-control" name="kelompokBeritaAcara">
                            <option value="">Pilih Kelompok</option>
                        </select>
                    </div>
                    <div style="display: inline-block; margin-top: 4px; margin-left: 14px;" class="buttons">
                        <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-body">
                    <br>
                    <br>
                    <center>
                        <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_5xuxt5wv.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
                    </center>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>