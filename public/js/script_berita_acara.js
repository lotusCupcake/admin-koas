$(document).ready(function() {

    $('[name="dosenBeritaAcara"]').change(function() {
        // console.log($('[name="dosenBeritaAcara"]').val());
        $.ajax({
            method: "POST",
            url: "/lapBeritaAcara/stase",
            data: { dosenBeritaAcara: $('[name="dosenBeritaAcara"]').val() },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                // console.log(response);
                $('[name="staseBeritaAcara"]').html(response.list_stase);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('[name="staseBeritaAcara"]').change(function() {
        // console.log($('[name="sessionRole"]').val());
        $.ajax({
            method: "POST",
            url: "/lapBeritaAcara/kegiatan",
            data: { role: $('[name="sessionRole"]').val(), staseBeritaAcara: $('[name="staseBeritaAcara"]').val(), email: $('[name="sessionEmail"]').val(), dosenBeritaAcara: $('[name="dosenBeritaAcara"]').val() },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                // alert(response.list_kegiatan);
                $('[name="kegiatanId"]').html(response.list_kegiatan);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('[name="kegiatanId"]').change(function() {
        // console.log($('[name="kegiatanId"]').val());
        $.ajax({
            type: "POST",
            url: "/lapBeritaAcara/kelompok",
            data: { role: $('[name="sessionRole"]').val(), stase: $('[name="staseBeritaAcara"]').val(), kegiatan: $('[name="kegiatanId"]').val(), email: $('[name="sessionEmail"]').val(), dosenBeritaAcara: $('[name="dosenBeritaAcara"]').val() },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                $("#kelompok").html(response.list_kelompok);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});