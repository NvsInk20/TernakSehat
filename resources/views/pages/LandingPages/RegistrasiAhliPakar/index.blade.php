<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi Ahli Pakar</title>
    <link rel="icon" href="/images/logo.png">
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Flowbite CSS -->
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-orange-100 min-h-screen flex items-center justify-center">
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
    <div class="bg-white shadow-lg rounded-lg mt-10 mb-10 w-full max-w-md mx-auto p-6 sm:p-10 lg:max-w-lg">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Ternak Sehat" class="w-24 h-24">
        </div>
        <h1 class="text-2xl font-semibold text-center mb-6">Registrasi Ahli Pakar</h1>
        <form action="/Register" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Field -->
            <div class="relative mb-6">
                <label for="nama" class="text-gray-600 text-sm">Nama</label>
                <input type="text" id="nama" name="nama" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan nama" value="{{ old('nama') }}">
                @error('nama')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="relative mb-6">
                <label for="email" class="text-gray-600 text-sm">Email</label>
                <input type="email" id="email" name="email" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan email" value="{{ old('email') }}">
                @error('email')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nomor Telepon Field -->
            <div class="relative mb-6">
                <label for="nomor_telp" class="text-gray-600 text-sm">Nomor Telepon (Opsional)</label>
                <input type="text" id="nomor_telp" name="nomor_telp"
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan nomor telepon (opsional)" value="{{ old('nomor_telp') }}">
                @error('nomor_telp')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="relative mb-6">
                <label for="password" class="text-gray-600 text-sm">Password</label>
                <input type="password" id="password" name="password" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan password">
                @error('password')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="relative mb-6">
                <label for="password_confirmation" class="text-gray-600 text-sm">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan ulang password">
                @error('password_confirmation')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Dokumen Pendukung Field (Untuk Ahli Pakar) -->
            <div class="relative mb-6" x-data="{ role: '{{ old('role', 'ahli pakar') }}' }" x-show="role === 'ahli pakar'">
                <label for="dokumen_pendukung" class="text-gray-600 text-sm">Dokumen Pendukung (Wajib)</label>
                <input type="file" id="dokumen_pendukung" name="dokumen_pendukung" accept="application/pdf"
                    class="form-control mt-2 peer h-10 w-full text-gray-900 focus:outline-none focus:border-orange-500">
                @error('dokumen_pendukung')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Spesialis Field -->
            <div class="relative mb-6">
                <label for="spesialis" class="text-gray-600 text-sm">Spesialis</label>
                <input type="text" id="spesialis" name="spesialis" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan spesialis">
                @error('spesialis')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Display Role Field -->
            <div class="relative mb-6">
                <label class="text-gray-600 text-sm">Role</label>
                <input type="text" value="Ahli Pakar" disabled
                    class="bg-gray-200 mt-2 h-10 w-full border-b-2 border-gray-300 text-gray-700 focus:outline-none cursor-not-allowed"
                    placeholder="Ahli Pakar">
            </div>

            <!-- Hidden Role Field for Ahli Pakar -->
            <input type="hidden" name="role" value="ahli pakar">

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-400 text-white font-semibold rounded-md px-6 py-2 mt-3">
                    Daftar
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-orange-500 hover:underline">Kembali ke halaman utama</a>
        </div>
    </div>
</body>

</html>
