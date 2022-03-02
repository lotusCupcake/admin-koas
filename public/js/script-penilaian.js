$(document).ready(function () {
  var jml = 0;

  $('.icon-left.btn-success').click(function () {
    jml = 0;
    var getClass = this.className;
    getClass = getClass.split(' ');
    komp = getClass[4];
    komp = komp.split('-');
    jml = $('.' + komp[1]).length;
    console.log(jml);
    console.log(komp[1]);
    createEvent(komp[1]);

  });

  $('.icon-left.btn-info').click(function () {
    jml = 0;
    var getClass = this.className;
    getClass = getClass.split(' ');
    komp = getClass[4];
    komp = komp.split('-');
    jml = $('.' + komp[1]).length;
    console.log(jml);
    console.log(komp[1]);
    createEvent(komp[1]);
    if ($(this).data('keterangan') == 'edit') {
      loadNilai(komp[1])
    }
  });

  function loadNilai(komp) {
    if (komp == 'Pretest' || komp == 'Postest' || komp == 'KDinasKesehatan') {
      nilaiTextBoxt(komp);
    } else {
      nilaiRadio(komp);
    }
  }

  function nilaiTextBoxt(komp) {
    var total = 0;
    $skor = parseInt($('.r-' + komp).val());
    if ($skor > 100 || $skor < 0) {
      alert('Nilai yang anda input diluar range 0-100');
      $(this).val('');
      return;
    }

    for (let i = 1; i <= jml; i++) {
      var nilai = parseInt($('.val-' + komp + i).val());
      var bobot = parseInt($('.val-' + komp + i).data('kompbobot'));
      var skorMax = parseInt($('.val-' + komp + i).data('skormax'));

      (isNaN(nilai)) ? nilai = 0 : nilai = (nilai * bobot) / skorMax;
      total = total + nilai;
    }

    callGrade(total);
  }

  function nilaiRadio(komp) {
    var total = 0;

    for (let i = 1; i <= jml; i++) {
      var nilai = parseInt($('.val-' + komp + i + ':checked').val());
      var bobot = parseInt($('.val-' + komp + i + ':checked').data('kompbobot'));
      var skorMax = parseInt($('.val-' + komp + i + ':checked').data('skormax'));

      (isNaN(nilai)) ? nilai = 0 : nilai = (nilai * bobot) / skorMax;
      total = total + nilai;
    }

    callGrade(total);
  }

  function createEvent(komp) {
    if (komp == 'Pretest' || komp == 'Postest' || komp == 'KDinasKesehatan') {
      $("input[type=number].r-" + komp).keyup(function () {
        nilaiTextBoxt(komp);
      });
    } else {
      $('input[type=radio].r-' + komp).change(function () {
        nilaiRadio(komp);
      });
    }
  }


  function callGrade(total) {
    $.ajax({
      type: "POST",
      url: "/penilaian/konversi",
      data: {
        nilai: total
      },
      success: function (response) {
        console.log(response);
        $('.grade').html('Nilai Huruf : ' + response);
      }
    });
  }

});