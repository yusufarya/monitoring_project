$(document).ready(function () {
    $("#submitRpt").on("click", function () {
        var type = $("#type").val();
        var spk_number = $("#spk_number").val();
        var date = $("#date").val();

        if(!type) {
            alert('Pilih tipe rekap.')
            return
        } else if(!spk_number) {
            alert('Pilih nomor spk.')
            return
        }
        var URL = '/get-recapitulation'

        $.ajax({
            type: "GET",
            url: URL,
            dataType: "JSON",
            data: {
                spk_number: spk_number,
                type: type,
                date: date
            },
            success: function (data) {
                if(type == 'J') {
                    openRptJob()
                } else {
                    openRptMaterial()
                }
            },
        });
    });
});

function openRptJob() {
    window.popup = window.open(
        "/open-recapitulation-job",
        "rpt",
        "width=full, height=800, top=10, left=10, toolbar=1"
    );
}

function openRptMaterial() {
    window.popup = window.open(
        "/open-recapitulation-material",
        "rpt",
        "width=full, height=800, top=10, left=10, toolbar=1"
    );
}
