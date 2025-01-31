<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Gejala</title>
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

<body class="bg-orange-100 min-h-screen flex items-center justify-center">
    @include('components.dropSettings')

    @if (session('success') || session('error'))
        <div class="absolute top-0 left-0 w-full shadow-lg z-50 transition-opacity duration-300" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)"
            :class="{
                'bg-green-500': '{{ session('success') }}',
                'bg-red-500': '{{ session('error') }}'
            }">
            <div class="flex items-start justify-between px-4 py-3">
                <!-- Bagian Kiri (Ikon dan Pesan) -->
                <div class="flex flex-none items-center space-x-2">
                    @if (session('success'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-white text-sm font-medium">{{ session('success') }}</span>
                    @endif

                    @if (session('error'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="text-white text-sm font-medium">{{ session('error') }}</span>
                    @endif
                </div>

                <!-- Bagian Kanan (Tombol Close) -->
                <button @click="show = false" class="flex-none text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg w-full xl:my-24 max-w-lg mx-auto p-6 sm:p-10">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('/images/logo.png') }}" alt="Ternak Sehat" class="w-24 h-24">
        </div>
        <h1 class="text-3xl font-semibold text-center mb-6 text-gray-800">Edit Gejala</h1>

        <!-- Form untuk Mengedit Gejala -->
        <form action="{{ route('gejalaPakar.update', ['kode_gejala' => $gejala->kode_gejala]) }}" method="POST"
            enctype="multipart/form-data" x-data="{ items: [] }">
            @csrf
            @method('PUT')

            <!-- Kode Penyakit Field (readonly) -->
            <div class="mb-6">
                <label for="kode_gejala" class="block text-gray-700 text-sm font-medium">Kode Gejala</label>
                <input type="text" name="kode_gejala" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    value="{{ $gejala->kode_gejala }}" readonly>
            </div>

            <!-- Nama Penyakit Field -->
            <div class="mb-6">
                <label for="nama_gejala" class="block text-gray-700 text-sm font-medium">Nama Gejala</label>
                <input type="text" id="nama_gejala" name="nama_gejala" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    value="{{ old('nama_gejala', $gejala->nama_gejala) }}">
                @error('nama_gejala')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <!-- Field Deskripsi -->
            <div class="mb-6">
                <label for="deskripsi" class="block text-gray-700 text-sm font-medium">Deskripsi Singkat Pengecekan
                    Gejala <span class="text-red-500">(Opsional)</span></label>
                <textarea id="deskripsi" name="deskripsi"
                    class="mt-2 w-full h-32 border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500 resize-none">{{ old('deskripsi', $gejala->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6 space-y-4">
                <label class="block text-sm font-medium text-gray-700">Foto Dokumen
                    dan Deskripsi Lengkap Pengecekan Gejala <span class="text-red-500">(Opsional)</span></label>
                @foreach ($fotoDokumen as $index => $foto)
                    <div class="space-y-2 border rounded-lg border-gray-600 p-4 shadow-sm relative"
                        x-data="{ showDelete: false }">
                        <!-- Gambar Lama -->
                        <div class="mb-4">
                            <!-- Nomor Urut -->
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-gray-700">Panduan ke
                                    -<span>{{ $loop->iteration }}</span></span>
                            </div>
                            <p class="text-sm font-semibold mb-2 flex justify-between items-center">
                                Gambar Lama
                                <!-- Tombol Hapus -->
                                <!-- Tombol Hapus pada gambar lama -->
                                <button type="button"
                                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-150 ease-in-out"
                                    onclick="removeItemAndDeleteFromStorage({{ $index }}, '{{ $foto }}', '{{ $gejala->kode_gejala }}')">
                                    Hapus
                                </button>

                            </p>
                            <div class="p-3 bg-gray-100 rounded-md shadow-sm">
                                <!-- Nama Gambar -->
                                <p class="text-gray-700 text-sm font-medium mb-2">Deskripsi : <span
                                        class="text-blue-600">Gambar Gejala</span></p>
                                <!-- Gambar -->
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Dokumen"
                                    class="w-32 h-32 rounded-md shadow mb-3">

                            </div>
                        </div>


                        <!-- Input Gambar Baru -->
                        <input type="file" name="foto_dokumen[{{ $index }}]" accept="image/*"
                            class="block w-full border-gray-300 rounded-md shadow-sm mt-2">

                        <!-- Deskripsi Panduan -->
                        <textarea name="deskripsi_panduan[{{ $index }}]"
                            class="block w-full h-20 border-gray-300 rounded-md shadow-sm mt-2">{{ old('deskripsi_panduan.' . $index, $deskripsiPanduan[$index] ?? '') }}</textarea>
                    </div>
                @endforeach

                <!-- Tombol Tambah -->
                <div class="flex justify-center">
                    <button type="button" id="add-item"
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:ring-2 focus:ring-green-300">
                        Tambah Gambar
                    </button>
                </div>
            </div>

            <script>
                document.getElementById('add-item').addEventListener('click', function() {
                    const container = document.querySelector('.mb-6.space-y-4');

                    const newItem = document.createElement('div');
                    newItem.classList.add('space-y-2', 'border', 'rounded-lg', 'p-4', 'shadow-sm', 'relative',
                        'border-gray-700');
                    // Calculate the panduan number based on the current items already in the container
                    const panduanNumber = container.querySelectorAll('.space-y-2').length + 1;
                    newItem.innerHTML = `
                                            <div class="flex items-center space-x-2">
                            <span class="font-bold text-gray-700">Panduan ke -<span>${panduanNumber}</span></span>
                        </div>
                    <div class="flex items-center space-x-4">
                        <input type="file" name="foto_dokumen[]" accept="image/*" class="block w-full border-gray-300 rounded-md shadow-sm mt-2">
                        <button type="button" class="ml-auto bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 delete-item">
                            Hapus
                        </button>
                    </div>
                    <textarea name="deskripsi_panduan[]" class="block w-full h-20 border-gray-300 rounded-md shadow-sm mt-2"></textarea>
                    `;

                    container.insertBefore(newItem, document.getElementById('add-item').parentElement);

                    const deleteButton = newItem.querySelector('.delete-item');
                    deleteButton.addEventListener('click', function() {
                        newItem.remove(); // Hapus elemen DOM
                    });
                });

                // Menghapus item gambar lama dengan konfirmasi
                function removeItemAndDeleteFromStorage(index, foto, kodeGejala) {
                    const confirmation = window.confirm("Apakah Anda yakin ingin menghapus gambar dan deskripsi ini?");
                    if (confirmation) {
                        console.log(JSON.stringify({
                            foto: foto,
                            kode_gejala: kodeGejala
                        }))
                        fetch('/hapus-gambar', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    "Accept": "application/json",
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    foto: foto,
                                    kode_gejala: kodeGejala
                                }),
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.text().then(text => {
                                        throw new Error(text);
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log(data)
                                if (data.success) {
                                    alert('Gambar berhasil dihapus.');
                                    location.reload();
                                } else {
                                    alert('Gagal menghapus gambar: ' + data.message);
                                }
                            })
                            .catch(error => {
                                alert('Terjadi kesalahan: ' + error.message);
                            });

                    }
                }


                // Fungsi untuk memperbarui data gambar yang tersisa di halaman setelah penghapusan
                function updateImageData() {
                    // Mendapatkan semua elemen gambar di halaman
                    const images = document.querySelectorAll('.space-y-2');

                    // Update logika di sini untuk memperbarui data gambar yang tersisa jika perlu
                    // Misalnya, Anda bisa meng-update daftar gambar atau melakukan pengolahan lainnya
                    // Namun, jika hanya ingin memperbarui tampilan halaman, maka cukup memastikan
                    // bahwa elemen gambar yang telah dihapus tidak lagi muncul di halaman.
                }
            </script>



            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-orange-500 text-white text-sm px-6 py-3 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-400 transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
        @php
            // Menentukan rute dashboard berdasarkan peran pengguna
            $dashboardRoute = match (auth()->user()->role) {
                'admin' => 'Admin.gejala',
                'user' => 'user.dashboard',
                'ahli pakar' => 'Pakar.gejala',
                default => 'login', // Default redirect jika peran tidak dikenali
            };
        @endphp

        <div class="text-center mt-6">
            <a href="{{ route($dashboardRoute) }}"
                class="flex items-center justify-center p-4 rounded-lg border border-orange-500 text-orange-500 
        hover:bg-orange-500 hover:text-white transition group">
                <span>Kembali</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 ml-2 transform transition-transform duration-300 group-hover:translate-x-40">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</body>

</html>
