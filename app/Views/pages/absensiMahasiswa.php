<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Absensi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="/absensi"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-form col-md-4">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Nama/NPM/Keterangan" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Mahasiswa</th>
                                    <th scope="col">Tanggal/Waktu</th>
                                    <th scope="col">Lokasi Absen</th>
                                    <th width="15%" style="text-align:center" scope="col">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($absensi)) : ?>
                                    <?php
                                    $no = 1 + ($numberPage * ($currentPage - 1));
                                    foreach ($absensi as $row) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                                            <td><?= gmdate('d-m-Y H:i:s', ($row->absensiTanggal / 1000)); ?></td>
                                            <td><?= $row->absensiLokasi; ?></td>
                                            <td style="text-align:center"><span class="btn <?= $row->absensiKeterangan == 'masuk' ? "btn-info btn-icon icon-left" : "btn-warning btn-icon icon-left"; ?>"><i class="<?= $row->absensiKeterangan == 'masuk' ? "fas fa-sign-in-alt" : "fas fa-sign-out-alt"; ?>"></i><?= $row->absensiKeterangan; ?></span></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 5]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('absensi', 'pager') ?>
                    </div>
                </div>
            </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>