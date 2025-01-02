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
    @vite('resources/css/app.css')
    <link rel="icon" href="/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-full">
    @include('components.navbar')
    @include('components.dropSettings')

    <div class="flex -mb-14">
        <div class="flex justify-start ml-10">
            <a href="{{ session('previous_url', route('user.dashboard')) }}"
                class="flex items-center px-4 py-2 rounded-lg border border-blue-500 text-blue-500 
        hover:bg-blue-500 hover:text-white transition duration-300 group shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 mr-2 group-hover:-translate-x-2 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                </svg>
                <span class="text-sm font-medium">Kembali</span>
            </a>
        </div>
        <div class="ml-[25%]">
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Data Penyakit Hewan Ternak Sapi</h1>
        </div>
    </div>


    <div class="max-w-5xl mx-auto mb-12" id="tabelSolusi">
        <div class="flex justify-between items-center mb-4 bg-orange-500 text-white p-3 rounded-lg">
            <div>
                <h3 class="text-lg font-semibold">Sistem Diagnosa Kesehatan Sapi</h3>
                <p class="text-sm">Data Penyakit Kabupaten Boyolali</p>
            </div>
            <form method="GET" action="{{ route('user.aturanPenyakit') }}" class="relative">
                <input
                    class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-200 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                    placeholder="Cari Penyakit..." name="search" value="{{ request('search') }}" />
                <button
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 h-8 w-8 flex items-center justify-center bg-white rounded cursor-pointer"
                    type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-6 h-6 text-slate-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-sm text-gray-600 border-collapse">
                <thead class="bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-2 border text-center">No</th>
                        <th class="px-4 py-2 border text-center">Nama Penyakit</th>
                        <th class="px-4 py-2 border text-center">Gejala</th>
                        <th class="px-4 py-2 border text-center">Solusi</th>
                    </tr>
                </thead>
                @forelse ($penyakitPaginated as $penyakit)
                    @php $aturan = $penyakit->aturanPenyakit; @endphp
                    @foreach ($aturan as $index => $item)
                        <tr class="border hover:bg-gray-50 text-center">
                            {{-- Baris pertama dari penyakit --}}
                            @if ($index === 0)
                                <td class="px-4 py-3 border border-gray-300" rowspan="{{ $aturan->count() }}">
                                    {{-- Hitung nomor berdasarkan halaman --}}
                                    {{ $loop->parent->iteration + $penyakitPaginated->firstItem() - 1 }}
                                </td>
                                <td class="px-4 py-3 border border-gray-300" rowspan="{{ $aturan->count() }}">
                                    {{ $penyakit->nama_penyakit ?? '-' }}
                                </td>
                            @endif
                            {{-- Tampilkan gejala --}}
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $item->gejala->nama_gejala ?? '-' }}
                                <span class="text-gray-500 font-bold">({{ $item->jenis_gejala ?? '-' }})</span>
                            </td>
                            {{-- Baris pertama dari solusi --}}
                            @if ($index === 0)
                                <td class="px-4 py-3 border border-gray-300 text-justify"
                                    rowspan="{{ $aturan->count() }}">
                                    {{ $item->solusi->solusi ?? '-' }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Data tidak ditemukan</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
                <div class="text-sm text-gray-500">
                    Menampilkan
                    <b>{{ $penyakitPaginated->firstItem() ?? 0 }}-{{ $penyakitPaginated->lastItem() ?? 0 }}</b>
                    dari {{ $penyakitPaginated->total() }}
                </div>
                <div class="flex space-x-2 items-center">
                    <p class="text-sm text-gray-500">
                        Showing {{ $penyakitPaginated->firstItem() ?? 0 }} to
                        {{ $penyakitPaginated->lastItem() ?? 0 }}
                        of {{ $penyakitPaginated->total() }}
                    </p>
                    <div class="flex space-x-1">
                        {{-- Tombol Halaman Sebelumnya --}}
                        @if ($penyakitPaginated->onFirstPage())
                            <button
                                class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed">
                                Prev
                            </button>
                        @else
                            <a href="{{ $penyakitPaginated->previousPageUrl() }}"
                                class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
                                Prev
                            </a>
                        @endif

                        {{-- Nomor Halaman --}}
                        @foreach ($penyakitPaginated->getUrlRange(1, $penyakitPaginated->lastPage()) as $page => $url)
                            @if ($page == $penyakitPaginated->currentPage())
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
                        @if ($penyakitPaginated->hasMorePages())
                            <a href="{{ $penyakitPaginated->nextPageUrl() }}"
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

    <script>
        // Tambahkan script tambahan jika diperlukan
    </script>
</body>

</html>
