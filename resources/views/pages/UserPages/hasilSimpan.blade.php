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
        <div class="text-green-600 text-sm mb-2 mt-6 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="text-red-600 text-sm mb-4 text-center">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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

            @if ($diagnosaUtama || $penyakitTertinggi || $penyakitKedua)
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Simpan Hasil Diagnosa</h3>
                    <form method="POST" action="{{ route('diagnosa.simpanHasil') }}"
                        class="space-y-4 bg-gray-100 p-6 rounded-lg shadow-lg">
                        @csrf

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                            <input type="text" id="nama" name="nama"
                                value="{{ auth()->user()->nama ?? 'Nama Tidak Diketahui' }}"
                                class="mt-1 p-2 block w-full border border-gray-300 rounded-md" readonly>
                        </div>

                        <div>
                            <label for="kode_sapi" class="block text-sm font-medium text-gray-700">Kode Sapi</label>

                            <input type="text" id="kode_sapi" name="kode_sapi"
                                value="SP-{{ strtoupper(Str::random(5)) }}"
                                class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        </div>

                        @if ($diagnosaUtama)
                            <div>
                                <label for="penyakit_utama" class="block text-sm font-medium text-gray-700">Penyakit
                                    Utama</label>
                                <input type="text" id="penyakit_utama" name="penyakit_utama"
                                    value="{{ $diagnosaUtama['penyakit'] ?? 'Tidak Ada Penyakit Utama' }}"
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md" readonly>
                            </div>

                            <div>
                                <label for="gejala" class="block text-sm font-medium text-gray-700">Gejala</label>
                                <textarea id="gejala" name="gejala" rows="3"
                                    class="mt-1 p-2 block w-full border border-gray-300 text-justify rounded-md" readonly>
                                    {{ !empty($diagnosaUtama['gejala']) ? implode(', ', $diagnosaUtama['gejala']) : 'Gejala Tidak Tersedia' }}
                                </textarea>
                            </div>

                            <div>
                                <label for="solusi" class="block text-sm font-medium text-gray-700">Solusi</label>
                                <textarea id="solusi" name="solusi" rows="3"
                                    class="mt-1 p-2 block w-full border border-gray-300 text-justify rounded-md" readonly>
                                    {{ !empty($diagnosaUtama['solusi']) ? implode(', ', $diagnosaUtama['solusi']) : 'Solusi Tidak Tersedia' }}
                                </textarea>
                            </div>
                        @else
                            <div class="text-red-600 text-sm">
                                Penyakit utama tidak ditemukan.
                            </div>
                        @endif

                        @if ($penyakitTertinggi)
                            <div>
                                <label for="penyakit_alternatif_1"
                                    class="block text-sm font-medium text-gray-700">Penyakit Alternatif 1</label>
                                <input type="text" id="penyakit_alternatif_1" name="penyakit_alternatif_1"
                                    value="{{ $penyakitTertinggi }}"
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md" readonly>
                            </div>
                        @endif

                        @if ($penyakitKedua)
                            <div>
                                <label for="penyakit_alternatif_2"
                                    class="block text-sm font-medium text-gray-700">Penyakit Alternatif 2</label>
                                <input type="text" id="penyakit_alternatif_2" name="penyakit_alternatif_2"
                                    value="{{ $penyakitKedua }}"
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md" readonly>
                            </div>
                        @endif

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 transition-all duration-300">
                                Simpan Hasil Diagnosa
                            </button>
                        </div>
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
                <a href="{{ route($dashboardRoute) }}" class="text-orange-500 hover:underline">Kembali ke Dashboard</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white mt-12">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>


</body>

</html>
