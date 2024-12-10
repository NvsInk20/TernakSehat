<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Diagnosa</title>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Tailwind CSS dan Flowbite -->
    @vite('resources/css/app.css')
    <link rel="icon" href="/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-br from-orange-100 via-orange-200 to-orange-300 font-sans">
    <!-- Navbar -->
    @include('components.navbar')
    @include('components.dropSettings')
    @if (session('success'))
        <div class="text-green-600 text-sm mb-2 mt-6 text-center">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="text-red-600 text-sm mb-4 text-center">{{ session('error') }}</div>
    @endif

    <!-- Main Content -->
    <main class="flex flex-col items-center justify-center min-h-screen px-4" id="diagnosaContent">
        <!-- Judul Halaman -->
        <h1 class="text-4xl font-extrabold text-gray-800 mb-12 tracking-wide">Hasil Diagnosa</h1>

        <!-- Kontainer Hasil -->
        <div class="relative bg-white rounded-xl shadow-2xl p-8 max-w-3xl w-full">
            <!-- Dekorasi latar belakang -->
            <div
                class="absolute -z-10 inset-0 bg-gradient-to-tr from-orange-300 to-orange-500 blur-xl rounded-xl opacity-30">
            </div>

            <!-- Detail Hasil Diagnosa -->
            @if ($diagnosaUtama)
                <div class="border-b-2 border-orange-400 pb-6 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Hasil Diagnosa Utama</h2>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Penyakit:</strong> {{ $diagnosaUtama['penyakit'] }}
                    </p>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Gejala:</strong> {{ implode(', ', $diagnosaUtama['gejala']) }}
                    </p>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Solusi:</strong> {{ implode(', ', $diagnosaUtama['solusi']) }}
                    </p>
                </div>
            @endif

            <!-- Kemungkinan Penyakit Lain -->
            @if (!empty($kemungkinan))
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Kemungkinan Penyakit Lain</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach ($kemungkinan as $penyakit => $persentase)
                            <li>
                                <span class="font-medium">{{ $penyakit }}</span>
                                <span class="text-gray-600">({{ $persentase }}%)</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Penyakit Tertinggi dan Kedua -->
            @if ($penyakitTertinggi)
                <div class="border-t-2 border-orange-400 pt-6 mt-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Penyakit dengan Kemungkinan Alternatif
                        Pertama</h3>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Penyakit:</strong> {{ $penyakitTertinggi }}
                    </p>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Persentase:</strong> {{ $persentaseTertinggi }}%
                    </p>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Solusi:</strong> {{ implode(', ', $solusiTertinggi) }}
                    </p>
                </div>
            @endif

            @if ($penyakitKedua)
                <div class="border-t-2 border-orange-400 pt-6 mt-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Penyakit dengan Kemungkinan Altenatif Kedua
                    </h3>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Penyakit:</strong> {{ $penyakitKedua }}
                    </p>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Persentase:</strong> {{ $persentaseKedua }}%
                    </p>
                    <p class="text-lg text-gray-700 mb-2">
                        <strong class="text-orange-500">Solusi:</strong> {{ implode(', ', $solusiKedua) }}
                    </p>
                </div>
            @endif

            <!-- Tombol Reset Diagnosa -->
            <div class="mt-8 flex space-x-4">
                <form method="GET" action="{{ route('diagnosa.reset') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 text-white font-semibold py-3 px-8 rounded-lg hover:bg-red-600 transition-all duration-300">
                        Reset Diagnosa
                    </button>
                </form>
                <form method="GET" action="{{ route('diagnosa.hasil') }}">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 text-white font-semibold py-3 px-8 rounded-lg hover:bg-green-600 transition-all duration-300">
                        Simpan Diagnosa
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white mt-12">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

</html>
