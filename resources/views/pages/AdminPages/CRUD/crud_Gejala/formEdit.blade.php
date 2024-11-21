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

<body class="bg-orange-100">
    @include('components.dropSettings')

    @if (session('success'))
        <div class="text-green-600 text-sm mb-2 mt-6 text-center">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="text-red-600 text-sm mb-4 text-center">{{ session('error') }}</div>
    @endif

    <div class="bg-white shadow-lg rounded-lg w-full my-10 max-w-lg mx-auto p-6 sm:p-10">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Ternak Sehat" class="w-24 h-24">
        </div>
        <h1 class="text-3xl font-semibold text-center mb-6 text-gray-800">Edit Gejala</h1>

        <!-- Form untuk Mengedit Gejala -->
        <form action="{{ route('gejala.update', ['kode_gejala' => $gejala->kode_gejala]) }}" method="POST">
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
                'ahli pakar' => 'expert.dashboard',
                default => 'login', // Default redirect jika peran tidak dikenali
            };
        @endphp

        <div class="text-center mt-6">
            <a href="{{ route($dashboardRoute) }}" class="text-orange-500 hover:underline">Kembali ke Dashboard</a>
        </div>
    </div>
</body>

</html>
