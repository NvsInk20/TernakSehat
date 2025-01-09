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
</head>

<body class="bg-gray-100 min-h-full">
    @include('components.navbar')
    <div class="hidden sm:block">
        @include('components.dropSettings')
    </div>

    <div class="flex flex-col sm:flex-row 2xl:-mb-40 mt-32 xl:-mb-16 xl:mt-0 2xl:mt-0">
        <div
            class="flex hidden sm:block justify-center sm:justify-start mb-4 sm:mb-0 ml-0 sm:ml-10 2xl:ml-16 2xl:mt-12">
            <a href="{{ session('previous_url', route('user.dashboard')) }}"
                class="flex items-center px-4 py-2 rounded-lg border border-blue-500 text-blue-500 
        hover:bg-blue-500 hover:text-white transition duration-300 group shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 2xl:w-7 2xl:h-7 mr-2 group-hover:-translate-x-2 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                </svg>
                <span class="text-sm 2xl:text-xl font-medium">Kembali</span>
            </a>
        </div>
        <div class="text-center sm:ml-[23%]  2xl:ml-[29%]">
            <h1 class="xl:text-2xl ml-5 2xl:text-2xl text-lg font-extrabold text-gray-800 tracking-wide">Data Penyakit
                Hewan Ternak Sapi</h1>
        </div>
    </div>

    <div class="max-w-full sm:max-w-5xl 2xl:ml-80 mx-auto mb-36 px-4 sm:px-0" id="tabelSolusi">
        <div
            class="flex flex-col sm:flex-row 2xl:w-[80rem] justify-between items-center mb-4 bg-orange-500 text-white p-3 rounded-lg">
            <div class="text-center sm:text-left">
                <h3 class="text-lg 2xl:text-xl font-semibold">Sistem Diagnosa Kesehatan Sapi</h3>
                <p class="text-sm 2xl:text-md">Data Penyakit Kabupaten Boyolali</p>
            </div>
            <form method="GET" action="{{ route('user.aturanPenyakit') }}"
                class="relative mt-4 sm:mt-0 w-full sm:w-auto">
                <input
                    class="bg-white w-full pr-11 2xl:text-xl h-10 pl-3 py-2 placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-200 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
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

        <div class="bg-white rounded-lg shadow-md overflow-x-auto sm:overflow-hidden 2xl:w-[80rem]">
            <table class="w-full text-sm text-gray-600 border-collapse">
                <thead class="bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-2 2xl:text-xl border text-center">No</th>
                        <th class="px-4 py-2 2xl:text-xl border text-center">Nama Penyakit</th>
                        <th class="px-4 py-2 2xl:text-xl border text-center">Gejala</th>
                        <th class="px-4 py-2 2xl:text-xl border text-center">Rekomendasi</th>
                    </tr>
                </thead>
                @forelse ($penyakitPaginated as $penyakit)
                    @php $aturan = $penyakit->aturanPenyakit; @endphp
                    @foreach ($aturan as $index => $item)
                        <tr class="border 2xl:text-xl hover:bg-gray-50 text-center">
                            @if ($index === 0)
                                <td class="px-4 py-3 border border-gray-300" rowspan="{{ $aturan->count() }}">
                                    {{ $loop->parent->iteration + $penyakitPaginated->firstItem() - 1 }}
                                </td>
                                <td class="px-4 py-3 border border-gray-300" rowspan="{{ $aturan->count() }}">
                                    {{ $penyakit->nama_penyakit ?? '-' }}
                                </td>
                            @endif
                            <td class="px-4 py-3 border border-gray-300">
                                {{ $item->gejala->nama_gejala ?? '-' }}
                                <span class="text-gray-500 font-bold">({{ $item->jenis_gejala ?? '-' }})</span>
                            </td>
                            @if ($index === 0)
                                <td class="px-4 py-3 border border-gray-300 text-justify"
                                    rowspan="{{ $aturan->count() }}">
                                    {{ $item->rekomendasi->rekomendasi ?? '-' }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </table>
            <div
                class="flex flex-row sm:flex-row justify-between items-center text-sm 2xl:text-xl px-6 py-4 bg-gray-50">
                <div class="text-center hidden sm:block sm:text-left text-gray-500">
                    Menampilkan
                    <b>{{ $penyakitPaginated->firstItem() ?? 0 }}-{{ $penyakitPaginated->lastItem() ?? 0 }}</b>
                    dari {{ $penyakitPaginated->total() }}
                </div>
                <div class="flex justify-center sm:justify-end space-x-1 items-center">
                    @if ($penyakitPaginated->onFirstPage())
                        <button
                            class="px-3 py-1 text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed">
                            Prev
                        </button>
                    @else
                        <a href="{{ $penyakitPaginated->previousPageUrl() }}"
                            class="px-3 py-1 text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50">
                            Prev
                        </a>
                    @endif

                    @foreach ($penyakitPaginated->getUrlRange(1, $penyakitPaginated->lastPage()) as $page => $url)
                        @if ($page == $penyakitPaginated->currentPage())
                            <button class="px-3 py-1 text-white bg-slate-800 border border-slate-800 rounded">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-1 text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($penyakitPaginated->hasMorePages())
                        <a href="{{ $penyakitPaginated->nextPageUrl() }}"
                            class="px-3 py-1 text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50">
                            Next
                        </a>
                    @else
                        <button
                            class="px-3 py-1 text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed">
                            Next
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
