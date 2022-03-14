<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class=" section">
    <div class="section-header">
      <h1>Selamat Datang di Aplikasi Dokter Muda UMSU</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <center>
          <lottie-player src=" https://assets9.lottiefiles.com/packages/lf20_shc5hxwh.json" background="transparent" speed="1" style="width: 100%; height: 500px;" loop autoplay></lottie-player>
        </center>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="announcementSuperadmin">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selamat Datang di<strong> Aplikasi Dr. Muda UMSU</strong></h5>

      </div>
      <div class="modal-body">
        <?= view('layout/templateAlertIcon', ['msg' => ['info', 'Pemberitahuan!', ' Role akun Kamu adalah <strong>' . getUserId(user()->id)->name . '</strong>']]); ?>
        <p>Berikut adalah hal yang wajib Kamu lakukan pertama kali menggunakan aplikasi ini:</p>
        <ul>
          <li>Mengisi data panduan untuk keperluan aplikasi mobile (jika belum)</li>
          <li>Mengisi data stase (jika belum)</li>
          <li>Mengisi data kegiatan (jika belum)</li>
          <li>Mengisi bobot nilai sesuai stase (jika belum)</li>
          <li>Mengisi data rumah sakit (jika belum)</li>
          <li>Mengisi data stase pada rumah sakit (jika belum)</li>
          <li>Membuat kelompok mahasiswa untuk penjadwalan (jika belum)</li>
          <li>Membuat jadwal kegiatan (jika belum)</li>
        </ul>
      </div>
      <form action="/home/savepopup" method="post">
        <input type="hidden" name="email" value="<?= user()->email ?>">
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Ingati nanti</button>
          <button type="submit" class="btn btn-primary">Baiklah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="announcementAdmin">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selamat Datang di<strong> Aplikasi Dr. Muda UMSU</strong></h5>
      </div>
      <div class="modal-body">
        <?= view('layout/templateAlertIcon', ['msg' => ['info', 'Pemberitahuan!', ' Role akun Kamu adalah <strong>' . getUserId(user()->id)->name . '</strong>']]); ?>
        <p>Berikut adalah hal yang wajib Kamu lakukan pertama kali menggunakan aplikasi ini:</p>
        <ul>
          <li>Mengisi data panduan untuk keperluan aplikasi mobile (jika belum)</li>
          <li>Mengisi data stase (jika belum)</li>
          <li>Mengisi data kegiatan (jika belum)</li>
          <li>Mengisi bobot nilai sesuai stase (jika belum)</li>
          <li>Mengisi data rumah sakit (jika belum)</li>
          <li>Mengisi data stase pada rumah sakit (jika belum)</li>
          <li>Membuat kelompok mahasiswa untuk penjadwalan (jika belum)</li>
          <li>Membuat jadwal kegiatan (jika belum)</li>
        </ul>
      </div>
      <form action="/home/savepopup" method="post">
        <input type="hidden" name="email" value="<?= user()->email ?>">
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Ingati nanti</button>
          <button type="submit" class="btn btn-primary">Baiklah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="announcementKoordik">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selamat Datang di<strong> Aplikasi Dr. Muda UMSU</strong></h5>

      </div>
      <div class="modal-body">
        <?= view('layout/templateAlertIcon', ['msg' => ['info', 'Pemberitahuan!', ' Role akun Kamu adalah <strong>' . getUserId(user()->id)->name . '</strong>']]); ?>
        <p>Berikut adalah hal yang wajib Kamu lakukan pertama kali menggunakan aplikasi ini:</p>
        <ul>
          <li>Membuat tanda tangan digital pada menu profile</li>
        </ul>
        <p>Setelah proses koas berjalan, selanjutnya Kamu harus:</p>
        <ul>
          <li>Memverifikasi follow up dan kegiatan mahasiswa (jika dosen)</li>
          <li>Menilai kegiatan mahasiswa (jika dosen)</li>
          <li>Memverifikasi penilaian yang dibuat oleh dosen</li>
          <li>Membuat berita acara kegiatan (jika dosen)</li>
        </ul>
      </div>
      <form action="/home/savepopup" method="post">
        <input type="hidden" name="email" value="<?= user()->email ?>">
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Ingati nanti</button>
          <button type="submit" class="btn btn-primary">Baiklah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="announcementDosen">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selamat Datang di<strong> Aplikasi Dr. Muda UMSU</strong></h5>

      </div>
      <div class="modal-body">
        <?= view('layout/templateAlertIcon', ['msg' => ['info', 'Pemberitahuan!', ' Role akun Kamu adalah <strong>' . getUserId(user()->id)->name . '</strong>']]); ?>
        <p>Berikut adalah hal yang wajib Kamu lakukan pertama kali menggunakan aplikasi ini:</p>
        <ul>
          <li>Membuat tanda tangan digital pada menu profile</li>
        </ul>
        <p>Setelah proses koas berjalan, selanjutnya Kamu harus:</p>
        <ul>
          <li>Memverifikasi follow up dan kegiatan mahasiswa</li>
          <li>Menilai kegiatan mahasiswa</li>
          <li>Membuat berita acara kegiatan</li>
        </ul>
      </div>
      <form action="/home/savepopup" method="post">
        <input type="hidden" name="email" value="<?= user()->email ?>">
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Ingati nanti</button>
          <button type="submit" class="btn btn-primary">Baiklah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="announcement">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selamat Datang di<strong> Aplikasi Dr. Muda UMSU</strong></h5>

      </div>
      <?= view('layout/templateAlertIcon', ['msg' => ['info', 'Pemberitahuan!', ' Role akun Kamu adalah <strong>' . getUserId(user()->id)->name . '</strong>']]); ?>
      <p>Silahkan hubungi administrator untuk mempromosikan akun Kamu</p>
      <form action="/home/savepopup" method="post">
        <input type="hidden" name="email" value="<?= user()->email ?>">
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Ingati nanti</button>
          <button type="submit" class="btn btn-primary">Baiklah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>