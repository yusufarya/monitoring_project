$(function () {
    // console.log("ready");
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#project_id').on('change', function() {
        $.ajax({
            url: '/get-project-id',
            type: 'get',
            dataType: 'json',
            data: {
                project_id: $(this).val()
            },
            success: function(response, status, jqXHR) {
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    console.log(response)
                    $('#spk_number').val(response.spk_number)
                    $('#project_name').val(response.project_name)
                    $('#contractor_name').val(response.contractor_name)
                    $('#location_project').val(response.location_project)
                    $('#location_project').val(response.location_project)
                    $('#value_contract').val(response.value_contract)
                    $('#value_total_job').val(response.value_total_job)
                    $('#value_total_material').val(response.value_total_material)
                }
            },
            error: function(jqXHR, status, error) {
                var statusCode = jqXHR.status;
                if(statusCode == 404){
                    alert(jqXHR.responseJSON.message)
                }
                console.log('Status Code:', statusCode);
                // console.log('Status:', status);
                // console.log('Error:', error);
                // console.log('All Headers on Error:', jqXHR.getAllResponseHeaders());
            }
        })
    })

    $('#spk_number').on('change', function() {
        $.ajax({
            url: '/get-project',
            type: 'get',
            dataType: 'json',
            data: {
                spk_number: $(this).val()
            },
            success: function(response, status, jqXHR) {
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    console.log(response)
                    $('#project_id').val(response.id)
                    $('#project_name').val(response.project_name)
                    $('#contractor_name').val(response.contractor_name)
                    $('#location_project').val(response.location_project)
                    $('#location_project').val(response.location_project)
                    $('#value_contract').val(response.value_contract)
                    $('#value_total_job').val(response.value_total_job)
                    $('#value_total_material').val(response.value_total_material)
                }
            },
            error: function(jqXHR, status, error) {
                var statusCode = jqXHR.status;
                if(statusCode == 404){
                    alert(jqXHR.responseJSON.message)
                }
                console.log('Status Code:', statusCode);
                // console.log('Status:', status);
                // console.log('Error:', error);
                // console.log('All Headers on Error:', jqXHR.getAllResponseHeaders());
            }
        })
    })

    getMaterialOfProject()

    $('#addItemMaterial').on('click', function() {
        let b_id = $('#balance_id').val()
        let code_material = $('#code_material').val()
        let name_material = $('#name_material').val()
        let unit_material = $('#unit_material').val()
        let qty_material = $('#qty_material').val()
        let price_material = $('#price_material').val()
        let total_price_material = $('#total_price_material').val()
        let weight = $('#weight').val()

        const JobForm = {balance_id: b_id, code: code_material, name: name_material, unit: unit_material, qty: qty_material, price: price_material, total_price: total_price_material, weight: weight}
        $.ajax({
            url: '/save-material-balance',
            type: 'post',
            dataType: 'json',
            data: JobForm,
            success: function(response, status, jqXHR) {
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    console.log(response)
                    getMaterialOfProject()
                }
            },
            error: function(jqXHR, status, error) {
                var statusCode = jqXHR.status;
                if(statusCode == 404){
                    alert(jqXHR.responseJSON.message)
                }
                console.log('Status Code:', statusCode);
                // console.log('Status:', status);
                // console.log('Error:', error);
                // console.log('All Headers on Error:', jqXHR.getAllResponseHeaders());
            }
        })
    })

});


