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
            font-size: 14px;
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
            font-size: 13px;
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
                <td><strong>Nama Pengawas:</strong> {{ $header->supervisor_name }} </td>
            </tr>
            <tr>
                <td><strong>Nama Kontraktor:</strong> {{ $header->contractor_name }} </td>
                <td><strong>Tanggal:</strong> {{ date('d/m/Y', strtotime($header->date)) }}</td>
            </tr>
            <tr>
                <td><strong>Nama Operator:</strong> {{ $header->operator_name }} </td>
                <td><strong>Tgl Mulai:</strong> {{ date('d/m/Y', strtotime($header->start_date)) }}</td>
            </tr>
            <tr>
                <td><strong>Lokasi Proyek:</strong> {{ $header->location_project }}</td>
                <td><strong>Tgl Selesai:</strong> {{ date('d/m/Y', strtotime($header->end_date)) }}</td>
            </tr>
            <tr>
                <td><strong>Nilai Proyek:</strong> {{ number_format($header->value_contract,0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    @if ($detail_j)
        <div class="sub-title">
            <h3>Data Pekerjaan</h3>
        </div>
        <table class="details">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Deskripsi</th>
                    <th style="text-align: center;">Satuan</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($detail_j as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                        <td style="text-align: right;">{{ $item->qty }}</td>
                        <td style="text-align: right;">{{ number_format($item->price,0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->total_price,0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if ($detail_m)
        <div class="sub-title">
            <h3>Data Material</h3>
        </div>
        <table class="details">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Deskripsi</th>
                    <th style="text-align: center;">Satuan</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($detail_m as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                        <td style="text-align: right;">{{ $item->qty }}</td>
                        <td style="text-align: right;">{{ number_format($item->price,0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->total_price,0, ',', '.') }}</td>
                    </tr>
                @endforeach
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
