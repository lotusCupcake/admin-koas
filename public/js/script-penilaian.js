$(document).ready(function () {
  var jml = 0;
  
  $('.icon-left.btn-info').click(function () {
    jml = $('.LapKasus').length;
    var getClass = this.className;
    getClass = getClass.split(' ');
    komp = getClass[4];
    komp = komp.split('-');
    // console.log(komp[1]);
    createEvent(komp[1]);
  });

  function createEvent(komp) {
    $('input[type=radio].r-'+komp).change(function () { 
      var total = 0;
      
      for (let i = 1; i <= jml; i++) {
        var nilai = parseInt($('.val-'+komp + i + ':checked').val());
        var bobot = parseInt($('.val-'+komp + i + ':checked').data('kompbobot'));
        var skorMax = parseInt($('.val-'+komp+ i + ':checked').data('skormax'));
        
        (isNaN(nilai)) ? nilai = 0 : nilai = (nilai*bobot)/skorMax;
        total = total + nilai;
      }
      
        callGrade(total)
      
    });
  }
  

  function callGrade(total) {
    $.ajax({
        type: "POST",
        url: "/penilaian/konversi",
        data: {
          nilai: total
        }, 
        success: function (response) {
          // console.log(response);
          $('.grade').html('Nilai Huruf : '+response);
        }
      });
  }
  
});