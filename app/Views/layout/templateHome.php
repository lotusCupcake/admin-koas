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
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/selectric/public/selectric.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/components.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/signature.css">
  <style>
    .text-primary:hover {
      text-decoration: underline;
    }

    label {
      display: block;
      padding: 5px;
      position: relative;
      padding-left: 20px;
    }

    label input {
      display: none;
    }

    label span {
      border: 1px solid #ccc;
      width: 25px;
      height: 25px;
      position: absolute;
      overflow: hidden;
      line-height: 1;
      text-align: center;
      border-radius: 100%;
      font-size: 10pt;
      top: 25%;
      left: 25%;
      display: grid;
      align-items: center;
    }

    input:checked+span {
      background: #acb5f6;
      border-color: #acb5f6;
    }

    .kbw-signature {
      width: 100%;
      height: 100%;
    }

    #sig canvas {
      width: 100% !important;
      height: auto;
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="<?= base_url() ?>/template/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/moment/min/moment.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
  <script src="<?= base_url() ?>/template/assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="<?= base_url() ?>/template/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/select2/dist/js/select2.full.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/selectric/public/jquery.selectric.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/cleave.js/dist/cleave.min.js"></script>
  <script src="<?= base_url() ?>/template/node_modules/cleave.js/dist/addons/cleave-phone.us.js"></script>


  <!-- Template JS File -->
  <script src="<?= base_url() ?>/template/assets/js/scripts.js"></script>
  <script src="<?= base_url() ?>/template/assets/js/custom.js"></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <!-- Page Specific JS File -->
  <script src="<?= base_url() ?>/template/assets/js/page/forms-advanced-forms.js"></script>
  <script src="<?= base_url() ?>/js/script.js"></script>
  <script src="<?= base_url() ?>/template/assets/js/page/modules-datatables.js"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

  <script type="text/javascript" src="<?= base_url() ?>/js/signature.js"></script>

  <script type="text/javascript">
    var sig = $('#sig').signature({
      syncField: '#signature',
      syncFormat: 'PNG'
    });
    $('#clear').click(function(e) {
      e.preventDefault();
      sig.signature('clear');
      $("#signature").val('');
    });
  </script>

  <!-- label dokumen -->
  <script>
    function labelDokumen() {
      const dokumen = document.querySelector('#customFile');
      const dokumenLabel = document.querySelector('.custom-file-label');

      dokumenLabel.textContent = dokumen.files[0].name;
    }

    function labelDokumenEdit(id) {
      const dokumen = document.querySelector('#customFile' + id);
      const dokumenLabel = document.querySelector('.custom-file-label' + id);

      dokumenLabel.textContent = dokumen.files[0].name;
    }
  </script>

</body>

</html>