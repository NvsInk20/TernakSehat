<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="icon" href="/images/logo.png">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Tambahan untuk gambar background */
        body {
            background: url('/images/bg-login.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Transparansi form */
        .form-card {
            background: rgba(255, 255, 255, 0.85);
            /* Warna putih dengan sedikit transparansi */
            backdrop-filter: blur(10px);
            /* Blur di background */
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
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

    <!-- Container utama -->
    <div class="min-h-screen flex flex-col items-center justify-center relative">
        <!-- Tombol Kembali -->
        <a href="{{ route('landingpage') }}"
            class="absolute top-4 left-4 bg-orange-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-orange-400 transition duration-300 flex items-center group">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 transform transition-transform duration-300 group-hover:-translate-x-1 mr-2"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </a>

        <!-- Card login -->
        <div class="form-card shadow-lg rounded-lg p-8 lg:w-full w-[21rem] max-w-lg relative">
            <!-- Dekorasi latar belakang -->
            <div class="hidden sm:block">
                <div class="absolute -top-6 -left-6 w-20 h-20 bg-orange-300 rounded-full z-0"></div>
                <div class="absolute -bottom-6 -right-6 w-20 h-20 bg-orange-500 rounded-full z-0"></div>
            </div>
            <!-- Konten utama -->
            <div class="relative z-10">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('/images/logo.png') }}" alt="Ternak Sehat" class="w-20 h-20">
                </div>
                <h1 class="text-center text-2xl font-semibold text-gray-800 mb-4">Silahkan Login</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Input Username -->
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-600">Username</label>
                        <input id="username" name="username" type="text" placeholder="Masukkan username"
                            class="w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('username') border-red-500 @enderror"
                            value="{{ old('username') }}" required>
                        @error('username')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                        <input id="password" name="password" type="password" placeholder="Masukkan password"
                            class="w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('password') border-red-500 @enderror"
                            required>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($errors->has('login'))
                        <div class="text-red-500 text-sm mb-4">
                            {{ $errors->first('login') }}
                        </div>
                    @endif

                    <!-- Tombol Login -->
                    <button type="submit"
                        class="w-full bg-orange-500 text-white py-2 rounded-md hover:bg-orange-400 transition duration-300">
                        Login
                    </button>
                </form>

                <!-- Daftar akun -->
                <p class="text-center text-sm text-gray-600 mt-4">
                    Belum punya akun? <a href="/Register"
                        class="text-orange-600 hover:text-orange-400 font-medium">Daftar Sekarang!</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