function getMaterialOfProject() {

    $('table#table-material tbody').empty()
    var html = ''
    var total_qty = 0

    let project_id = $('#project_id').val()

    if(project_id) {
        $.ajax({
            url: '/detail-material-balance',
            type: 'get',
            dataType: 'json',
            async: false,
            data: {
                project_id: project_id
            },
            success: function(response, status, jqXHR) {
                console.log(status)
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    // console.log(response);
                    response.data.map(function(dataMaterial, index) {
                        // Your logic here for each item
                        console.log(dataMaterial)
                        html += `<tr>
                                <td style="padding: 0 5px;">${dataMaterial.code}</td>
                                <td style="padding: 0 5px;">${dataMaterial.name}</td>
                                <td style="padding: 0 5px; text-align:center;">${dataMaterial.unit}</td>
                                <td style="padding: 0 5px; text-align:center;">${dataMaterial.status}</td>
                                <td style="padding: 0 5px; text-align:left;">${dataMaterial.note}</td>
                            </tr>`
                        // total_qty += dataMaterial.qty
                    });


                }
            },
            error: function(jqXHR, status, error) {
                var statusCode = jqXHR.status;
                if(statusCode == 404){
                    alert(jqXHR.responseJSON.message)
                }
                console.log('Status Code:', statusCode);
                // console.log('Status:', status);
                // console.log('Error:', error);
                // console.log('All Headers on Error:', jqXHR.getAllResponseHeaders());
            }
        })

        // html += `<tr>
        //             <td></td>
        //             <td></td>
        //             <td></td>
        //             <th colspan="2" style="text-align:right;">Total Qty</th>
        //             <th style="text-align:center;">${total_qty}</th>
        //             <td style="width: 10%; text-align: center;"></td>
        //         </tr>`
    }
    // html += `<tr>
    //             <td><input type="text" class="form-control" id="code_material" name="code_material" style="width: 100%;"></td>
    //             <td><input type="text" class="form-control" id="name_material" name="name_material" style="width: 100%;" readonly></td>
    //             <td><input type="text" class="form-control" id="unit_material" name="unit_material" style="width: 100%;" readonly></td>
    //             <td><input type="text" class="form-control" id="qty_material" name="qty_material" style="width: 100%;" autocomplete="off"></td>
    //             <td><input type="text" class="form-control" id="status" name="status" style="width: 100%;" readonly></td>
    //             <td><input type="text" class="form-control" id="note" name="note" style="width: 100%;" readonly></td>
    //             <td style="width: 10%; text-align: center;">
    //                 <button type="button" class="btn btn-sm btn-info px-2" id="addItemMaterial">
    //                     <i class="fas fa-plus"></i>
    //                 </button>
    //             </td>
    //         </tr>`

    $('table#table-material tbody').append(html)

    $('#code_material').on('change', function() {
        $.ajax({
            url: '/get-material-balance',
            type: 'get',
            dataType: 'json',
            data: {
                code_material: $(this).val()
            },
            success: function(response, status, jqXHR) {
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    console.log(response)
                    $('#name_material').val(response.name)
                    $('#unit_material').val(response.unit)
                    $('#status').val(response.status)
                    $('#note').val(response.note)
                }
            },
            error: function(jqXHR, status, error) {
                var statusCode = jqXHR.status;
                if(statusCode == 404){
                    alert(jqXHR.responseJSON.message)
                }
                console.log('Status Code:', statusCode);
                // console.log('Status:', status);
                // console.log('Error:', error);
                // console.log('All Headers on Error:', jqXHR.getAllResponseHeaders());
            }
        })
    })

    // $('#qty_material').on('blur', function() {
    //     let qty_material = $(this).val()
    //     let price_material = $('#price_material').val()
    //     console.log(qty_material)
    //     console.log(price_material)
    //     let totalPrice = price_material*qty_material
    //     console.log(totalPrice)

    //     $('#total_price_material').val(totalPrice)

    //     // jumlah harga (qty*harga satuan per item) / nilai total pekerjaan
    //     let value_total_material = $('#value_total_material').val()
    //     let weight = (qty_material*price_material) / value_total_material
    //     console.log(weight)
    //     $('#weight').val(parseFloat(weight).toFixed(2))

    // })
}

function getMaterialBalance(id) {
    $.ajax({
        url: '/get-material-balance',
        type: 'get',
        dataType: 'json',
        data: {
            project_id: id
        },
        success: function(response, status, jqXHR) {
            // Get the status code
            var statusCode = jqXHR.status;
            // console.log('Status Code:', statusCode);
            if(statusCode == 200) {
                console.log(response)
                $('#name_material').val(response.name)
                $('#unit_material').val(response.unit)
                $('#status').val(response.status)
                $('#note').val(response.note)
            }
        },
        error: function(jqXHR, status, error) {
            var statusCode = jqXHR.status;
            if(statusCode == 404){
                alert(jqXHR.responseJSON.message)
            }
            console.log('Status Code:', statusCode);
            // console.log('Status:', status);
            // console.log('Error:', error);
            // console.log('All Headers on Error:', jqXHR.getAllResponseHeaders());
        }
    })
}

function deleteItemMaterial(id) {
    $.ajax({
        url: '/delete-material-balance',
        type: 'post',
        dataType: 'json',
        data: {id: id},
        success: function(response, status, jqXHR) {
            // Get the status code
            var statusCode = jqXHR.status;
            // console.log('Status Code:', statusCode);
            if(statusCode == 200) {
                console.log(response)
                getMaterialOfProject()
            }
        },
        error: function(jqXHR, status, error) {
            var statusCode = jqXHR.status;
            if(statusCode == 404){
                alert(jqXHR.responseJSON.message)
            }
            console.log('Status Code:', statusCode);
            // console.log('Status:', status);
            // console.log('Error:', error);
            // console.log('All Headers on Error:', jqXHR.getAllResponseHeaders());
        }
    })
}

