$(document).ready(function () {
    var indexNama = 1;

    // Initialize select2
    initailizeSelect2();

    // Add <select > element
    $('#btn_add').click(function () {
        indexNama = indexNama + 1;
        console.log(indexNama);
        $.ajax({
            type: "POST",
            url: "/bobot/penilaian",
            data: { request: 2, name: indexNama },
            success: function (response) {

                // Append element
                $('#elements').append(response);

                // Initialize select2
                initailizeSelect2();
            }
        });
    });

});

// Initialize select2
function initailizeSelect2() {

    $(".select2_el").select2({
        ajax: {
            url: "/bobot/penilaian",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
}




