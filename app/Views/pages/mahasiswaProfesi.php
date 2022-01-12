<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Mahasiswa Profesi</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/home"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item"><a href="/mahasiswaProfesi"><?= $breadcrumb[1]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered display" id="example" style="width:100%">
              <thead>
                <tr>
                  <th style="text-align:center" scope="col">No.</th>
                  <th scope="col">NPM</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Email</th>
                  <th scope="col">No. Telp</th>
                  <th width="10%" scope="col">Kelas</th>
                  <th scope="col">Angkatan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($mahasiswaProfesi as $mahasiswa) : ?>
                  <tr>
                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                    <td><?= $mahasiswa->Nim; ?></td>
                    <td><?= $mahasiswa->Nama_Lengkap; ?></td>
                    <td><?= $mahasiswa->Email; ?></td>
                    <td><?= $mahasiswa->Phone; ?></td>
                    <td><?= $mahasiswa->Kelas; ?> <?= $mahasiswa->Waktu_Kuliah; ?></td>
                    <td><?= $mahasiswa->Angkatan; ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>