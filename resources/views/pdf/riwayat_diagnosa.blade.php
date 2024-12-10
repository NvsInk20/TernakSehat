<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            color: #3c3c3c;
        }

        .header h1 {
            font-size: 28px;
            color: #1e88e5;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 16px;
            color: #555;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .table th {
            background-color: #1e88e5;
            color: white;
            font-weight: bold;
        }

        .table td {
            background-color: #f9f9f9;
        }

        .table tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        .table ul {
            padding-left: 20px;
            color: #555;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .footer p {
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Hasil Diagnosa Kesehatan Sapi</h1>
            <p><strong>Kode Sapi:</strong> {{ $riwayat->kode_sapi }}</p>
            <p><strong>Tanggal Diagnosa:</strong> {{ $riwayat->created_at->format('d M Y, H:i') }}</p>
        </div>

        <table class="table">
            <tr>
                <th>Nama Pemilik</th>
                <td>{{ $riwayat->nama }}</td>
            </tr>
            <tr>
                <th>Penyakit Utama</th>
                <td>{{ $riwayat->penyakit_utama ?? 'Tidak ada' }}</td>
            </tr>
            <tr>
                <th>Penyakit Alternatif 1</th>
                <td>{{ $riwayat->penyakit_alternatif_1 ?? 'Tidak ada' }}</td>
            </tr>
            <tr>
                <th>Penyakit Alternatif 2</th>
                <td>{{ $riwayat->penyakit_alternatif_2 ?? 'Tidak ada' }}</td>
            </tr>
            <tr>
                <th>Gejala</th>
                <td>
                    @if (!empty($gejalaArray))
                        <ul>
                            @foreach ($gejalaArray as $gejala)
                                <li>{{ $gejala }}</li>
                            @endforeach
                        </ul>
                    @else
                        Tidak ada gejala
                    @endif
                </td>
            </tr>
            <tr>
                <th>Solusi</th>
                <td>{{ $riwayat->solusi ?? 'Tidak ada solusi' }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Hasil diagnosa ini bersifat informatif dan bukan pengganti konsultasi langsung dengan dokter hewan.</p>
            <p>&copy; 2024 Ternak Sehat</p>
        </div>
    </div>
</body>

</html>
