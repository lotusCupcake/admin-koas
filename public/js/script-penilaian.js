$(document).ready(function () {
  var jml = 0;
  
  $('.btn-LapKasus').click(function () {
    jml = $('.LapKasus').length;
  });

  $('input[type=radio].r-LapKasus').change(function () { 
    var total = 0;
    
    for (let i = 1; i <= jml; i++) {
      var nilai = parseInt($('.val-LapKasus' + i + ':checked').val());
      var bobot = parseInt($('.val-LapKasus' + i + ':checked').data('kompbobot'));
      var skorMax = parseInt($('.val-LapKasus' + i + ':checked').data('skormax'));
      
      (isNaN(nilai)) ? nilai = 0 : nilai = (nilai*bobot)/skorMax;
      total = total + nilai;
    }
    
      callGrade(total)
    
  });

  function callGrade(total) {
    $.ajax({
        type: "POST",
        url: "/penilaian/konversi",
        data: {
          nilai: total
        }, 
        success: function (response) {
          console.log(response);
          $('.grade').html('Nilai Huruf : '+response);
        }
      });
  }
  
});