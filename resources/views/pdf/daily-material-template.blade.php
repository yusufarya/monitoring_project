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
            padding: 10px;
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
                <td><strong>Nilai Proyek:</strong> {{ number_format($header->value_contract,0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Nama Kontraktor:</strong> {{ $header->contractor_name }} </td>
                <td><strong>Nilai Total Pekerjaan:</strong> {{ number_format($header->value_total_job,0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal:</strong> {{ date('d/m/Y', strtotime($header->date)) }}</td>
                <td><strong>Nilai Total Material:</strong> {{ number_format($header->value_total_material,0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Lokasi Proyek:</strong> {{ $header->location_project }}</td>
            </tr>
        </table>
    </div>

    @if ($detail_m)
        <div class="sub-title">
            <h3>Data Material</h3>
        </div>
        <table class="details">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode</th>
                    <th>Deskripsi</th>
                    <th style="text-align: center;">Satuan</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Jumlah Harga</th>
                    <th style="text-align: right;">Bobot (%)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $totalWeight = 0;
                    $totalValue = 0;
                @endphp
                @foreach ($detail_m as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                        <td style="text-align: right;">{{ $item->qty }}</td>
                        <td style="text-align: right;">{{ number_format($item->price,2, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->total_price,2, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->weight,2, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalWeight += $item->weight;
                        $totalValue += $item->total_price;
                    @endphp
                @endforeach

                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="3">Total Nilai</th>
                    <th style="text-align: right;">{{ number_format($totalValue,2, ',', '.') }}</th>
                    <th style="text-align: right;">{{ number_format($totalWeight,2, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- <table class="summary">
        <tr>
            <td style="text-align: right;"><strong>Subtotal:</strong></td>
            <td style="text-align: right;">Rp 340,000</td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong>Diskon:</strong></td>
            <td style="text-align: right;">Rp 20,000</td>
        </tr>
        <tr>
            <td style="text-align: right;" class="total"><strong>Total:</strong></td>
            <td style="text-align: right;" class="total">Rp 320,000</td>
        </tr>
    </table> --}}

</body>
</html>
