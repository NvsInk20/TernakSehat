<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perbarui Akun</title>
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

<body class="bg-orange-100">
    @include('components.dropSettings')
    @if (session('success'))
        <div class="bg-green-500 text-white p-3 mb-4 transition-opacity duration-300" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-3 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg w-full my-10 max-w-lg mx-auto p-6 sm:p-10">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('/images/logo.png') }}" alt="Ternak Sehat" class="w-24 h-24">
        </div>
        <h1 class="text-3xl font-semibold text-center mb-6 text-gray-800">Perbarui Akun</h1>

        <!-- Update Profile Form -->
        <form action="{{ route('profile.update', $user->kode_auth) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- This will make the form use PUT method -->

            <!-- Nama Field -->
            <div class="mb-6">
                <label for="nama" class="block text-gray-700 text-sm font-medium">Nama</label>
                <input type="text" id="nama" name="nama" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    value="{{ old('nama', $user->nama) }}">
                @error('nama')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nomor Telepon Field -->
            <div class="relative mb-6">
                <label for="nomor_telp" class="text-gray-600 text-sm">Nomor Telepon (Opsional)</label>
                <input type="text" id="nomor_telp" name="nomor_telp"
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan nomor telepon (opsional)" value="{{ old('nomor_telp', $nomorTelepon) }}">
                <!-- Gunakan $nomorTelepon -->
                @error('nomor_telp')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>



            <!-- Password Field (Optional) -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-medium">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Kosongkan jika tidak ingin mengubah">
                @error('password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Confirmation Field (Optional) -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium">Konfirmasi
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500">
            </div>

            <!-- Field for Ahli Pakar only -->
            @if ($user->role === 'ahli pakar')
                <!-- Spesialis Field -->
                <div class="mb-6">
                    <label for="spesialis" class="block text-gray-700 text-sm font-medium">Spesialis</label>
                    <input type="text" id="spesialis" name="spesialis"
                        class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                        value="{{ old('spesialis', $spesialis) }}">
                    @error('spesialis')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Dokumen Pendukung Field -->
                <div class="mb-6">
                    <label for="dokumen_pendukung" class="block text-gray-700 text-sm font-medium">Dokumen
                        Pendukung</label>

                    <!-- Keterangan file -->
                    @if ($dokumenPendukung)
                        <p class="text-sm text-green-600 mt-1">
                            <span class="font-semibold">File sudah ada</span>
                        </p>
                    @else
                        <p class="text-sm text-red-500 mt-1">
                            <span class="font-semibold">Belum ada dokumen pendukung</span>
                        </p>
                    @endif

                    <!-- Input untuk upload file -->
                    <input type="file" id="dokumen_pendukung" name="dokumen_pendukung"
                        class="mt-2 w-full text-gray-900 border-b-2 border-gray-300 focus:outline-none focus:border-orange-500">
                    @error('dokumen_pendukung')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

            @endif

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-orange-500 text-white text-sm px-6 py-3 rounded-lg 
               hover:bg-orange-600 hover:scale-105 hover:shadow-lg 
               focus:outline-none focus:ring-2 focus:ring-orange-400 
               transition-transform duration-300 ease-in-out">
                    Perbarui Profil
                </button>
            </div>

        </form>
        <div class="text-center mt-6">
            <a href="{{ session('previous_url', route('dashboard')) }}"
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
