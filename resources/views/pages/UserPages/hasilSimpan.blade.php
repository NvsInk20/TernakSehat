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
    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 transition-opacity duration-300" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <!-- Navbar -->
    @include('components.navbar')
    @include('components.dropSettings')

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

            @if ($diagnosaUtama || $penyakitTertinggi || $penyakitKedua)
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Simpan Hasil Diagnosa</h3>
                    <form method="POST" action="{{ route('diagnosa.simpanHasil') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                            <input type="text" id="nama" name="nama"
                                value="{{ auth()->user()->nama ?? 'Nama Tidak Diketahui' }}"
                                class="mt-1 p-2 block w-full border bg-gray-300 border-gray-300 rounded-md" readonly>
                        </div>

                        <div>
                            <label for="kode_sapi" class="block text-sm font-medium text-gray-700">Kode Sapi</label>
                            <input type="text" id="kode_sapi" name="kode_sapi"
                                value="{{ session('kode_sapi', 'SP-' . strtoupper(Str::random(5))) }}"
                                class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="penyakit_utama" class="block text-sm font-medium text-gray-700">Penyakit
                                Utama</label>
                            <input type="text" id="penyakit_utama" name="penyakit_utama"
                                value="{{ $diagnosaUtama['penyakit'] ?? 'Tidak Ada Penyakit Utama' }}"
                                class="mt-1 p-2 block w-full border bg-gray-300 border-gray-300 rounded-md" readonly>
                        </div>

                        <!-- Gabungan Gejala & Solusi -->
                        <!-- Gabungan Gejala & Solusi -->
                        <div>
                            <label for="gejala" class="block text-sm font-medium text-gray-700">Gejala dan
                                Solusi</label>
                            <div id="gejala"
                                class="mt-1 p-3 bg-gray-300 border border-gray-300 rounded-md text-justify">
                                @php
                                    // Ambil gejala yang teridentifikasi dari diagnosa
                                    $gejalaTeridentifikasi = $diagnosaUtama['gejala'] ?? [];
                                    // Gabungkan semua gejala (teridentifikasi + tidak teridentifikasi)
                                    $semuaGejala = $gejalaDipilih ?? [];
                                @endphp

                                @if (!empty($semuaGejala))
                                    <h4 class="font-semibold mb-2">Gejala:</h4>
                                    <ol class="list-decimal pl-5">
                                        @foreach ($semuaGejala as $gejala)
                                            <li>
                                                {{ $gejala }}
                                                @if (!in_array($gejala, $gejalaTeridentifikasi))
                                                    <span class="text-red-500 text-sm"> (gejala berpotensi terdapat di
                                                        penyakit alternatif)</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <p>Gejala Tidak Tersedia</p>
                                @endif
                                <h4 class="font-semibold mt-4 mb-2">Saran Rekomendasi:</h4>
                                <p>{{ implode('. ', $diagnosaUtama['solusi'] ?? ['Tidak bisa memberikan rekomendasi yang aman']) }}.
                                </p>
                            </div>
                        </div>


                        @if ($penyakitTertinggi)
                            <div>
                                <label for="penyakit_alternatif_1"
                                    class="block text-sm font-medium text-gray-700">Penyakit Alternatif 1</label>
                                <input type="text" id="penyakit_alternatif_1" name="penyakit_alternatif_1"
                                    value="{{ $penyakitTertinggi }}"
                                    class="mt-1 p-2 block bg-gray-300 w-full border border-gray-300 rounded-md"
                                    readonly>
                            </div>
                        @endif

                        @if ($penyakitKedua)
                            <div>
                                <label for="penyakit_alternatif_2"
                                    class="block text-sm font-medium text-gray-700">Penyakit Alternatif 2</label>
                                <input type="text" id="penyakit_alternatif_2" name="penyakit_alternatif_2"
                                    value="{{ $penyakitKedua }}"
                                    class="mt-1 p-2 block bg-gray-300 w-full border border-gray-300 rounded-md"
                                    readonly>
                            </div>
                        @endif

                        <button type="submit"
                            class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 transition-all duration-300">
                            Simpan Hasil Diagnosa
                        </button>
                    </form>

                </div>
            @else
                <div class="text-center text-red-600 font-medium mt-8">
                    Tidak ada hasil diagnosa yang ditemukan.
                </div>
            @endif

            @php
                $dashboardRoute = match (optional(auth()->user())->role) {
                    'admin' => 'admin.dashboard',
                    'user' => 'diagnosa.result',
                    'ahli pakar' => 'expert.dashboard',
                    default => 'login',
                };
            @endphp

            <div class="text-center mt-6">
                <a href="{{ route($dashboardRoute) }}"
                    class="flex items-center justify-center p-4 rounded-lg border border-orange-500 text-orange-500 
                     hover:bg-orange-500 hover:text-white transition group"><span>Kembali</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6 ml-2 transform transition-transform duration-300 group-hover:translate-x-64">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white mt-12">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>


</body>

</html>
