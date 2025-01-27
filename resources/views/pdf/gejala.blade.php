<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Panduan Pengecekan Gejala</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        tr {
            page-break-inside: avoid;
        }

        @media print {
            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            tr {
                page-break-inside: avoid;
            }
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: black;
        }

        .footer span {
            color: orange;
        }
    </style>
</head>

<body>
    <h1>Daftar Panduan Pengecekan Gejala</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Gejala</th>
                <th>Gambar</th>
                <th>Deskripsi Panduan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gejala as $index => $item)
                @php
                    $fotoDokumen = $item->foto_dokumen ? explode(',', $item->foto_dokumen) : [];
                    $deskripsiPanduan = $item->deskripsi_panduan ? explode('|', $item->deskripsi_panduan) : [];
                    $maxRows = max(count($fotoDokumen), count($deskripsiPanduan), 1);
                @endphp
                @for ($i = 0; $i < $maxRows; $i++)
                    <tr>
                        @if ($i === 0)
                            <td rowspan="{{ $maxRows }}">{{ $index + 1 }}</td>
                            <td rowspan="{{ $maxRows }}">{{ $item->nama_gejala }}</td>
                        @endif
                        <td>
                            @if (!empty($fotoDokumen[$i]))
                                <img src="{{ storage_path('app/public/' . $fotoDokumen[$i]) }}" alt="Gambar Gejala">
                            @else
                                <span>Tidak Ada Gambar</span>
                            @endif
                        </td>
                        <td>
                            @if (!empty($deskripsiPanduan[$i]))
                                {{ $deskripsiPanduan[$i] }}
                            @else
                                <span>Tidak Ada Deskripsi</span>
                            @endif
                        </td>
                    </tr>
                @endfor
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Dicetak oleh Sistem Pakar <span><strong>Ternak Sehat</strong></span> | {{ now()->format('d M Y, H:i:s') }}
        </p>
    </div>
</body>

</html>
