$(function () {
    console.log("ready");

    var invalid = document.getElementById("invalid").value;
    var valid = document.getElementById("valid").value;
    if (valid) {
        $("#notif-success").toast("show");
    } else if (invalid) {
        $("#notif-failed").toast("show");
    }

    $('.btn-add').on('click', function() {
        $('#modal-add-material').modal('show')
    })

    $('.btn-edit').on('click', function() {
        $('#modal-edit-material').modal('show')
    })
});


function delete_data(id, name) {
    //
    $("#modal-delete").modal("show");
    $(".modal-title").text("Hapus Data");
    $("#modal-delete form").attr("action", "/delete-material-pickup/" + id);
    $("#content-delete").html("");

    var html =
        `<div class="col mb-2">
                <input type="hidden" name="id" id="id" value="` +
        id +
        `">
                <span style="margin-left: 10px;">Hapus Data <b>` +
        name +
        `</b> ?<span>
                </div>`;

    $("#content-delete").append(html);
}
