<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Diagnosa</title>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
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

<body class="bg-orange-100 font-sans">
    <!-- Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="flex flex-col items-center justify-center" id="diagnosaContent">
        <!-- Judul Halaman -->
        <h1 class="text-3xl font-bold text-gray-800 mb-16">Halaman Diagnosa</h1>

        <!-- Kontainer Pertanyaan -->
        <div class="relative bg-white rounded-lg shadow-xl p-12 text-center max-w-lg w-full">
            <!-- Latar belakang kotak miring oranye -->
            <div
                class="absolute bg-orange-300 rounded-lg transform -rotate-6 -z-10 top-6 left-6 w-full h-full scale-110">
            </div>
            <div
                class="absolute bg-orange-400 rounded-lg transform -rotate-3 -z-20 top-10 left-10 w-full h-full scale-110">
            </div>

            <!-- Pertanyaan -->
            <p class="text-xl text-gray-700 mb-8">1. Apakah tidak memiliki nafsu makan?</p>

            <!-- Tombol Pilihan -->
            <div class="flex justify-center space-x-6">
                <button
                    class="bg-orange-400 text-white font-semibold py-3 px-8 rounded-full hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500">Iya</button>
                <button
                    class="bg-orange-400 text-white font-semibold py-3 px-8 rounded-full hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500">Tidak</button>
            </div>
        </div>

        <!-- Ilustrasi Dokter di sebelah kanan -->
        <div class="absolute bottom-8 right-8">
            <img src="/images/analisis.png" alt="Ilustrasi Dokter" class="w-48 h-48">
        </div>
    </main>

    <!-- Footer -->
    <div class="p-5 bg-orange-500 mx-auto" id="footerDiagnosa"></div>
</body>

</html>
