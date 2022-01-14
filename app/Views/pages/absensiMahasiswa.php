<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Absensi</h1>
            <div class="section-header-breadcrumb">
                <!-- <div class="breadcrumb-item"><a href="/home"><? //= $breadcrumb[0]; 
                                                                    ?></a></div>
                <div class="breadcrumb-item"><a href="/absensi"><? //= $breadcrumb[1]; 
                                                                ?></a></div>
                <div class="breadcrumb-item active"><? //= $breadcrumb[2]; 
                                                    ?></div> -->
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-form">
                        <form action="" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="keyword">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <?php echo session()->getFlashdata('success'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($validation->hasError('kelompokDetNama')) : ?>
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <strong>Failed ! </strong><?= $validation->getError('kelompokDetNama'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Mahasiswa</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Lokasi Absen</th>
                                    <th style="text-align:center" scope="col">Keterangan</th>
                                    <th width="15%" style="text-align:center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($absensi)) : ?>
                                    <?php
                                    $no = 1 + (5 * ($currentPage - 1));
                                    foreach ($absensi as $row) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <!-- <td><? //= $row->kelompokDetNama; 
                                                        ?> ( <? //= $row->absensiNim; 
                                                                ?> )</td> -->
                                            <td><?= $row->absensiNim; ?></td>
                                            <td><?= $row->absensiTanggal; ?></td>
                                            <td><?= $row->absensiLokasi; ?></td>
                                            <td><?= $row->absensiKeterangan; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editDataAbsensi<?= $row->absensiId; ?>"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapusDataAbsensi<?= $row->absensiId; ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" align="center">Data Tidak Ditemukan</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('absensi', 'absen_pager') ?>
                    </div>
                </div>
            </div>
    </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambahDataKegiatan">
    <div class="modal-dialog" role="document">
        <form action="/dataKegiatan" method="POST">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data <strong>Kegiatan</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input name="kegiatanNama" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="control-label">Status Kegiatan</div>
                        <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                            <input type="checkbox" name="kegiatanStatus" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>
                        <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Tersedia/Tidak Tersedia)</span>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal edit  -->
<?php foreach ($absensi as $edit) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editDataAbsensi<?= $edit->absensiId; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data <strong>Kegiatan</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/dataKegiatan/<?= $edit->absensiId; ?>/edit" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kegiatan</label>
                            <input name="kegiatanNama" type="text" class="form-control" value="<?= $edit->absensiNim; ?>">
                        </div>
                        <!-- <div class="form-group">
                            <div class="control-label">Status Kegiatan</div>
                            <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                                <input type="checkbox" name="kegiatanStatus" <? //= ($edit->kegiatanStatus == 1) ? "checked" : ""; 
                                                                                ?> value="<? // = $edit->kegiatanStatus; 
                                                                                            ?>" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                            <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Tersedia/Tidak Tersedia)</span>
                        </div>
                    </div> -->
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($absensi as $delete) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapusDataKegiatan<?= $delete->absensiId; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data <strong>Kegiatan</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin menghapus data kegiatan <strong><?= $delete->absensiNim; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/dataKegiatan/<?= $delete->absensiId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal hapus -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>