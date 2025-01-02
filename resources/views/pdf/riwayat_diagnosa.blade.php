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
            background-color: #f4f4f9;
        }

        .container {
            width: 100%;
            max-width: 850px;
            margin: 20px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            border-top: 8px solid #FF5A1F;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 32px;
            color: #FF5A1F;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 16px;
            color: #555;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
        }

        .table {
            width: 92%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 14px;
            text-align: left;
            vertical-align: top;
        }

        .table th {
            background-color: #FF5A1F;
            color: white;
            font-weight: bold;
        }

        .table td {
            background-color: #f9f9f9;
            color: #333;
            width: 70%;
        }

        .table tr:nth-child(even) td {
            background-color: #f2f4f5;
        }

        .table ul {
            padding-left: 20px;
            color: #555;
            margin-top: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .footer p {
            margin: 5px 0;
            font-style: italic;
        }

        .footer .highlight {
            font-weight: bold;
            color: #FF5A1F;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- <div class="logo">
            <img src="images/logo.png" alt="Logo Ternak Sehat">
        </div> --}}
        <div class="header">
            <h1>Hasil Riwayat Pemeriksaan Diagnosa</h1>
            <p><strong>Kode Sapi:</strong> {{ $riwayat->kode_sapi }}</p>
            <p><strong>Tanggal Diagnosa:</strong> {{ $riwayat->created_at->format('d M Y') }}</p>
            <p><strong>Waktu Diagnosa:</strong> {{ $riwayat->created_at->format('H:i') }} WIB</p>
        </div>

        <table class="table">
            <tr>
                <th>Nama Pengguna</th>
                <td>{{ $riwayat->nama }}</td>
            </tr>
            <tr>
                <th>Penyakit Utama</th>
                <td>{{ $riwayat->penyakit_utama ?? 'Penyakit Tidak Tersedia' }}</td>
            </tr>
            <tr>
                <th>Penyakit Alternatif 1</th>
                <td>{{ $riwayat->penyakit_alternatif_1 ?? 'Penyakit Alternatif Tidak Tersedia' }}</td>
            </tr>
            <tr>
                <th>Penyakit Alternatif 2</th>
                <td>{{ $riwayat->penyakit_alternatif_2 ?? 'Penyakit Alternatif Tidak Tersedia' }}</td>
            </tr>
            <tr>
                <th>Gejala</th>
                <td>
                    @if (!empty($gejala))
                        <ul>
                            @foreach ($gejala as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        Tidak ada gejala yang terdeteksi.
                    @endif
                </td>
            </tr>
            <tr>
                <th>Saran yang bisa dilakukan</th>
                <td>{{ $riwayat->solusi ?? 'Tidak bisa memberikan rekomendasi yang aman' }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Hasil diagnosa ini bersifat informatif dan <span class="highlight">bukan pengganti</span> konsultasi
                langsung dengan dokter hewan.</p>
            <p>Ternak Sehat &copy; 2024</p>
        </div>
    </div>
</body>

</html>
