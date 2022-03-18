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
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-form col-md-4">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Nama/NPM/Alasan" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
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
                                    <th scope="col">Tahun Akademik</th>
                                    <th scope="col">Nama/NPM Mahasiswa</th>
                                    <th scope="col">Tanggal Awal</th>
                                    <th scope="col">Tanggal Akhir</th>
                                    <th scope="col">Alasan</th>
                                    <th scope="col">Penundaan Di Hari</th>
                                    <th scope="col">Sisa Hari Dalam Jadwal</th>
                                    <th scope="col">Tanggal Aktif Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($jadwalSkip)) : ?>
                                    <?php
                                    $no = 1 + ($numberPage * ($currentPage - 1));
                                    foreach ($jadwalSkip as $row) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $row->jadwalTahunAkademik; ?></td>
                                            <td><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</td>
                                            <td><?= gmdate('d-m-Y', ($row->skipTanggalAwal / 1000)); ?></td>
                                            <td><?= gmdate('d-m-Y', ($row->skipTanggalAkhir / 1000)); ?></td>
                                            <td><?= $row->skipAlasan; ?></td>
                                            <td>Ke <?= $row->skipHariKe; ?></td>
                                            <td><?= $row->skipSisaHari; ?> Hari</td>
                                            <td><?= $row->skipTanggalAktifKembali == null ? 'Jadwal Belum Diaktifkan' : gmdate('d-m-Y', ($row->skipTanggalAktifKembali / 1000)); ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 9]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('jadwalSkip', 'pager') ?>
                    </div>
                </div>
            </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>