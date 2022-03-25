// Load librari/plugin jquery nya 
$(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
    $('.timepicker').timepicker({
        minuteStep: 1,
        appendWidgetTo: 'body',
        showSeconds: true,
        showMeridian: false,
        defaultTime: false
    });

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

    $('[name="rumahSakitId"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
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
                // Sembunyikan loadingnya
                $('[name="staseId"]').html(response.list_stase_rumkit).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });


    // Proses Untuk Menampilkan Data Kelompok di Menu Add


    $('[name="staseId"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit

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
                // Sembunyikan loadingnya
                $('[name="kelompokId"]').html(response.list_kelompok).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    // Proses Untuk Menampilkan Data Stase di Menu Edit


    $('[name="rumahSakit"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
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
                // Sembunyikan loadingnya
                $('[name="stase"]').html(response.list_stase_rumkit).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    // Proses Untuk Menampilkan Data Kelompok di Menu Edit


    $('[name="stase"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
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
                // Sembunyikan loadingnya
                $('[name="kelompok"]').html(response.list_kelompok).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    // fungsi rekap absen dimulai
    // Proses Untuk Menampilkan Data Stase di Menu Rekap Absen

    $('[name="rumahSakitIdAbsen"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
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
                // Sembunyikan loadingnya
                $('[name="staseIdAbsen"]').html(response.list_stase_rumkit).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    // Proses Untuk Menampilkan Data Kelompok di Menu Rekap Absen

    $('[name="staseIdAbsen"]').change(function() { // Ketika user mengganti atau memilih data Rumah Sakit
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
                // Sembunyikan loadingnya
                $('[name="kelompokIdAbsen"]').html(response.list_kelompok).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    //menampilkan stase di evaluasi

    $('[name="rumahSakitEvaluasi"]').change(function() {
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
                $('[name="staseEvaluasi"]').html(response.list_stase_evaluasi);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan doping di evaluasi

    $('[name="staseEvaluasi"]').change(function() {
        $.ajax({
            type: "POST",
            url: "/evaluasi/evaluasiDoping",
            data: {
                dopingEvaluasiEmail: $('[name="sessionEmail"]').val(),
                role: $('[name="sessionRole"]').val(),
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
                $('[name="dopingEvaluasi"]').html(response.list_doping_evaluasi);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan kelompok di refleksi

    $('[name="staseRefleksi"]').change(function() {
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

                $('[name="kelompokRefleksi"]').html(response.list_kelompok_refleksi);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });


});