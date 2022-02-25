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
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/summernote/dist/summernote-bs4.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/components.css">

  <style type="text/css">
    /* .text-primary:hover {
      text-decoration: underline;
    } */

    .previewsign {
      border: 1px dashed #ccc;
      border-radius: 5px;
      color: #bbbabb;
      height: 250px;
      width: 100%;
      text-align: center;
      vertical-align: middle;
      top: 73px;
      right: 35px;
    }

    .m-signature-pad-body {
      border: 1px dashed #ccc;
      border-radius: 5px;
      color: #bbbabb;
      height: 100%;
      width: 100%;
      text-align: center;
      float: right;
      vertical-align: middle;
      top: 73px;
      margin-bottom: 20px;
    }

    .img {
      right: 0;
      position: absolute;
    }
  </style>
</head>

<body onload="announcement('<?= getUserId(user()->id)->name ?>','<?= getPopup(['email' => user()->email])[0]->email ?>')">
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
  <script src="<?= base_url() ?>/template/node_modules/summernote/dist/summernote-bs4.js"></script>



  <!-- Template JS File -->
  <script src="<?= base_url() ?>/template/assets/js/scripts.js"></script>
  <script src="<?= base_url() ?>/template/assets/js/custom.js"></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <!-- Page Specific JS File -->
  <script src="<?= base_url() ?>/template/assets/js/page/forms-advanced-forms.js"></script>
  <script src="<?= base_url() ?>/js/script.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>/js/signature-pad.js"></script>
  <script src="<?= base_url() ?>/template/assets/js/page/modules-datatables.js"></script>

  <!-- label dokumen -->
  <script>
    function announcement(role, $stat) {
      if (role == 'Superadmin' && $stat == '0') {
        $('#announcementSuperadmin').modal('show');
      } else if (role == 'Admin Prodi' && $stat == '0') {
        $('#announcementAdmin').modal('show');
      } else if (role == 'General User' && $stat == '0') {
        $('#announcement').modal('show');
      } else if (role == 'Dosen' && $stat == '0') {
        $('#announcementDosen').modal('show');
      } else if (role == 'Koordik' && $stat == '0') {
        $('#announcementKoordik').modal('show');
      }
    }

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
  <?php $uri = current_url(true); ?>
  <?php if ($uri->getSegment(1) == 'profile') : ?>
    <script src="<?= base_url() ?>/js/script-signature.js"></script>
  <?php endif ?>

  <?php if ($uri->getSegment(1) == 'penilaian') : ?>
    <script src="<?= base_url() ?>/js/script-penilaian.js"></script>
  <?php endif ?>

</body>

</html>