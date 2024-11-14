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

});


function getMaterialOfProject() {

    $('table#table-material tbody').empty()
    var html = ''
    var total_qty = 0
    var total_weight = 0

    let p_id = $('#daily_report_id').val()

    if(p_id) {
        $.ajax({
            url: '/material-daily-report-details',
            type: 'get',
            dataType: 'json',
            async: false,
            data: {
                daily_report_id: p_id
            },
            success: function(response, status, jqXHR) {
                console.log(status)
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    // console.log(response);
                    response.map(function(dataMaterial, index) {
                        // Your logic here for each item
                        console.log(dataMaterial)
                        html += `<tr>
                                <td style="padding: 0 5px;">${dataMaterial.code}</td>
                                <td style="padding: 0 5px;">${dataMaterial.name}</td>
                                <td style="padding: 0 5px;">${dataMaterial.unit}</td>
                                <td style="padding: 0 5px; text-align:center;">${dataMaterial.qty}</td>
                                <td style="padding: 0 5px; text-align:right;">${dataMaterial.price}</td>
                                <td style="padding: 0 5px; text-align:right;">${dataMaterial.total_price}</td>
                                <td style="padding: 0 5px; text-align:right;">${dataMaterial.weight}</td>
                                <td style="width: 10%; text-align: center;">
                                    <button type="button" class="btn btn-sm btn-danger px-2" onclick="deleteItemMaterial(${dataMaterial.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                        </tr>`
                        total_qty += dataMaterial.qty
                        total_weight += dataMaterial.weight
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

        html += `<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:center;">${total_qty}</td>
                    <th colspan="2" style="text-align:right;">Total Bobot Sampai Hari ini (%)</th>
                    <td style="text-align:right;">${total_weight}</td>
                    <td style="width: 10%; text-align: center;"></td>
                </tr>`
    }
    html += `<tr>
                <td><input type="text" class="form-control" id="code_material" name="code_material" style="width: 100%;"></td>
                <td><input type="text" class="form-control" id="name_material" name="name_material" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="unit_material" name="unit_material" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="qty_material" name="qty_material" style="width: 100%;" autocomplete="off"></td>
                <td><input type="text" class="form-control" id="price_material" name="price_material" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="total_price_material" name="total_price_material" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="weight" name="weight" style="width: 100%;" readonly></td>
                <td style="width: 10%; text-align: center;">
                    <button type="button" class="btn btn-sm btn-info px-2" id="addItemMaterial">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
            </tr>`

    $('table#table-material tbody').append(html)

    $('#code_material').on('change', function() {
        $.ajax({
            url: '/get-master-materials',
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
                    $('#price_material').val(response.price)
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

    $('#qty_material').on('blur', function() {
        let qty_material = $(this).val()
        let price_material = $('#price_material').val()
        console.log(qty_material)
        console.log(price_material)
        let totalPrice = price_material*qty_material
        console.log(totalPrice)

        $('#total_price_material').val(totalPrice)

        // jumlah harga (qty*harga satuan per item) / nilai total pekerjaan
        let value_total_material = $('#value_total_material').val()
        let weight = (qty_material*price_material) / value_total_material
        console.log(weight)
        $('#weight').val(parseFloat(weight).toFixed(2))
    })



    $('#addItemMaterial').on('click', function() {
        let p_id = $('#daily_report_id').val()
        let code_material = $('#code_material').val()
        let name_material = $('#name_material').val()
        let unit_material = $('#unit_material').val()
        let qty_material = $('#qty_material').val()
        let price_material = $('#price_material').val()
        let total_price_material = $('#total_price_material').val()
        let weight = $('#weight').val()

        const JobForm = {daily_report_id: p_id, code: code_material, name: name_material, unit: unit_material, qty: qty_material, price: price_material, total_price: total_price_material, weight: weight}
        $.ajax({
            url: '/save-daily-report-materials',
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
}

function deleteItemMaterial(id) {
    $.ajax({
        url: '/delete-daily-report-materials',
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

