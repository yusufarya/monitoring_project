
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

{{-- ckeditor5-build-classic --}}
<script src="{{ asset('ckeditor5-build-classic/ckeditor.js') }}"></script>


<?php
  $dashboard = Request::segment(1) === 'dashboard' ? true : false;
?>

@if($dashboard)
  <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
@endif

@if (isset($script))
  <script src="{{ asset($script) }}.js"></script>
@endif

{{-- SELRCT 2 --}}
<link href="{{ asset('select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>

<script>

    setTimeout(() => {
        $('#alert-response').fadeOut(1000)
    }, 3500);

    $("#reset").on("click", function () {
        $('#fullname').val('')
        $("#submitForm").submit();
    });

    // Format a given value into Rupiah format
    function replaceRupiah(value) {
        // Convert the value to string and split into integer and decimal parts
        const numberString = value.toString();
        const split = numberString.split('.');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // Add separators for thousands
        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        // Append the decimal part if it exists
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah + ',00';

        return rupiah;
    }

    function formatRupiah(event, angka, prefix = "") {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;

        return (event.value =
            prefix == "" ? rupiah : rupiah ? "Rp. " + rupiah : "");
    }

    function clearRupiahFormatting(value) {
        // Step 1: Remove periods used for thousands
        let valueWithoutThousands = value.replace(/\./g, '');

        // Step 2: Replace the comma with a dot for decimal point
        let cleanedValue = valueWithoutThousands.replace(',', '.');

        // Step 3: Convert the cleaned string to a number
        let numberValue = parseFloat(cleanedValue);

        return numberValue;
    }

    // Method to check if a value contains special characters
    function hasSpecialChars(value) {

        const specialCharRegex = /[^a-zA-Z0-9]/

        return specialCharRegex.test(value)

    }


</script>
