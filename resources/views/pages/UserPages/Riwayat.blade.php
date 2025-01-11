<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Riwayat Pengguna</title>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <link rel="icon" href="/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-orange-100 min-h-screen flex flex-col">
    @if (session('success'))
        <div class="bg-green-500 text-white lg:p-3 pl-16 p-3 2xl:text-2xl rounded mb-4 transition-opacity duration-300"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white lg:p-3 pl-16 p-3 2xl:text-2xl rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex-none">
        @include('components.navbar')
        <div class="hidden sm:block">
            @include('components.dropSettings')
        </div>
    </div>

    <h1
        class="text-2xl sm:text-3xl mt-20 2xl:mt-0 xl:mt-0 font-bold text-gray-800 text-center 2xl:ml-[2%] 2xl:text-4xl my-8 sm:my-16">
        Halaman Riwayat
    </h1>
    <div class="max-w-xs sm:max-w-lg md:max-w-2xl xl:max-w-6xl mx-auto mb-8 sm:mb-12 2xl:ml-60 flex-grow">
        <div
            class="flex flex-col sm:flex-row justify-between items-center sm:items-start 2xl:w-[90rem] mb-4 bg-orange-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-center sm:text-left">
                <h3 class="text-lg sm:text-xl 2xl:text-2xl font-semibold">Ternak Sehat</h3>
                <p class="text-sm sm:text-base 2xl:text-xl mt-1 sm:mt-2">Riwayat diagnosa kesehatan sapi</p>
            </div>
            <form method="GET" action="{{ route('riwayatDiagnosa.index') }}" class="w-full sm:w-auto mt-4 sm:mt-0">
                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari (YYYY-MM-DD, Januari, 2025)"
                        class="w-full sm:w-auto px-4 py-2 border rounded-md text-black text-sm sm:text-base 2xl:text-xl focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white text-sm sm:text-base 2xl:text-xl rounded-md hover:bg-blue-700 focus:outline-none">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg 2xl:w-[90rem] shadow-md overflow-hidden 2xl:text-xl">
            <table class="hidden sm:table w-full text-sm text-gray-600 border-collapse">
                <thead class="bg-gray-200 border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-2 2xl:text-xl border text-center">No</th>
                        <th class="px-4 py-2 2xl:text-xl border text-center">Tanggal Diagnosa</th>
                        <th class="px-4 py-2 2xl:text-xl border text-center">Nama Pengguna</th>
                        <th class="px-4 py-2 2xl:text-xl border text-center">Kode Sapi</th>
                        <th class="px-4 py-2 2xl:text-xl border text-center">Hasil Diagnosa</th>
                        <th class="px-4 py-2 2xl:text-xl border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatPaginated as $riwayat)
                        <tr class="border 2xl:text-xl hover:bg-gray-50 text-center">
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $loop->iteration + $riwayatPaginated->firstItem() - 1 }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $riwayat->created_at->translatedFormat('d F Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $riwayat->nama }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $riwayat->kode_sapi }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                @if (!empty($riwayat->penyakit_utama))
                                    {{ $riwayat->penyakit_utama }} <span class="text-blue-500">(Penyakit Utama)</span>
                                @else
                                    @if (!empty($riwayat->penyakit_alternatif_1))
                                        {{ $riwayat->penyakit_alternatif_1 }} <span class="text-orange-500">(Penyakit
                                            Alternatif 1)</span>
                                    @endif
                                    @if (!empty($riwayat->penyakit_alternatif_2))
                                        @if (!empty($riwayat->penyakit_alternatif_1))
                                            <br>
                                        @endif
                                        {{ $riwayat->penyakit_alternatif_2 }} <span class="text-orange-500">(Penyakit
                                            Alternatif 2)</span>
                                    @endif
                                    @if (empty($riwayat->penyakit_alternatif_1) && empty($riwayat->penyakit_alternatif_2))
                                        <span class="text-gray-400">Tidak ada hasil diagnosa</span>
                                    @endif
                                @endif
                            </td>

                            <td class="px-4 py-3 border border-gray-300">
                                <div class="flex justify-center space-x-2">
                                    <form id="deleteForm-{{ $riwayat->kode_riwayat }}"
                                        action="{{ route('riwayatDiagnosa.destroy', $riwayat->kode_riwayat) }}"
                                        method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <button onclick="confirmDelete('{{ $riwayat->kode_riwayat }}')"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none">
                                        Hapus
                                    </button>

                                    <a href="{{ route('riwayatDiagnosa.pdf', $riwayat->kode_riwayat) }}"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none">
                                        Cetak PDF
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 2xl:text-xl text-center text-gray-500">Tidak ada data
                                riwayat
                                diagnosa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Tampilan alternatif untuk layar kecil -->
            <div class="sm:hidden">
                @forelse ($riwayatPaginated as $riwayat)
                    <div class="border  w-[21rem] rounded-lg p-4 mb-4 shadow-md bg-gray-100">
                        <p><strong>No:</strong> {{ $loop->iteration + $riwayatPaginated->firstItem() - 1 }}</p>
                        <p><strong>Tanggal Diagnosa:</strong>
                            {{ $riwayat->created_at->translatedFormat('d F Y, H:i') }}</p>
                        <p><strong>Nama Pengguna:</strong> {{ $riwayat->nama }}</p>
                        <p><strong>Kode Sapi:</strong> {{ $riwayat->kode_sapi }}</p>
                        <p><strong>Hasil Diagnosa:</strong>
                            @if (!empty($riwayat->penyakit_utama))
                                {{ $riwayat->penyakit_utama }} <span class="text-blue-500">(Penyakit Utama)</span>
                            @else
                                @if (!empty($riwayat->penyakit_alternatif_1))
                                    {{ $riwayat->penyakit_alternatif_1 }} <span class="text-orange-500">(Penyakit
                                        Alternatif 1)</span>
                                @endif
                                @if (!empty($riwayat->penyakit_alternatif_2))
                                    @if (!empty($riwayat->penyakit_alternatif_1))
                                        <br>
                                    @endif
                                    {{ $riwayat->penyakit_alternatif_2 }} <span class="text-orange-500">(Penyakit
                                        Alternatif 2)</span>
                                @endif
                                @if (empty($riwayat->penyakit_alternatif_1) && empty($riwayat->penyakit_alternatif_2))
                                    <span class="text-gray-400">Tidak ada hasil diagnosa</span>
                                @endif
                            @endif
                        </p>
                        <div class="flex justify-start space-x-2 mt-2">
                            <button onclick="confirmDelete('{{ $riwayat->kode_riwayat }}')"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none">
                                Hapus
                            </button>
                            <a href="{{ route('riwayatDiagnosa.pdf', $riwayat->kode_riwayat) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none">
                                Cetak PDF
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500">Tidak ada data riwayat diagnosa</div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div
                class="flex flex-col sm:flex-row justify-between items-center px-4 py-4 bg-gray-50 space-y-4 sm:space-y-0">
                <!-- Informasi Jumlah Data -->
                <div class="text-xs sm:text-sm 2xl:text-lg text-gray-500 text-center sm:text-left">
                    @php
                        // Hitung jumlah penyakit_utama unik di halaman saat ini
                        $penyakitUnikSaatIni = $riwayatPaginated->pluck('penyakit_utama')->unique()->count();

                        // Hitung total jumlah penyakit_utama unik dari semua data
                        $totalPenyakitUnik = \App\Models\RiwayatDiagnosa::distinct('penyakit_utama')->count(
                            'penyakit_utama',
                        );
                    @endphp

                    Menampilkan
                    <b>{{ $riwayatPaginated->firstItem() ?? 0 }}-{{ $riwayatPaginated->lastItem() ?? 0 }}</b>
                    dari {{ $riwayatPaginated->total() }}
                </div>

                <!-- Tombol PDF dan Hapus Semua -->
                <div
                    class="flex flex-col xl:ml-[25rem] 2xl:ml-[50rem] sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <a href="{{ route('riwayatDiagnosa.cetakSemuaPDFGabungan') }}"
                        class="w-full sm:w-auto text-center px-3 py-2 text-sm bg-green-500 hover:bg-green-600 text-white rounded">
                        Cetak Semua PDF
                    </a>

                    <form id="deleteAllForm" action="{{ route('riwayatDiagnosa.hapusSemua') }}" method="POST"
                        class="w-full sm:w-auto">
                        @csrf
                        <button type="submit"
                            class="w-full sm:w-auto text-center px-3 py-2 text-sm bg-red-600 hover:bg-red-700 text-white rounded">
                            Hapus Semua
                        </button>
                    </form>
                </div>

                <!-- Navigasi Pagination -->
                <div class="flex flex-wrap justify-center items-center space-x-1">
                    {{-- Tombol Halaman Sebelumnya --}}
                    @if ($riwayatPaginated->onFirstPage())
                        <button
                            class="px-3 py-2 text-xs sm:text-sm text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed">
                            Prev
                        </button>
                    @else
                        <a href="{{ $riwayatPaginated->previousPageUrl() }}"
                            class="px-3 py-2 text-xs sm:text-sm text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
                            Prev
                        </a>
                    @endif

                    {{-- Nomor Halaman --}}
                    @foreach ($riwayatPaginated->getUrlRange(1, $riwayatPaginated->lastPage()) as $page => $url)
                        @if ($page == $riwayatPaginated->currentPage())
                            <button
                                class="px-3 py-2 text-xs sm:text-sm text-white bg-slate-800 border border-slate-800 rounded hover:bg-slate-600 hover:border-slate-600 transition duration-200 ease">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-2 text-xs sm:text-sm text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Tombol Halaman Selanjutnya --}}
                    @if ($riwayatPaginated->hasMorePages())
                        <a href="{{ $riwayatPaginated->nextPageUrl() }}"
                            class="px-3 py-2 text-xs sm:text-sm text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
                            Next
                        </a>
                    @else
                        <button
                            class="px-3 py-2 text-xs sm:text-sm text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed">
                            Next
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white 2xl:text-xl 2xl:mt-auto w-full mt-32">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>

    <script>
        function confirmDelete(kode_riwayat) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm-${kode_riwayat}`).submit();
                }
            });
        }

        // Konfirmasi untuk Hapus Semua
        document.getElementById('deleteAllForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form langsung submit

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Semua data riwayat diagnosa akan dihapus dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, kirimkan form
                    this.submit();
                }
            });
        });
    </script>

</body>

</html>
