$(document).ready(function() {
    $("#stase").change(function() {
        $.ajax({
            type: "POST",
            url: "/beritaAcara/kegiatan",
            data: { stase: $("#stase").val() },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                $("#kegiatan").html(response.list_kegiatan).show();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});