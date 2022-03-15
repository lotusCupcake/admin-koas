$(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
    // Kita sembunyikan dulu untuk loadingnya
    $("#stase").change(function() {
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "/beritaAcara/kegiatan", // Isi dengan url/path file php yang dituju
            data: { stase: $("#stase").val() }, // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#kegiatan").html(response.list_kegiatan).show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });


});