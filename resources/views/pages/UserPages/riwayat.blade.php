<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Aturan Penyakit</title>
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
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet">
</head>

<body class="bg-orange-100 min-h-full">
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

    @include('components.navbar')
    @include('components.dropSettings')

    <h1 class="text-3xl font-bold text-gray-800 ml-[40%] my-16">Halaman Riwayat</h1>
    <div class="max-w-6xl mx-auto mb-12">
        <div class="flex justify-between items-center mb-4 bg-orange-500 text-white p-3 rounded-lg shadow-md">
            <div>
                <h3 class="text-lg font-semibold">Riwayat Diagnosa</h3>
                <p class="text-sm">Riwayat diagnosa kesehatan sapi</p>
            </div>
            <form method="GET" action="{{ route('riwayatDiagnosa.index') }}" class="mx-4">
                <div class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari nama penyakit ..."
                        class="px-4 py-2 border rounded-md text-black focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">
                        Cari
                    </button>
                </div>
            </form>

        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-sm text-gray-600 border-collapse">
                <thead class="bg-gray-200 border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-2 border text-center">No</th>
                        <th class="px-4 py-2 border text-center">Tanggal Diagnosa</th>
                        <th class="px-4 py-2 border text-center">Kode Riwayat</th>
                        <th class="px-4 py-2 border text-center">Kode Sapi</th>
                        <th class="px-4 py-2 border text-center">Hasil Diagnosa</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatPaginated as $riwayat)
                        <tr class="border hover:bg-gray-50 text-center">
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $loop->iteration + $riwayatPaginated->firstItem() - 1 }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $riwayat->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $riwayat->kode_riwayat }}
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
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data riwayat
                                diagnosa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
                <div class="text-sm text-gray-500">
                    @php
                        // Hitung jumlah penyakit_utama unik di halaman saat ini
                        $penyakitUnikSaatIni = $riwayatPaginated->pluck('penyakit_utama')->unique()->count();

                        // Hitung total jumlah penyakit_utama unik dari semua data
                        $totalPenyakitUnik = \App\Models\RiwayatDiagnosa::distinct('penyakit_utama')->count(
                            'penyakit_utama',
                        );
                    @endphp

                    Menampilkan
                    <b>{{ $riwayatPaginated->firstItem() ?? 0 }}-{{ $riwayatPaginated->firstItem() + $penyakitUnikSaatIni - 1 }}</b>
                    dari {{ $totalPenyakitUnik }}
                </div>
                <div class="flex space-x-2 items-center">
                    {{-- Informasi jumlah --}}
                    <p class="text-sm text-gray-500">
                        Showing {{ $riwayatPaginated->firstItem() ?? 0 }} to
                        {{ $riwayatPaginated->firstItem() + $penyakitUnikSaatIni - 1 }}
                        of {{ $totalPenyakitUnik }}
                    </p>
                    <div class="flex space-x-1">
                        {{-- Tombol Halaman Sebelumnya --}}
                        @if ($riwayatPaginated->onFirstPage())
                            <button
                                class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed">
                                Prev
                            </button>
                        @else
                            <a href="{{ $riwayatPaginated->previousPageUrl() }}"
                                class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
                                Prev
                            </a>
                        @endif

                        {{-- Nomor Halaman --}}
                        @foreach ($riwayatPaginated->getUrlRange(1, $riwayatPaginated->lastPage()) as $page => $url)
                            @if ($page == $riwayatPaginated->currentPage())
                                <button
                                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-white bg-slate-800 border border-slate-800 rounded hover:bg-slate-600 hover:border-slate-600 transition duration-200 ease">
                                    {{ $page }}
                                </button>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Tombol Halaman Selanjutnya --}}
                        @if ($riwayatPaginated->hasMorePages())
                            <a href="{{ $riwayatPaginated->nextPageUrl() }}"
                                class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
                                Next
                            </a>
                        @else
                            <button
                                class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed">
                                Next
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white absolute w-full mt-32">
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
    </script>

</body>

</html>
