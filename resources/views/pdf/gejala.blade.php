<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Pengecekan Gejala</title>
    <link rel="icon" href="/images/logo.png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin: 20px 0;
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .gejala {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .gejala-name {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #4CAF50;
        }

        .panduan {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }

        .panduan-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background-color: #f9f9f9;
            page-break-inside: avoid;
        }

        .panduan-item img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
            display: block;
            margin: 0 auto 10px;
            border-radius: 8px;
        }

        .panduan-item .panduan-title {
            font-weight: bold;
            font-size: 16px;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .panduan-item .panduan-desc {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #777;
            margin-top: 20px;
            position: fixed;
            bottom: 10px;
            width: 100%;
        }

        .footer span {
            font-weight: bold;
            color: #f39c12;
        }

        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12px;
            }

            .container {
                width: 100%;
                padding: 5px;
                box-shadow: none;
                border-radius: 0;
            }

            h1 {
                font-size: 22px;
            }

            .gejala {
                page-break-before: auto;
            }

            .panduan-item {
                page-break-after: auto;
                margin-bottom: 10px;
                break-inside: avoid;
            }

            .footer {
                position: fixed;
                bottom: 5px;
                width: 100%;
            }

            /* Prevent images and descriptions from breaking across pages */
            .panduan-item img,
            .panduan-item .panduan-desc {
                page-break-inside: avoid;
            }

            .footer p {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <h1>Panduan Pengecekan Gejala</h1>

    <div class="container">
        @foreach ($gejala as $index => $item)
            <div class="gejala">
                <div class="gejala-name">Gejala: {{ $item->nama_gejala }}</div>
                <div class="panduan">
                    @if ($item->panduanGejala->isNotEmpty())
                        @foreach ($item->panduanGejala as $panduan)
                            <div class="panduan-item">
                                <div class="panduan-title">Panduan ke - {{ $loop->iteration }}</div>

                                @if (!empty($panduan->foto_dokumen))
                                    <img src="{{ storage_path('app/public/' . $panduan->foto_dokumen) }}"
                                        alt="Panduan Gejala">
                                @else
                                    <div>Tidak Ada Gambar</div>
                                @endif

                                <div class="panduan-desc">
                                    @if (!empty($panduan->deskripsi_panduan))
                                        {{ $panduan->deskripsi_panduan }}
                                    @else
                                        <span>Tidak Ada Deskripsi</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="panduan-item">
                            <div class="panduan-title">Panduan Tidak Tersedia</div>
                            <div>Tidak Ada Panduan untuk Gejala ini</div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <p>Dicetak oleh Sistem Pakar <span><strong>Ternak Sehat</strong></span> | {{ now()->format('d M Y, H:i:s') }}
        </p>
    </div>
</body>

</html>
