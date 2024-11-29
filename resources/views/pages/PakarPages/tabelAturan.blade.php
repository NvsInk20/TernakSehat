<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Aturan Penyakit</title>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Flowbite CSS -->
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

<body class="bg-gray-100 min-h-full flex">

    <!-- Sidebar -->
    @include('components.sidebar')

    <?php
    use Carbon\Carbon;
    ?>
    @if (session('success'))
        <div class="text-green-600 absolute text-sm mb-2 mt-10 ml-[50%] text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="text-red-600 text-sm mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="absolute ml-[83%] mt-10">
        <a href='/aturanPenyakit/add'>
            <button type="button"
                class="border border-blue-800 font-bold text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                Add Items +
            </button>
        </a>
    </div>
    <div class="max-w-[60rem] mx-auto mb-[18%]" id="tabelSolusi">
        <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3 bg-customOrange">
            <div>
                <h3 class="text-lg font-medium text-black">Sistem Diagnosa Kesehatan Sapi</h3>
                <p class="text-white font-bold">Data Aturan Penyakit</p>
            </div>
            <div class="ml-3">
                <div class="w-full max-w-sm min-w-[200px] relative">
                    <form method="GET" action="{{ route('Pakar.aturanPenyakit') }}" class="relative mr-3">
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
            </div>

        </div>

        <div class="bg-white shadow-md mb-10 rounded-lg">
            <table class="w-full table-fixed border-collapse border border-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 text-center">
                    <tr>
                        <th class="px-4 py-3 border border-gray-300 font-semibold w-1/12">No</th>
                        <th class="px-4 py-3 border border-gray-300 font-semibold w-2/12">Nama Penyakit</th>
                        <th class="px-4 py-3 border border-gray-300 font-semibold w-2/12">Gejala</th>
                        <th class="px-4 py-3 border border-gray-300 font-semibold w-4/12">Solusi</th>
                        <th class="px-4 py-3 border border-gray-300 font-semibold w-2/12">Aksi</th>
                    </tr>
                </thead>
                <tbody>
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
                                    <td class="px-4 py-3 border border-gray-300" rowspan="{{ $aturan->count() }}">
                                        <div class="flex justify-center">
                                            <a href="{{ route('aturanPenyakit.edit', $item->kode_relasi) }}">
                                                <button
                                                    class="border border-green-400 font-bold text-green-400 rounded-md px-4 py-2 m-2 hover:text-white hover:bg-green-400">
                                                    Edit
                                                </button>
                                            </a>
                                            <form action="{{ route('aturanPenyakit.destroy', $item->kode_relasi) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="border border-red-500 font-bold text-red-500 rounded-md px-4 py-2 m-2 hover:text-white hover:bg-red-500">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
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
                    @php
                        // Hitung jumlah nama_penyakit unik di halaman saat ini
                        $penyakitUnikSaatIni = $penyakitPaginated->pluck('nama_penyakit')->unique()->count();

                        // Hitung total jumlah nama_penyakit unik dari semua data
                        $totalPenyakitUnik = \App\Models\Penyakit::distinct('nama_penyakit')->count('nama_penyakit');
                    @endphp

                    Menampilkan
                    <b>{{ $penyakitPaginated->firstItem() ?? 0 }}-{{ $penyakitPaginated->firstItem() + $penyakitUnikSaatIni - 1 }}</b>
                    dari {{ $totalPenyakitUnik }}
                </div>
                <div class="flex space-x-2 items-center">
                    <p class="text-sm text-gray-500">
                        Showing {{ $penyakitPaginated->firstItem() ?? 0 }} to
                        {{ $penyakitPaginated->firstItem() + $penyakitUnikSaatIni - 1 }}
                        of {{ $totalPenyakitUnik }}
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


        {{-- <script>
    function toggleDeleteButton() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.disabled = !Array.from(checkboxes).some(checkbox => checkbox.checked);
    }

    function submitDeleteForm() {
        const form = document.getElementById('deleteForm');
        const checkboxes = form.querySelectorAll('input[type="checkbox"]:checked');

        if (checkboxes.length === 0) {
            alert('Silakan pilih setidaknya satu diagnosa untuk dihapus.');
            return;
        }

        if (confirm('Anda yakin ingin menghapus diagnosa yang dipilih?')) {
            form.submit();
        }
    }

    function toggleDetails(id) {
        const detailsRow = document.getElementById(id);
        detailsRow.classList.toggle('hidden');
    }
</script> --}}

</body>

</html>
