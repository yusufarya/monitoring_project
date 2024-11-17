$(function () {
    // console.log("ready");
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    getJobOfDailyReport()

});


function getJobOfDailyReport() {

    $('table#table-job tbody').empty()
    var html = ''
    var total_qty = 0
    var total_weight = 0

    let p_id = $('#daily_report_id').val()

    if(p_id) {
        $.ajax({
            url: '/job-daily-report-details',
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
                                <td style="padding: 0 5px; text-align:right;">${dataJob.weight}</td>
                                <td style="width: 10%; text-align: center;">
                                    <button type="button" class="btn btn-sm btn-danger px-2" onclick="deleteItemJob(${dataJob.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                        </tr>`
                        total_qty += dataJob.qty
                        total_weight += dataJob.weight
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
                <td><input type="text" class="form-control" id="code_job" name="code_job" style="width: 100%;"></td>
                <td><input type="text" class="form-control" id="name_job" name="name_job" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="unit_job" name="unit_job" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="qty_job" name="qty_job" style="width: 100%;" autocomplete="off"></td>
                <td><input type="text" class="form-control" id="price_job" name="price_job" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="total_price_job" name="total_price_job" style="width: 100%;" readonly></td>
                <td><input type="text" class="form-control" id="weight" name="weight" style="width: 100%;" readonly></td>
                <td style="width: 10%; text-align: center;">
                    <button type="button" class="btn btn-sm btn-info px-2" id="addItemJob">
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

        // jumlah harga (qty*harga satuan per item) / nilai total pekerjaan
        let value_total_job = $('#value_total_job').val()
        let weight = (qty_job*price_job) / value_total_job * 100
        console.log(weight)
        $('#weight').val(parseFloat(weight).toFixed(2))
    })

    $('#addItemJob').on('click', function() {
        let p_id = $('#daily_report_id').val()
        let code_job = $('#code_job').val()
        let name_job = $('#name_job').val()
        let unit_job = $('#unit_job').val()
        let qty_job = $('#qty_job').val()
        let price_job = $('#price_job').val()
        let total_price_job = $('#total_price_job').val()
        let weight = $('#weight').val()

        const JobForm = {daily_report_id: p_id, code: code_job, name: name_job, unit: unit_job, qty: qty_job, price: price_job, total_price: total_price_job, weight: weight}
        $.ajax({
            url: '/save-daily-report-jobs',
            type: 'post',
            dataType: 'json',
            data: JobForm,
            success: function(response, status, jqXHR) {
                // Get the status code
                var statusCode = jqXHR.status;
                // console.log('Status Code:', statusCode);
                if(statusCode == 200) {
                    console.log(response)
                    getJobOfDailyReport()
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

function deleteItemJob(id) {
    $.ajax({
        url: '/delete-daily-report-jobs',
        type: 'post',
        dataType: 'json',
        data: {id: id},
        success: function(response, status, jqXHR) {
            // Get the status code
            var statusCode = jqXHR.status;
            // console.log('Status Code:', statusCode);
            if(statusCode == 200) {
                console.log(response)
                getJobOfDailyReport()
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
