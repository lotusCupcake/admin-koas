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
                                    <th style="text-align:center" scope="col" rowspan="2">No.</th>
                                    <th scope="col" rowspan="2">Tahun Akademik</th>
                                    <th scope="col" rowspan="2">Nama/NPM Mahasiswa</th>
                                    <th style="text-align:center" scope="col" colspan="4">Jadwal Yang Ditunda</th>
                                    <th scope="col" rowspan="2" style="text-align:center">Status Penundaan</th>
                                </tr>
                                <tr>
                                    <th scope="col">Tanggal Mulai/Akhir</th>
                                    <th scope="col">Jam Operasional</th>
                                    <th scope="col">Rumah Sakit</th>
                                    <th scope="col">Stase</th>
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
                                            <td><a href="#!"><span data-toggle="modal" data-target="#detail<?= $row->skipId; ?>"><?= $row->kelompokDetNama; ?> (<?= $row->kelompokDetNim; ?>)</span></a></td>
                                            <td><?= date('d-m-Y', ($row->jadwalTanggalMulai / 1000)); ?> s/d <?= date('d-m-Y', ($row->jadwalTanggalSelesai / 1000)); ?></td>
                                            <td><?= $row->jadwalJamMasuk; ?> - <?= $row->jadwalJamKeluar; ?></td>
                                            <td><?= $row->rumahSakitShortname; ?></td>
                                            <td><?= $row->staseNama; ?></td>
                                            <td style="text-align:center"><span class="badge <?= $row->skipTanggalAktifKembali == null ? "badge-danger" : "badge-success"; ?>"><?= $row->skipTanggalAktifKembali == null ? "Belum Aktif" : "Sudah Aktif"; ?></span></td>
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

<!-- start modal data skip -->
<?php foreach ($jadwalSkip as $detail) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="detail<?= $detail->skipId; ?>">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data <strong>Penundaan Jadwal <?= $detail->kelompokDetNama; ?> (<?= $detail->kelompokDetNim; ?>)</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
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
                                <tr>
                                    <td><?= $detail->kelompokDetNama; ?> (<?= $detail->kelompokDetNim; ?>)</td>
                                    <td><?= date('d-m-Y', ($detail->skipTanggalAwal / 1000)); ?></td>
                                    <td><?= date('d-m-Y', ($detail->skipTanggalAkhir / 1000)); ?></td>
                                    <td><?= $detail->skipAlasan; ?></td>
                                    <td>Ke <?= $detail->skipHariKe; ?></td>
                                    <td><?= $detail->skipSisaHari; ?> Hari</td>
                                    <td><?= $detail->skipTanggalAktifKembali == null ? 'Jadwal Belum Diaktifkan' : date('d-m-Y', ($detail->skipTanggalAktifKembali / 1000)); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal data skip -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>