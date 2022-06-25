$(document).ready(function() {
    var jml = 0;
    var myUrl = window.location.href;
    var base_url = myUrl.split('?')[0];

    $('.icon-left.btn-success').click(function() {
        jml = 0;
        var getClass = this.className;
        getClass = getClass.split(' ');
        komp = getClass[4];
        komp = komp.split('-');
        komjum = getClass[5];
        komjum = komjum.split('-');
        jml = $('.' + komjum[1]).length;

        createEvent(komjum[1]);

    });

    $('.icon-left.btn-info').click(function() {
        jml = 0;
        var getClass = this.className;
        getClass = getClass.split(' ');
        komp = getClass[4];
        komp = komp.split('-');
        komjum = getClass[5];
        komjum = komjum.split('-');
        jml = $('.' + komjum[1]).length;

        createEvent(komjum[1]);
        if ($(this).data('keterangan') == 'edit') {
            loadNilai(komjum[1])
        }
    });

    $('.tabPenilaian').click(function() {
        console.log($(this).data('id'));
        addQSParm('penilaian', $(this).data('id'));
        window.location.replace(myUrl);
    });

    function addQSParm(name, value) {
        var re = new RegExp("([?&]" + name + "=)[^&]+", "");

        function add(sep) {
            myUrl += sep + name + "=" + encodeURIComponent(value);
        }

        function change(nama, value) {
            var forMaintenance = new URLSearchParams(window.location.search);
            $urlke = 1;
            if (value == "") {
                forMaintenance.delete(nama);
            }

            for (const [k, v] of forMaintenance) {
                if (nama == k && v == value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(v);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(v);
                    }
                } else if (nama == k && v != value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(value);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(value);
                    }
                } else if (nama != k && v != value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(v);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(v);
                    }
                }
                $urlke++;
            }

            myUrl = base_url;
        }


        if (myUrl.indexOf("?") === -1) {
            add("?");
        } else {
            if (re.test(myUrl)) {
                change(name, value);
            } else {
                add("&");
            }
        }

    }

    function loadNilai(komp) {
        if (komp.split('_')[0] == 'Pretest' || komp.split('_')[0] == 'Postest' || komp.split('_')[0] == 'KDinasKesehatan') {
            nilaiTextBoxt(komp);
        } else {
            nilaiRadio(komp);
        }
    }

    function nilaiTextBoxt(komp) {
        console.log(komp);
        var total = 0;
        skor = parseInt($('.r-' + komp).val());
        if (skor > 100 || skor < 0) {
            alert('Nilai yang anda input diluar range 0-100');
            $(this).val('');
            return;
        }

        for (let i = 1; i <= jml; i++) {
            var nilai = parseInt($('.val-' + komp + i).val());
            var bobot = parseInt($('.val-' + komp + i).data('kompbobot'));
            var skorMax = parseInt($('.val-' + komp + i).data('skormax'));

            (isNaN(nilai)) ? nilai = 0: nilai = (nilai * bobot) / skorMax;
            total = total + nilai;
        }
        // console.log(nilai, bobot, skorMax);
        callGrade(total);
    }

    function nilaiRadio(komp) {

        var total = 0;

        for (let i = 1; i <= jml; i++) {
            var nilai = parseInt($('.val-' + komp + i + ':checked').val()); //3
            var bobot = parseInt($('.val-' + komp + i + ':checked').data('kompbobot')); // 10
            var skorMax = parseInt($('.val-' + komp + i + ':checked').data('skormax')); // 3

            if (komp.split('_')[0] != 'MiniCex') {
                (isNaN(nilai)) ? nilai = 0: nilai = (nilai * bobot) / skorMax;
                total = total + nilai;
            } else {
                (isNaN(nilai)) ? nilai = 0: nilai = nilai;
                total = total + nilai;
            }

            // console.log(nilai, bobot, skorMax);
        }
        if (komp.split('_')[0] == 'MiniCex') {
            total = (total * 10) / 6.3;
        }
        // console.log(nilai);
        callGrade(total);
    }

    function createEvent(komp) {
        // console.log(komp);
        if (komp.split('_')[0] == 'Pretest' || komp.split('_')[0] == 'Postest' || komp.split('_')[0] == 'KDinasKesehatan') {
            $("input[type=number].r-" + komp).keyup(function() {
                nilaiTextBoxt(komp);
            });
        } else {
            $('input[type=radio].r-' + komp).change(function() {
                nilaiRadio(komp);
            });
        }
    }


    function callGrade(total) {
        $.ajax({
            type: "POST",
            url: "/penilaian/konversi",
            data: {
                nilai: total
            },
            success: function(response) {
                // console.log(response);
                $('.grade').html('Nilai Huruf : ' + response);
            }
        });
    }



});