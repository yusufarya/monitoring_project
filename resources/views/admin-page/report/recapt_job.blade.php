<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h1 {
            margin:0;
            color: #373737;
            text-align: left;
            border-bottom: 2px solid #575757;
        }
        .header table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .header table td {
            color: #373737;
            font-size: 13px;
            padding: 5px 0px;
        }

        .sub-title h3 {
            margin: 0%;
        }
        .sub-title h3 {
            margin-top: 15px;
            padding: 0;
            color: #373737;
        }

        .details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .details th, .details td {
            color: #303030;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        .details th {
            background-color: #f4f4f4;
        }
        .summary {
            margin-top: 20px;
            width: 100%;
            border-top: 1px solid #ddd;
        }
        .summary td {
            padding: 8px 10px;
        }
        .summary .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{$title}}</h1>
        <div style="color: #373737; margin-top:3px; font-size: 12px;"><strong>No. SPK : {{ $header->spk_number }}</strong></div>
        <table>
            <tr>
                <td><strong>Nama Proyek:</strong> {{ $header->project_name }} </td>
                <td><strong>Nama Kontraktor:</strong> {{ $header->contractor_name }} </td>
            </tr>
            <tr>
                <td><strong>Tanggal:</strong> {{ date('d/m/Y', strtotime($header->date)) }}</td>
                <td><strong>Lokasi Proyek:</strong> {{ $header->location_project }}</td>
            </tr>
        </table>
    </div>

    @if ($detail)
        <div class="sub-title">
            <h3>Data Pekerjaan</h3>
        </div>
        <table class="details">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Deskripsi</th>
                    <th style="text-align: center;">Satuan</th>
                    <th style="text-align: right;">BOQ</th>
                    <th style="text-align: right;">Terpasang</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Jumlah Harga</th>
                    <th style="text-align: center;">Bobot (%)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $grand_total_price = 0;
                    $total_weight = 0;
                    @endphp
                @foreach ($detail as $item)
                @php
                    $grand_total_price += $item->daily_total_price;
                @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                        <td style="text-align: right;">{{ $item->total_qty }}</td>
                        <td style="text-align: right;">{{ $item->daily_qty }}</td>
                        <td style="text-align: right;">{{ number_format($item->daily_price,2, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->daily_total_price,2, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->weight,2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2">Total Nilai</th>
                    <th style="text-align: right;">{{ number_format($grand_total_price,2, ',', '.') }}</th>
                    <th style="text-align: right;">{{ $total_weight+=$item->weight }}</th>
                </tr>
            </tbody>
        </table>
    @endif

</body>
</html>
