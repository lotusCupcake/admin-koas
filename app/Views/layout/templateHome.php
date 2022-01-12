<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title . " | " . $appName; ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/@fortawesome/fontawesome-free/css/all.css">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/selectric/public/selectric.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/components.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/dataTables.bootstrap4.min.css">
  <style>
    a:hover {
      background-color: goldenrod;
    }
  </style>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">

      <?= $this->renderSection('content'); ?>

    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="<?= base_url() ?>/template/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/popper.js/dist/popper.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/moment/min/moment.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
  <script src="<?= base_url() ?>/template/assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="<?= base_url() ?>/template/node_modules/select2/dist/js/select2.full.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/selectric/public/jquery.selectric.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

  <!-- Template JS File -->
  <script src="<?= base_url() ?>/template/assets/js/scripts.js"></script>
  <script src="<?= base_url() ?>/template/assets/js/custom.js"></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <!-- Page Specific JS File -->
  <script src="<?= base_url() ?>/template/assets/js/page/forms-advanced-forms.js"></script>
  <script src="<?= base_url() ?>/js/script.js"></script>

  <!-- Data table plugin-->
  <script src="<?= base_url() ?>/template/assets/js/plugins/main.js"></script>
  <script src="<?= base_url() ?>/template/assets/js/plugins/jquery.dataTables.min.js"></script>
  <!-- <script src="<? //= base_url() 
                    ?>/template/assets/js/plugins/dataTables.bootstrap.min.js"></script> -->

  <!-- label dokumen -->
  <script>
    $(document).ready(function() {
      var table = $('#example').removeAttr('width').DataTable({
        scrollCollapse: true,
        paging: false,
        columnDefs: [{
            width: 350,
            targets: 2
          },
          {
            width: 350,
            targets: 3
          }
        ],
        fixedColumns: true
      });
    });

    function labelDokumen() {
      const dokumen = document.querySelector('#customFile');
      const dokumenLabel = document.querySelector('.custom-file-label');

      documentLabel.textContent = customFile.files[0].name;

      const fileDokumen = new FileReader();
      fileDokumen.readAsDataURL(customFile.files[0]);

      fileDokumen.onload = function(e) {
        dokumenLabel.src = e.target.result;
      }
    }
  </script>
</body>

</html>