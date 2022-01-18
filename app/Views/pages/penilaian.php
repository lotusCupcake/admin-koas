<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Penilaian</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <div class="section-body">
      <div class="card">
        <!-- <div class="card-header">
          <h4>Bordered Tab</h4>
        </div> -->
        <div class="card-body">
          <ul class="nav nav-tabs" id="myTab2" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pre-test" data-toggle="tab" href="#pretest" role="tab" aria-controls="contact" aria-selected="true">Pretest</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tutorial-klinik" data-toggle="tab" href="#tutorialKlinik" role="tab" aria-controls="contact" aria-selected="false">Tutorial Klinik</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="jurnal-reading" data-toggle="tab" href="#jurnalReading" role="tab" aria-controls="contact" aria-selected="false">Jurnal Reading</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="refa-rat" data-toggle="tab" href="#refarat" role="tab" aria-controls="contact" aria-selected="false">Refarat</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="refleksi-kasus" data-toggle="tab" href="#refleksiKasus" role="tab" aria-controls="contact" aria-selected="false">Refleksi Kasus</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="mid-test" data-toggle="tab" href="#midTest" role="tab" aria-controls="contact" aria-selected="false">Mid Test</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="follow-up" data-toggle="tab" href="#followUp" role="tab" aria-controls="contact" aria-selected="false">Mini Cex/Follow Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="post-test" data-toggle="tab" href="#postTest" role="tab" aria-controls="contact" aria-selected="false">Post Test</a>
            </li>
          </ul>
          <div class="tab-content tab-bordered" id="myTab3Content">
            <div class="tab-pane fade show active" id="pretest" role="tabpanel" aria-labelledby="pre-test">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
            <div class="tab-pane fade" id="tutorialKlinik" role="tabpanel" aria-labelledby="tutorial-klinik">
              Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus. Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur, eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget scelerisque tellus pharetra a.
            </div>
            <div class="tab-pane fade" id="jurnalReading" role="tabpanel" aria-labelledby="jurnal-reading">
              Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus. Proin ligula massa, gravida in lacinia efficitur, hendrerit eget mauris. Pellentesque fermentum, sem interdum molestie finibus, nulla diam varius leo, nec varius lectus elit id dolor. Nam malesuada orci non ornare vulputate. Ut ut sollicitudin magna. Vestibulum eget ligula ut ipsum venenatis ultrices. Proin bibendum bibendum augue ut luctus.
            </div>
            <div class="tab-pane fade" id="refarat" role="tabpanel" aria-labelledby="refa-rat">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
            <div class="tab-pane fade" id="refleksiKasus" role="tabpanel" aria-labelledby="refleksi-kasus">
              Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus. Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur, eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget scelerisque tellus pharetra a.
            </div>
            <div class="tab-pane fade" id="refleksiKasus" role="tabpanel" aria-labelledby="refleksi-kasus">
              Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus. Proin ligula massa, gravida in lacinia efficitur, hendrerit eget mauris. Pellentesque fermentum, sem interdum molestie finibus, nulla diam varius leo, nec varius lectus elit id dolor. Nam malesuada orci non ornare vulputate. Ut ut sollicitudin magna. Vestibulum eget ligula ut ipsum venenatis ultrices. Proin bibendum bibendum augue ut luctus.
            </div>
            <div class="tab-pane fade" id="midTest" role="tabpanel" aria-labelledby="mid-test">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
            <div class="tab-pane fade" id="followUp" role="tabpanel" aria-labelledby="follow-up">
              Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus. Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur, eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget scelerisque tellus pharetra a.
            </div>
            <div class="tab-pane fade" id="postTest" role="tabpanel" aria-labelledby="post-test">
              Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus. Proin ligula massa, gravida in lacinia efficitur, hendrerit eget mauris. Pellentesque fermentum, sem interdum molestie finibus, nulla diam varius leo, nec varius lectus elit id dolor. Nam malesuada orci non ornare vulputate. Ut ut sollicitudin magna. Vestibulum eget ligula ut ipsum venenatis ultrices. Proin bibendum bibendum augue ut luctus.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>