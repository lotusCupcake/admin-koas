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

    clearButton.addEventListener("click", function(event) {
      signaturePad.clear();
    });
    saveButton.addEventListener("click", function(event) {

      if (signaturePad.isEmpty()) {
        $('#myModal').modal('show');
      } else {

        $.ajax({
          type: "POST",
          url: "/profile/insert",
          data: {
            'image': signaturePad.toDataURL(),
            'rowno': $('#rowno').val()
          },
          success: function(datas1) {
            console.log(datas1);
            signaturePad.clear();
            $('.previewsign').html(datas1);
          }
        });
      }
    });