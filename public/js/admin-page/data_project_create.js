$(function () {
    // console.log("ready");
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    getJobOfProject()

    getMaterialOfProject()


});


function getJobOfProject() {

    $('table#table-job tbody').empty()
    var html = ''

    let p_id = $('#project_id').val()
    if(p_id) {
        $.ajax({
            url: '/job-of-project',
            type: 'get',
            dataType: 'json',
            async: false,
            data: {
                project_id: p_id
            },
            success: function(response, status, jqXHR) {
                console.log(status)
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    // console.log(response);
                    response.map(function(dataJob, index) {
                        // Your logic here for each item
                        console.log(dataJob)
                        html += `<tr>
                                <td style="padding: 0 5px;">${dataJob.code}</td>
                                <td style="padding: 0 5px;">${dataJob.name}</td>
                                <td style="padding: 0 5px;">${dataJob.unit}</td>
                                <td style="padding: 0 5px; text-align:center;">${dataJob.qty}</td>
                                <td style="padding: 0 5px; text-align:right;">${dataJob.price}</td>
                                <td style="padding: 0 5px; text-align:right;">${dataJob.total_price}</td>
                                <td style="width: 10%; text-align: center;">
                                    <button type="button" class="btn btn-sm btn-danger px-2" onclick="deleteJob(${dataJob.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                        </tr>`
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
    }

    html += `<tr>
                <td><input type="text" class="form-control" id="code_job" name="code_job" style="width: 100%;"></td>
                <td><input type="text" class="form-control" id="name_job" name="name_job" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="unit_job" name="unit_job" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="qty_job" name="qty_job" style="width: 100%;" autocomplete="off"></td>
                <td><input type="text" class="form-control" id="price_job" name="price_job" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="total_price_job" name="total_price_job" style="width: 100%;" readonly></td>
                <td style="width: 10%; text-align: center;">
                    <button type="button" class="btn btn-sm btn-info px-2" id="add_job">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
            </tr>`

    $('table#table-job tbody').append(html)

    $('#code_job').on('change', function() {
        $.ajax({
            url: '/get-master-jobs',
            type: 'get',
            dataType: 'json',
            data: {
                code_job: $(this).val()
            },
            success: function(response, status, jqXHR) {
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    console.log(response)
                    $('#name_job').val(response.name)
                    $('#unit_job').val(response.unit)
                    $('#price_job').val(response.price)
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

    $('#qty_job').on('blur', function() {
        let qty_job = $(this).val()
        let price_job = $('#price_job').val()
        console.log(qty_job)
        console.log(price_job)
        let totalPrice = price_job*qty_job
        console.log(totalPrice)

        $('#total_price_job').val(totalPrice.toFixed(2))
    })

    $('#add_job').on('click', function() {
        let p_id = $('#project_id').val()
        let code_job = $('#code_job').val()
        let name_job = $('#name_job').val()
        let unit_job = $('#unit_job').val()
        let qty_job = $('#qty_job').val()
        let price_job = $('#price_job').val()
        let total_price_job = $('#total_price_job').val()

        const JobForm = {project_id: p_id, code: code_job, name: name_job, unit: unit_job, qty: qty_job, price: price_job, total_price: total_price_job}
        $.ajax({
            url: '/save-tr-jobs',
            type: 'post',
            dataType: 'json',
            data: JobForm,
            success: function(response, status, jqXHR) {
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    console.log(response)
                    getJobOfProject()
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

function deleteJob(id) {
    $.ajax({
        url: '/delete-tr-job',
        type: 'post',
        dataType: 'json',
        data: {id: id},
        success: function(response, status, jqXHR) {
            // Get the status code
            var statusCode = jqXHR.status;
            // console.log('Status Code:', statusCode);
            if(statusCode == 200) {
                console.log(response)
                getJobOfProject()
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

function getMaterialOfProject() {

    $('table#table-material tbody').empty()
    var html = ''

    let p_id = $('#project_id').val()
    if(p_id) {
        $.ajax({
            url: '/material-of-project',
            type: 'get',
            dataType: 'json',
            async: false,
            data: {
                project_id: p_id
            },
            success: function(response, status, jqXHR) {
                // console.log(status)
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200){
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
                                <td style="width: 10%; text-align: center;">
                                    <button type="button" class="btn btn-sm btn-danger px-2" onclick="deleteMaterial(${dataMaterial.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                        </tr>`
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

    }

    html += `<tr>
                <td><input type="text" class="form-control" id="code_material" name="code_material" style="width: 100%;"></td>
                <td><input type="text" class="form-control" id="name_material" name="name_material" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="unit_material" name="unit_material" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="qty_material" name="qty_material" style="width: 100%;" autocomplete="off"></td>
                <td><input type="text" class="form-control" id="price_material" name="price_material" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="total_price_material" name="total_price_material" style="width: 100%;" readonly></td>
                <td style="width: 10%; text-align: center;">
                    <button type="button" class="btn btn-sm btn-info px-2" id="add_material">
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
                console.log(status)
                // Get the status code
                var statusCode = jqXHR.status;
                console.log('Status Code:', statusCode);
                if(statusCode == 200){
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

        $('#total_price_material').val(totalPrice.toFixed(2))
    })

    $('#add_material').on('click', function() {
        let p_id = $('#project_id').val()
        let code_material = $('#code_material').val()
        let name_material = $('#name_material').val()
        let unit_material = $('#unit_material').val()
        let qty_material = $('#qty_material').val()
        let price_material = $('#price_material').val()
        let total_price_material = $('#total_price_material').val()

        const JobForm = {project_id: p_id, code: code_material, name: name_material, unit: unit_material, qty: qty_material, price: price_material, total_price: total_price_material}
        $.ajax({
            url: '/save-tr-materials',
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

function deleteMaterial(id) {
    $.ajax({
        url: '/delete-tr-materials',
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
