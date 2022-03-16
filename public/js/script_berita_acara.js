$(document).ready(function() {
    $('[name="staseBeritaAcara"]').change(function() {
        $.ajax({
            method: "POST",
            url: "/lapBeritaAcara/kegiatan",
            data: { staseBeritaAcara:  $('[name="staseBeritaAcara"]').val(),email:$('[name="sessionEmail"]').val()},
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                $('[name="kegiatanId"]').html(response.list_kegiatan);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $("#kegiatan").change(function() {
        $.ajax({
            type: "POST",
            url: "/lapBeritaAcara/kelompok",
            data: { stase: $("#stase").val(), kegiatan: $(this).val() ,email:$('[name="sessionEmail"]').val()},
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