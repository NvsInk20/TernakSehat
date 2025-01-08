<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Flowbite CSS -->
    <link rel="icon" href="/images/logo.png">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        /* Tambahan untuk styling latar belakang */
        body {
            background: url('/images/bg-registrasi.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body class="font-sans">
    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 transition-opacity duration-300" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4 transition-opacity duration-300" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tombol Kembali -->
    <a href="{{ route('login') }}"
        class="absolute top-4 left-4 bg-orange-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-orange-400 transition duration-300 flex items-center group">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 transform transition-transform duration-300 group-hover:-translate-x-1 mr-2" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Kembali</span>
    </a>

    <!-- Registrasi Pengguna -->
    <div class="flex flex-col items-center justify-center min-h-screen">
        <section
            class="bg-white shadow-lg rounded-lg p-8 w-[21rem] lg:w-full max-w-3xl relative bg-opacity-90 backdrop-blur-md">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Registrasi</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ahli Pakar -->
                <div
                    class="flex flex-col items-center text-center bg-gray-100 bg-opacity-80 p-6 rounded-lg shadow-md transition-transform transform hover:-translate-y-2 hover:bg-orange-200 hover:shadow-lg duration-300">
                    <a href="/RegistrasiAhliPakar" class="flex flex-col items-center">
                        <img src="{{ asset('/images/ahlipakar.png') }}" alt="Ahli Pakar" class="w-24 h-24 mb-4">
                        <p class="text-lg font-medium text-gray-700">Ahli Pakar</p>
                    </a>
                </div>

                <!-- User (Peternak) -->
                <div
                    class="flex flex-col items-center text-center bg-gray-100 bg-opacity-80 p-6 rounded-lg shadow-md transition-transform transform hover:-translate-y-2 hover:bg-orange-200 hover:shadow-lg duration-300">
                    <a href="/RegistrasiUser" class="flex flex-col items-center">
                        <img src="{{ asset('/images/peternak.png') }}" alt="User (Peternak)" class="w-24 h-24 mb-4">
                        <p class="text-lg font-medium text-gray-700">User (Peternak)</p>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

</html>
