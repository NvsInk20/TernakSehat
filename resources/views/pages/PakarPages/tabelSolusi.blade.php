<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Solusi</title>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <div class="max-w-[60rem] mx-auto mb-[18%]" id="tabelSolusi">
        <div class="relative flex items-center justify-between">
            <!-- Dropdown Menu -->
            <div>
                @include('components.dropmenu')
            </div>

            <!-- Add Items Button -->
            <div>
                <a href="/solusi/add">
                    <button type="button"
                        class="border border-blue-800 font-bold text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease-in-out select-none hover:text-white hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                        Add Items +
                    </button>
                </a>
            </div>
        </div>

        <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3 bg-customOrange">
            <div>
                <h3 class="text-lg font-medium text-black">Sistem Diagnosa Kesehatan Sapi</h3>
                <p class="text-white font-bold">Data Solusi</p>
            </div>
            <div class="ml-3">
                <div class="w-full max-w-sm min-w-[200px] relative">
                    <form method="GET" action="{{ route('Pakar.solusi') }}" class="relative mr-3">
                        <input
                            class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-200 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                            placeholder="Cari solusi..." name="search" value="{{ request('search') }}" />
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

        <div class="bg-white shadow-md rounded-lg">
            <table class="w-full table-fixed text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 text-center">
                    <tr>
                        <th class="px-6 py-3 border border-gray-300 font-semibold w-1/12">No</th>
                        <th class="px-6 py-3 border border-gray-300 font-semibold w-2/12">Kode Solusi</th>
                        <th class="px-6 py-3 border border-gray-300 font-semibold w-5/12">Deskripsi Solusi</th>
                        <th class="px-6 py-3 border border-gray-300 font-semibold w-2/12">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($solusi as $index => $item)
                        <tr class="border-b hover:bg-gray-50 text-center">
                            <td class="px-6 border py-4 border-gray-300">{{ $solusi->firstItem() + $index }}</td>
                            <td class="px-6 border py-4 border-gray-300">{{ $item->kode_solusi }}</td>
                            <td class="px-6 border py-4 border-gray-300 text-justify">{{ $item->solusi }}</td>
                            <td class="px-6 py-4 border border-gray-300">
                                <div class="flex justify-center">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('solusi.edit', $item->kode_solusi) }}">
                                        <button type="button"
                                            class="border border-green-400 font-bold text-green-400 rounded-md px-4 py-2 m-2 hover:text-white hover:bg-green-400">
                                            Edit
                                        </button>
                                    </a>

                                    <!-- Form Delete -->
                                    <form action="{{ route('solusi.destroy', $item->kode_solusi) }}" method="POST"
                                        id="deleteForm-{{ $item->kode_solusi }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="border border-red-500 font-bold text-red-500 rounded-md px-4 py-2 m-2 hover:text-white hover:bg-red-500">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
                <div class="text-sm text-gray-500">
                    Menampilkan <b>{{ $solusi->firstItem() ?? 0 }}-{{ $solusi->lastItem() ?? 0 }}</b> dari
                    {{ $solusi->total() }}
                </div>
                <div class="flex space-x-2 items-center">
                    <p class="text-sm text-gray-500">Showing {{ $solusi->firstItem() ?? 0 }} to
                        {{ $solusi->lastItem() ?? 0 }} of {{ $solusi->total() }}</p>
                    <div class="flex space-x-1">
                        @if ($solusi->onFirstPage())
                            <button
                                class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-gray-400 bg-white border border-gray-200 rounded cursor-not-allowed">
                                Prev
                            </button>
                        @else
                            <a href="{{ $solusi->previousPageUrl() }}"
                                class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
                                Prev
                            </a>
                        @endif

                        @foreach ($solusi->getUrlRange(1, $solusi->lastPage()) as $page => $url)
                            @if ($page == $solusi->currentPage())
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

                        @if ($solusi->hasMorePages())
                            <a href="{{ $solusi->nextPageUrl() }}"
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
