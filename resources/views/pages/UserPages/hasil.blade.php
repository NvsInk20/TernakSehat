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
</head>

<body class="bg-gradient-to-br from-orange-100 min-h-screen via-orange-200 to-orange-300 font-sans flex flex-col">
    <!-- Navbar -->
    <div class="flex-none">
        @include('components.navbar')
        <div class="hidden sm:block">
            @include('components.dropSettings')
        </div>
    </div>
    @if (session('success'))
        <div class="text-green-600 text-sm mb-2 mt-6 text-center">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="text-red-600 text-sm mb-4 text-center">{{ session('error') }}</div>
    @endif
    <!-- Main Content -->
    <main
        class="flex-grow flex mt-24 mb-14 xl:mb-0 2xl:mb-0 xl:mt-0 2xl:mt-0 flex-col overflow-y-auto items-center justify-center px-4"
        id="diagnosaContent">
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
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500">Penyakit:</strong>
                        <strong>{{ $diagnosaUtama['penyakit'] }}</strong>
                    </p>
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500">Gejala:</strong>
                    <ol class="list-decimal list-inside text-gray-700 2xl:text-xl">
                        @foreach ($diagnosaUtama['gejala'] as $key => $gejala)
                            <li>{{ $gejala }}</li>
                        @endforeach
                    </ol>
                    </p>
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500 2xl:text-xl">Solusi (Rekomendasi):</strong>
                        {{ implode(', ', $diagnosaUtama['solusi']) }}
                    </p>
                    <!-- Gejala yang Tidak Masuk dalam Hasil Diagnosa -->
                    @if (!empty($gejalaTidakMasuk))
                        <div class="border-t-2 border-orange-400 pt-6 mt-6">
                            <h3 class="text-xl font-semibold text-gray-800 2xl:text-xl mb-4">Gejala yang dipilih
                                tetapi
                                tidak
                                terdaftar dalam <strong>Diagnosa Utama</strong></h3>
                            <ol class="list-decimal list-inside 2xl:text-xl text-gray-700">
                                @foreach ($gejalaTidakMasuk as $item)
                                    <li>{{ $item['gejala'] }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                </div>
            @endif

            <!-- Kemungkinan Penyakit Lain -->
            @if (!empty($kemungkinan))
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 2xl:text-xl mb-4">Kemungkinan penyakit lainnya</h3>
                    <ul class="list-disc list-inside text-gray-700 2xl:text-xl">
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
            @if (!empty($penyakitTertinggi))
                <div class="border-t-2 border-orange-400 pt-6 mt-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 2xl:text-xl">Penyakit dengan kemungkinan
                        <strong>(Alternatif
                            Pertama)</strong>
                    </h3>
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500 2xl:text-xl">Penyakit:</strong> {{ $penyakitTertinggi }}
                    </p>
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500 2xl:text-xl">Persentase:</strong> {{ $persentaseTertinggi }}%
                    </p>
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500 2xl:text-xl">Solusi (Rekomendasi):</strong>
                        {{ implode(', ', $solusiTertinggi) }}
                    </p>
                </div>
            @endif

            @if (!empty($penyakitKedua))
                <div class="border-t-2 border-orange-400 pt-6 mt-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 2xl:text-xl">Penyakit dengan kemungkinan
                        <strong>(Alternatif Kedua)</strong>
                    </h3>
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500 2xl:text-xl">Penyakit:</strong> {{ $penyakitKedua }}
                    </p>
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500 2xl:text-xl">Persentase:</strong> {{ $persentaseKedua }}%
                    </p>
                    <p class="text-lg text-gray-700 mb-2 2xl:text-xl">
                        <strong class="text-orange-500 2xl:text-xl">Solusi (Rekomendasi):</strong>
                        {{ implode(', ', $solusiKedua) }}
                    </p>
                </div>
            @endif

            <!-- Tombol Reset Diagnosa -->
            <div class="mt-8 flex space-x-4">
                <form method="GET" action="{{ route('diagnosa.reset') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 text-white font-semibold 2xl:text-xl py-3 px-8 rounded-lg hover:bg-red-600 transition-all duration-300">
                        Reset Diagnosa
                    </button>
                </form>
                <form method="GET" action="{{ route('diagnosa.hasil') }}">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 text-white font-semibold 2xl:text-xl py-3 px-8 rounded-lg hover:bg-green-600 transition-all duration-300">
                        Simpan Diagnosa
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white mt-12 2xl:text-xl">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

</html>
