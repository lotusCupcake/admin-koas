<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title; ?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
        <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
      </div>
    </div>
    <?php if (getUser(user()->id)->dopingSignature == null) : ?>
      <div class="section-body">
        <div class="card">
          <div class="card author-box card-primary">
            <div class="card-body">
              <div class="author-box-left">
                <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-1.png" class="rounded-circle author-box-picture">
                <div class="clearfix"></div>
                <a href="#!" class="btn btn-primary mt-3" data-toggle="modal" data-target="#signature">Signature</a>
              </div>
              <div class="author-box-details">
                <div class="author-box-name">
                  <strong><span class="text-primary"><?= getUser(user()->id)->dopingNamaLengkap; ?></span></strong>
                </div>
                <div class="author-box-job"><?= getUser(user()->id)->rumahSakitShortname; ?> (<?= getUser(user()->id)->name; ?>) / <?= user()->email ?></div>
                <div class="author-box-description">
                  <section>
                    <div class="boxarea">
                      <div id="previewsign1" class="previewsign">
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </section>
</div>

<div class=" modal fade" tabindex="-1" role="dialog" id="signature">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Draw <strong>Signature</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= view('layout/templateAlert', ['msg' => ["warning", "<strong>Perhatian !!!</strong> Aktivitas ini hanya bisa dilakukan sekali, untuk menghindari pemalsuan dokumen, pastikan paraf anda sesuai sebelum di simpan"]]); ?>
        <input type="hidden" value="<?php echo rand(); ?>" id="rowno">
        <div class="signature-pad" id="signature-pad">
          <div class="m-signature-pad">
            <div class="m-signature-pad-body">
              <canvas width="450" height="250"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button id="clear" class="btn btn-danger">Clear</button>
        <button id="save2" data-action="save" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
      </div>
    </div>
  </div>
</div>

<script>
  var wrapper = document.getElementById("signature-pad"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

  clearButton = document.getElementById("clear");
  saveButton = document.getElementById("save2"),

    function resizeCanvas() {

      var ratio = window.devicePixelRatio || 1;
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext("2d").scale(ratio, ratio);
    }
  signaturePad = new SignaturePad(canvas);

  clearButton.addEventListener("click", function(event) {
    signaturePad.clear();
  });
  saveButton.addEventListener("click", function(event) {

    if (signaturePad.isEmpty()) {
      $('#myModal').modal('show');
    } else {

      $.ajax({
        type: "POST",
        url: "/profile/insert",
        data: {
          'image': signaturePad.toDataURL(),
          'rowno': $('#rowno').val()
        },
        success: function(datas1) {
          console.log(datas1);
          signaturePad.clear();
          $('.previewsign').html(datas1);
        }
      });
    }
  });
</script>
<?= view('layout/templateFooter'); ?>


<?= $this->endSection(); ?>