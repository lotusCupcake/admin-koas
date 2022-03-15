$('.timepicker').timepicker({
    minuteStep: 1,
    appendWidgetTo: 'body',
    showSeconds: true,
    showMeridian: false,
    defaultTime: false
});

// Load librari/plugin jquery nya 
$(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)

    $.each($(".select2.penerima"), function() {
        // console.log(JSON.parse($(this).data('penerima')));
        // alert(JSON.parse($(this).attr('penerima')).map(String));
        $(this).select2({ multiple: true, });
        $(this).val(JSON.parse($(this).attr('penerima')).map(String)).trigger('change');

    });

    $('.rencana').change(function() {
        if ($(this).is(':checked')) {
            $('.mahasiswa').show();
        } else {
            $('.mahasiswa').hide();
        }
    });

    // Proses Untuk Menampilkan Data Stase di Menu Add
    $("#loading").hide();
    $('[name="rumahSakitId"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit

        $("#staseId").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/jadwalKegiatan/stase", // Isi dengan url/path file php yang dituju
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


    // Proses Untuk Menampilkan Data Kelompok di Menu Add
    $("#loading").hide();

    $('[name="staseId"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
        $("#kelompokId").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/jadwalKegiatan/kelompok", // Isi dengan url/path file php yang dituju
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

    // Proses Untuk Menampilkan Data Stase di Menu Edit
    $("#loading").hide();

    $('[name="rumahSakit"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit

        $("#stase").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/jadwalKegiatan/stase", // Isi dengan url/path file php yang dituju
            data: {
                rumahSakitId: $('[name="rumahSakit"]').val()
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
                $('[name="stase"]').html(response.list_stase_rumkit).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    // Proses Untuk Menampilkan Data Kelompok di Menu Edit
    $("#loading").hide();

    $('[name="stase"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
        $("#kelompok").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya

        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/jadwalKegiatan/kelompok", // Isi dengan url/path file php yang dituju
            data: {
                staseId: $('[name="stase"]').val()

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
                $('[name="kelompok"]').html(response.list_kelompok).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    // fungsi rekap absen dimulai
    // Proses Untuk Menampilkan Data Stase di Menu Rekap Absen
    $("#loading").hide();
    $('[name="rumahSakitIdAbsen"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
        $("#staseIdAbsen").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya
        console.log("rs dipilih");
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/rekapAbsen/rekapAbsenStase", // Isi dengan url/path file php yang dituju
            data: {
                rumahSakitId: $('[name="rumahSakitIdAbsen"]').val()
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
                $('[name="staseIdAbsen"]').html(response.list_stase_rumkit).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    // Proses Untuk Menampilkan Data Kelompok di Menu Rekap Absen
    $("#loading").hide();
    $('[name="staseIdAbsen"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
        $("#kelompokIdAbsen").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya

        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/rekapAbsen/rekapAbsenKelompok", // Isi dengan url/path file php yang dituju
            data: {
                staseId: $('[name="staseIdAbsen"]').val()
            }, // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) { // Ketika proses pengiriman berhasil
                // console.log(response.list_kelompok);
                $("#loading").hide(); // Sembunyikan loadingnya
                $('[name="kelompokIdAbsen"]').html(response.list_kelompok).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    // Proses Untuk Menampilkan Data Kegiatan di Menu Berita Acara
    $("#loading").hide();
    $('[name="staseBeritaAcara"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
        $("#kegiatanId").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya
        console.log('stase dipilih');
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/beritaAcara/kegiatan", // Isi dengan url/path file php yang dituju
            data: {
                staseBeritaAcara: $('[name="staseBeritaAcara"]').val()
            }, // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) { // Ketika proses pengiriman berhasil
                // console.log(response.list_kelompok);
                $("#loading").hide(); // Sembunyikan loadingnya
                $('[name="kegiatanId"]').html(response.list_kegiatan_beritaAcara).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });

    });

    // Proses Untuk Menampilkan Data Kelompok di Menu Berita Acara
    $("#loading").hide();
    $('[name="kegiatanId"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
        $("#kelompokBeritaAcara").hide(); // Sembunyikan dulu combobox Stase nya
        $("#loading").show(); // Tampilkan loadingnya

        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/beritaAcara/kelompok", // Isi dengan url/path file php yang dituju
            data: {
                staseBeritaAcara: $('[name="staseBeritaAcara"]').val(),
                kegiatanId: $('[name="kegiatanId"]').val()
            }, // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) { // Ketika proses pengiriman berhasil
                // console.log(response.list_kelompok);
                $("#loading").hide(); // Sembunyikan loadingnya
                $('[name="kelompokBeritaAcara"]').html(response.list_kelompok_beritaAcara).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    //menampilkan stase di evaluasi
    $("#loading").hide();
    $('[name="rumahSakitEvaluasi"]').change(function() {
        $("#staseEvaluasi").hide();
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: "/evaluasi/evaluasiStase",
            data: {
                rumahSakitEvaluasi: $('[name="rumahSakitEvaluasi"]').val()
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                $("#loading").hide();
                $('[name="staseEvaluasi"]').html(response.list_stase_evaluasi).show();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan doping di evaluasi
    $("#loading").hide();
    $('[name="staseEvaluasi"]').change(function() {
        $("#dopingEvaluasi").hide();
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: "/evaluasi/evaluasiDoping",
            data: {
                staseEvaluasi: $('[name="staseEvaluasi"]').val(),
                rumahSakitEvaluasi: $('[name="rumahSakitEvaluasi"]').val()
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                $("#loading").hide();
                $('[name="dopingEvaluasi"]').html(response.list_doping_evaluasi).show();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan kelompok di refleksi
    $("#loading").hide();
    $('[name="staseRefleksi"]').change(function() {
        $("#kelompokRefleksi").hide();
        $("#loading").show();
        $.ajax({
            type: "POST",
            url: "/refleksi/refleksiKelompok",
            data: {
                staseRefleksi: $('[name="staseRefleksi"]').val(),
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                $("#loading").hide();
                $('[name="kelompokRefleksi"]').html(response.list_kelompok_refleksi).show();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });


});