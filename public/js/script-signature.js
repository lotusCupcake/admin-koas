var wrapper = document.getElementById("signature-pad"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

clearButton = document.getElementById("clear");
saveButton = document.getElementById("save2"),

    function resizeCanvas() {

        var ratio = window.devicePixelRatio || 1;
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }
signaturePad = new SignaturePad(canvas);

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});
saveButton.addEventListener("click", function (event) {

    if (signaturePad.isEmpty()) {
        $('#signature').modal('show');
    } else {
        var id = $('[name="sessionId"]').val();
        $.ajax({
            type: "POST",
            url: "/profile/insert",
            data: {
                'image': signaturePad.toDataURL(),
                'rowno': $('#rowno').val(),
                'id': id
            },
            success: function (datas1) {
                console.log(datas1);
                $('#signature').modal('hide');
                signaturePad.clear();
                $('.previewsign').html(datas1);
            }
        });
    }
});