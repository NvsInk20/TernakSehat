<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Aturan Penyakit</title>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')
    <link rel="icon" href="/images/logo.png">
</head>

<body class="bg-orange-100">
    @include('components.dropSettings')

    @if (session('success'))
        <div class="text-green-600 text-sm mb-2 mt-6 text-center">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="text-red-600 text-sm mb-4 text-center">{{ session('error') }}</div>
    @endif

    <div class="bg-white shadow-lg rounded-lg w-full my-10 max-w-3xl mx-auto p-6 sm:p-10">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Ternak Sehat" class="w-24 h-24">
        </div>
        <h1 class="text-3xl font-semibold text-center mb-6 text-gray-800">Tambah Aturan Penyakit</h1>

        <form action="{{ route('aturanPenyakit.addItems') }}" method="POST">
            @csrf

            <!-- Kode Relasi -->
            <div class="mb-6">
                <label for="kode_relasi" class="block text-gray-700 text-sm font-medium">Kode Relasi</label>
                <input type="text" id="kode_relasi" name="kode_relasi" readonly value="{{ $kode_relasi }}"
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 bg-gray-100 cursor-not-allowed focus:outline-none">
            </div>

            <!-- Pilih Penyakit -->
            <div class="mb-6">
                <label for="kode_penyakit" class="block text-gray-700 text-sm font-medium">Pilih Penyakit</label>
                <select id="kode_penyakit" name="kode_penyakit" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500">
                    <option value="" disabled>Pilih Penyakit</option>
                    @foreach ($penyakit as $p)
                        <option value="{{ $p->kode_penyakit }}">{{ $p->kode_penyakit }} - {{ $p->nama_penyakit }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Gejala -->
            <div id="gejala-container" class="mb-6 space-y-4">
                <label class="block text-gray-700 text-sm font-medium">Nama Gejala</label>
                <div class="flex items-center space-x-4">
                    <select name="kode_gejala[]" required
                        class="h-12 w-2/3 border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500">
                        <option value="" disabled>Pilih Gejala</option>
                        @foreach ($gejala as $g)
                            <option value="{{ $g->kode_gejala }}">{{ $g->kode_gejala }} - {{ $g->nama_gejala }}
                            </option>
                        @endforeach
                    </select>
                    <select name="jenis_gejala[]" required
                        class="h-12 w-1/3 border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500">
                        <option value="wajib">Wajib</option>
                        <option value="opsional">Opsional</option>
                    </select>
                    <button type="button"
                        class="ml-2 bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 remove-gejala">
                        <span class="font-bold text-lg">-</span>
                    </button>
                </div>
            </div>

            <!-- Tambah Gejala Button -->
            <div class="mb-6 flex justify-center">
                <button type="button" id="tambah-gejala"
                    class="bg-green-500 text-white text-sm px-6 py-3 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-200">
                    Tambah Gejala
                </button>
            </div>

            <!-- Pilih Solusi -->
            <div class="mb-6">
                <label for="kode_solusi" class="block text-gray-700 text-sm font-medium">Pilih Solusi</label>
                <select id="kode_solusi" name="kode_solusi" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500">
                    <option value="" disabled>Pilih Solusi</option>
                    @foreach ($solusi as $s)
                        <option value="{{ $s->kode_solusi }}">{{ $s->kode_solusi }} - {{ $s->solusi }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-orange-500 text-white text-sm px-6 py-3 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-400 transition duration-200">
                    Simpan Aturan Penyakit
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('Admin.aturanPenyakit') }}" class="text-orange-500 hover:underline">Kembali ke
                Dashboard</a>
        </div>
    </div>

    <script>
        // Menambahkan Gejala
        document.getElementById('tambah-gejala').addEventListener('click', function() {
            const gejalaContainer = document.getElementById('gejala-container');
            const newGejala = document.createElement('div');
            newGejala.classList.add('flex', 'items-center', 'space-x-4');
            newGejala.innerHTML = `
                <select name="kode_gejala[]" required class="h-12 w-2/3 border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500">
                    <option value="" disabled>Pilih Gejala</option>
                    @foreach ($gejala as $g)
                        <option value="{{ $g->kode_gejala }}">{{ $g->kode_gejala }} - {{ $g->nama_gejala }}</option>
                    @endforeach
                </select>
                <select name="jenis_gejala[]" required class="h-12 w-1/3 border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500">
                    <option value="wajib">Wajib</option>
                    <option value="opsional">Opsional</option>
                </select>
                <button type="button" class="ml-2 bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 remove-gejala"><span class="font-bold text-lg">-</span></button>
            `;
            gejalaContainer.appendChild(newGejala);
        });

        // Menghapus Gejala
        document.getElementById('gejala-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-gejala')) {
                e.target.closest('.flex').remove();
            }
        });
    </script>
</body>

</html>
