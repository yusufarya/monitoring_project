$(document).ready(function () {
    $("#sub_district").on("change", function () {
        $("#village").html("");
        $("#village").val("");
        // console.log($(this).val());
        // loadVillages($(this).val());
        loadVillages($("#sub_district").val());
    });

    $(".select-fullname").select2({
        placeholder: "Pilih Pendaftar",
        width: "100%",
    });

    let startYear = 2010;
    let endYear = new Date().getFullYear();
    for (var listYear = startYear; listYear <= endYear; listYear++) {
        $("#year").append($("<option />").val(listYear).html(listYear));
    }
    $("#year").val(endYear).change();
});

function loadVillages(id) {
    console.log(id);
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "/getVillages",
        data: { sub_district_id: id },
        async: false,
        success: function (result) {
            var html = `<option value="">Pilih kelurahan</option>`;
            result.map((item) => {
                html +=
                    `<option value="` +
                    item.id +
                    `">  » &nbsp; ` +
                    item.name +
                    `</option>`;
            });

            $("#village").append(html);
        },
    });
}

var village = $("#village_").val();
$("#village").val(village).change();

$("#submitRpt").on("click", function () {
    var fullname = $("#fullname").val();
    var gender = $("#gender").val();
    var sub_district = $("#sub_district").val();
    var village = $("#village").val();
    var year = $("#year").val();

    $.ajax({
        type: "GET",
        url: "/registrant-rpt",
        dataType: "JSON",
        data: {
            fullname: fullname,
            gender: gender,
            sub_district: sub_district,
            village: village,
            year: year,
        },
        success: function (data) {
            openRpt();
        },
    });
});

function openRpt() {
    window.popup = window.open(
        "/open-registrant-rpt",
        "rpt",
        "width=1550, height=600, top=10, left=10, toolbar=1"
    );
}
