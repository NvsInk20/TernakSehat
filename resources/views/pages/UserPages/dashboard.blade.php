<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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

<body class="bg-gray-100">
    @include('components.navbar')
    @if (session('success') || session('error'))
        <div class="absolute top-10 left-1/2 ml-28 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-4 w-[90%] sm:w-[400px] flex items-center space-x-4 z-50 transition-opacity duration-300"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            @if (session('success'))
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-green-600 text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-red-600 text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <button @click="show = false" class="text-gray-500 hover:text-gray-700 ml-auto focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @include('components.dropSettings')
    <main>
        <div class="py-10 px-0">
            <div id="halamanAtas">
                <div class="ml-20">
                    <!-- Section 1: Sistem Pakar Diagnosa Kesehatan Sapi -->
                    <div class="mb-10 flex flex-col md:flex-row">
                        <div class="md:w-1/2 p-8 mt-12">
                            <h2 class="text-5xl font-bold text-gray-800">Sistem Pakar Diagnosa Kesehatan Sapi</h2>
                            <p class="text-gray-600 mt-4">Sistem pakar untuk diagnosa kesehatan sapi untuk membantu
                                mendeteksi
                                penyakit secara cepat dan tepat.</p>
                            <button
                                class="mt-6 bg-orange-400 text-white font-semibold py-2 px-6 rounded-full hover:bg-orange-500"><a
                                    href="/diagnosa/options">Mulai
                                    Diagnosa</a></button>
                        </div>
                        <div class="md:w-1/2 flex justify-center p-8 relative">
                            <!-- Background Orange placed behind the image -->
                            <div class="absolute inset-0 bg-gradient-to-r from-orange-300 to-orange-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl z-0 ml-40 mt-8"
                                id="bg">
                            </div>
                            <img src="/images/sapii.png" alt="Cow Image" id="sapii"
                                class="relative rounded-lg shadow-lg z-10 -ml-10">
                        </div>
                    </div>
                </div>
            </div>


            <div class="section">
                <!-- Section 2: Daftar Penyakit Hewan Ternak -->
                <div class=" bg-orange-100 rounded-lg shadow-lg p-10" id="latar">
                    <div class="flexitems-center text-center">
                        <div class="relative inline-block">
                            <!-- Bayangan belakang -->
                            <div class="absolute -bottom-2 -right-2 bg-orange-500 rounded-lg w-full h-full"></div>
                            <!-- Kotak utama -->
                            <div
                                class="relative bg-white border border-black px-4 py-2 rounded-lg text-black text-2xl font-semibold">
                                Daftar Penyakit
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-6">
                        <img src="/images/dokter.png" alt="Doctor Illustration" class="w-96 h-96 ml-20 mt-10 absolute">
                    </div>
                    <div class="text">
                        <h2 class="text-gray-700 text-xl font-semibold">Daftar Penyakit Hewan Ternak Sapi
                        </h2>
                        <h2 class="text-gray-700 text-xl font-semibold my-4">Di Kabupaten Boyolali</h2>
                        <p class="text-gray-600 mt-2">Mulai dari berbagai penyakit sapi beserta penyebab dan
                            pencegahannya
                            untuk
                            meningkatkan kesehatan hewan.</p>
                        <button
                            class="mt-6 bg-orange-400 text-white font-semibold py-2 px-6 rounded-full hover:bg-orange-500">
                            <a href="/User/penyakit">Cek Penyakit</a></button>
                    </div>
                </div>
            </div>
            <div class="section3">
                <!-- Section 3: Manfaat Sistem -->
                <div class="" id="latar3">
                    <div class="flexitems-center text-center mt-16" id="footerUser">
                        <div class="relative inline-block">
                            <!-- Bayangan belakang -->
                            <div class="absolute -bottom-2 -right-2 bg-orange-500 rounded-lg w-full h-full"></div>
                            <!-- Kotak utama -->
                            <div
                                class="relative bg-white border border-black px-4 py-2 rounded-lg text-black text-2xl font-semibold">
                                Manfaat Sistem
                            </div>
                        </div>
                    </div>
                    <div class="flexitems-center  mt-16" id="footerContent">
                        <div class="relative inline-block">
                            <div class="absolute -bottom-2 -right-2 bg-orange-500 rounded-lg w-full h-full"></div>
                            <div
                                class="relative bg-white border border-black px-4 py-2 rounded-lg text-black font-semibold">
                                <p>
                                    sistem ini bisa membantu peternak mengambil langkah cepat dalam menangani penyakit,
                                    mencegah penyebaran penyakit lebih lanjut, serta mengurangi risiko kerugian ekonomi
                                    akibat penyakit yang terlambat diobati. Selain itu, sistem pakar juga dapat
                                    meningkatkan produktivitas dan efisiensi peternakan karena memungkinkan pengelolaan
                                    kesehatan ternak yang lebih baik dan tepat waktu.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="dokter">
                        <img src="/images/footerSapi.png" alt="Doctor Illustration" class="ml-20 -mt-80 absolute">
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- Footer --}}
    <footer class="p-5 bg-orange-500 text-center text-white mt-12">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

</html>
