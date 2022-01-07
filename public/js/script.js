    $('.timepicker').timepicker({
      minuteStep: 1,
      appendWidgetTo: 'body',
      showSeconds: true,
      showMeridian: false,
      defaultTime: false
    });

// Load librari/plugin jquery nya 
    $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
      
      // Proses Untuk Menampilkan Data Stase
      $("#loading").hide();
      
      $('[name="rumahSakitId"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit

        $("#staseId").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya
        $.ajax({
          type: "POST", // Method pengiriman data bisa dengan GET atau POST
          url: "jadwalKegiatan/stase", // Isi dengan url/path file php yang dituju
          data: {
            rumahSakitId: $('[name="rumahSakitId"]').val()
          }, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
            if (e && e.overrideMimeType) {
              e.overrideMimeType("application/json;charset=UTF-8");
            }
          },
          success: function(response) { // Ketika proses pengiriman berhasil
            // console.log(response.list_stase_rumkit);
            $("#loading").hide(); // Sembunyikan loadingnya
            $('[name="staseId"]').html(response.list_stase_rumkit).show();
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
          }
        });
      });
    });

    // Load librari/plugin jquery nya 
    $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
      // Kita sembunyikan dulu untuk loadingnya
      $("#loading").hide();

      $('[name="staseId"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
        $("#kelompokId").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya

        $.ajax({
          type: "POST", // Method pengiriman data bisa dengan GET atau POST
          url: "jadwalKegiatan/kelompok", // Isi dengan url/path file php yang dituju
          data: {
            staseId: $('[name="staseId"]').val()
            
          }, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
            if (e && e.overrideMimeType) {
              e.overrideMimeType("application/json;charset=UTF-8");
            }
          },
          success: function(response) { // Ketika proses pengiriman berhasil
            console.log(response.list_kelompok);
            $("#loading").hide(); // Sembunyikan loadingnya
            $('[name="kelompokId"]').html(response.list_kelompok).show();
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
          }
        });
      });
    });