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
                <div class="breadcrumb-item"><a href="/lapBeritaAcara"><?= $breadcrumb[1]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <form action="/lapBeritaAcara/load" method="GET">
                <?php csrf_field() ?>
                <div class="form-row">

                    <?php if (in_groups('Koordik')) : ?>
                        <div class="form-group col-md-2">
                            <select class="form-control" name="dosenBeritaAcara" id="stase">
                                <option value="" selected="selected">Pilih Dosen Pembimbing</option>
                                <?php foreach ($dosen as $row) : ?>
                                    <option value="<?= $row->dopingEmail; ?>"><?= $row->dopingNamaLengkap; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <select class="form-control" name="staseBeritaAcara" id="stase">
                                <option value="" selected="selected">Pilih Stase</option>
                            </select>
                        </div>
                    <?php else : ?>
                        <div class="form-group col-md-2">
                            <select class="form-control" name="staseBeritaAcara" id="stase">
                                <option value="" selected="selected">Pilih Stase</option>
                                <?php foreach ($stase as $row) : ?>
                                    <option value="<?= $row->logbookRumkitDetId; ?>"><?= $row->staseNama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="form-group col-md-2">
                        <select class="form-control" name="kegiatanId" id="kegiatan">
                            <option value="" selected="selected">Pilih Kegiatan</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <select class="form-control" name="kelompokBeritaAcara" id="kelompok">
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
                    <?php if (!empty(session()->getFlashdata('danger'))) : ?>
                        <?= view('layout/templateAlert', ['msg' => ['danger', session()->getFlashdata('danger')]]); ?>
                    <?php endif; ?>
                    <?php if ($beritaAcara == null) : ?>
                        <div style="padding-top:10px; padding-bottom:10px">
                            <center>
                                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_5xuxt5wv.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
                            </center>
                        </div>
                    <?php else : ?>
                        <?php if (in_groups('Koordik')) : ?>
                            <div class="buttons">
                                <button type="button" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#cetak"><i class="fas fa-print"></i> Export</button>
                            </div>
                        <?php endif ?>
                        <div class="card">
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <th width="100px">Jenis Kegiatan</th>
                                        <td>:</td>
                                        <td><?= $beritaAcara[0]->kegiatanNama; ?></td>
                                    </tr>
                                </table>
                                <br>
                                <table>
                                    <tr>
                                        <td width="100px">Topik/Judul</td>
                                        <td>:</td>
                                        <td><?= $beritaAcara[0]->logbookJudulDeskripsi; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hari/Tanggal</td>
                                        <td>:</td>
                                        <td><?= date('D / d-m-Y', $beritaAcara[0]->logbookTanggal / 1000); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Waktu</td>
                                        <td>:</td>
                                        <td><?= date('H:i:s', $beritaAcara[0]->logbookTanggal / 1000); ?> WIB</td>
                                    </tr>
                                    <tr>
                                        <td>Tempat</td>
                                        <td>:</td>
                                        <td><?= $beritaAcara[0]->rumahSakitShortname; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Department</td>
                                        <td>:</td>
                                        <td><?= $beritaAcara[0]->staseNama; ?></td>
                                    </tr>
                                </table>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="5%" style="text-align:center" scope="col">No.</th>
                                                <th scope="col">NPM</th>
                                                <th scope="col">Nama Mahasiswa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($dataMhs as $mhs) : ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $no++;  ?></td>
                                                    <td><?= $mhs->kelompokDetNim; ?></td>
                                                    <td><?= $mhs->kelompokDetNama; ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal cetak  -->
<div class="modal fade" tabindex="-1" role="dialog" id="cetak">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export <strong>Berita Acara Kegiatan</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah kamu benar ingin export berita acara kegiatan <strong><?= ($beritaAcara == null) ? "" : $beritaAcara[0]->kegiatanNama; ?></strong> dengan topik <strong><?= ($beritaAcara == null) ? "" : $beritaAcara[0]->logbookJudulDeskripsi; ?></strong>?</p>
            </div>
            <form action="/lapBeritaAcara/cetak" method="post" target="_blank">
                <?= csrf_field(); ?>
                <input type="hidden" name="staseBeritaAcara" value="<?= isset($_GET['staseBeritaAcara']) ? $_GET['staseBeritaAcara'] : "" ?>">
                <input type="hidden" name="kegiatanId" value="<?= isset($_GET['kegiatanId']) ? $_GET['kegiatanId'] : "" ?>">
                <input type="hidden" name="kelompokBeritaAcara" value="<?= isset($_GET['kelompokBeritaAcara']) ? $_GET['kelompokBeritaAcara'] : "" ?>">
                <input type="hidden" name="dosenBeritaAcara" value="<?= isset($_GET['dosenBeritaAcara']) ? $_GET['dosenBeritaAcara'] : "" ?>">
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal cetak -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>