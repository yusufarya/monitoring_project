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
            padding: 6px;
            text-align: left;
            font-size: 10.5px;
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
                <td><strong>Tanggal Cetak:</strong> {{ date('d/m/Y') }}</td>
                <td><strong>Lokasi Proyek:</strong> {{ $header->location_project }}</td>
            </tr>
        </table>
    </div>

    @if ($detail)
        <div class="sub-title">
            <h3>Data Material</h3>
        </div>
        <table class="details">
            <thead>
                @php
                    $dates1 = DB::table('material_pickups')
                    ->select('date')
                    ->distinct()
                    ->orderBy('date')
                    ->pluck('date');

                    $dates2 = DB::table('daily_material_reports')
                    ->select('date')
                    ->distinct()
                    ->orderBy('date')
                    ->pluck('date');

                    // Combine both date collections and remove duplicates
                    $allDates = $dates1->merge($dates2)->unique()->sort();

                    // Convert to an array if needed
                    $allDatesArray = $allDates->values()->toArray();
                @endphp
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Kode</th>
                    <th rowspan="2">Deskripsi</th>
                    <th rowspan="2" style="text-align: center;">Satuan</th>
                    <th rowspan="2" style="text-align: right;">BOM</th>
                    @foreach ($allDatesArray as $date)
                    @php
                        $formattedDate = date('d/m/Y', strtotime($date));
                    @endphp
                        <th style="text-align: center;" colspan="2">{{$formattedDate}}</th>
                    @endforeach
                    <th rowspan="2" style="text-align: center;">Status</th>
                    <th rowspan="2" style="text-align: center;">Ket.</th>
                </tr>
                <tr>
                    @foreach ($allDatesArray as $date)
                        <th>req</th>
                        <th>rcv</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($detail as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                        <td style="text-align: right;">{{ $item->bom }}</td>
                        @foreach ($allDatesArray as $date)
                            @php
                                $formattedDate = date('d/m/Y', strtotime($date));
                            @endphp
                            <td style="text-align: right;">
                                {{ $item->{$formattedDate . '_req'} ?? 0 }}
                            </td>
                            <td style="text-align: right;">
                                {{ $item->{$formattedDate . '_rcv'} ?? 0 }}
                            </td>
                        @endforeach
                        <td style="text-align: center;">{{ $item->status }}</td>
                        <td style="text-align: center;">{{ $item->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
