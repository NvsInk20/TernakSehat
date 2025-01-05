<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="icon" href="/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="font-poppins overflow-x-hidden flex flex-col min-h-screen">
    <!-- Bagian Atas -->
    <div class="flex flex-col xl:flex-row h-auto xl:min-h-screen">
        <!-- Bagian Kiri -->
        <div class="flex-1 bg-white p-6 sm:p-10">
            <div class="flex justify-center xl:justify-start">
                <img src="{{ asset('/images/logo.png') }}" alt="Ternak Sehat" class="w-24 sm:w-28 h-auto rounded-lg">
            </div>
            <h1
                class="mt-6 sm:mt-12 text-xl sm:text-2xl xl:text-3xl font-bold leading-snug text-center xl:text-left xl:w-4/5">
                Sistem Pakar Diagnosa Kesehatan Hewan Ternak Sapi
            </h1>
            <p class="mt-4 sm:mt-6 text-sm sm:text-base text-gray-600 w-full xl:w-3/4 text-center xl:text-left">
                Menjaga kesehatan sapi merupakan langkah krusial untuk memaksimalkan produktivitas dan kesejahteraan
                ternak Anda.
            </p>
        </div>

        <!-- Bagian Kanan -->
        <div class="flex-1 bg-orange-500 text-white p-6 sm:p-10 flex flex-col items-center">
            <nav class="mb-6 flex flex-wrap justify-center space-x-4">
                <a href="{{ route('login') }}"
                    class="hover:bg-white text-base sm:text-lg xl:text-2xl hover:text-black border border-transparent hover:border-white rounded px-3 py-1">
                    Login
                </a>
                <a href="#ContainerTengah"
                    class="hover:bg-white text-base sm:text-lg xl:text-2xl hover:text-black border border-transparent hover:border-white rounded px-3 py-1">
                    Daftar Menu
                </a>
                <a href="#ContainerBawah"
                    class="hover:bg-white text-base sm:text-lg xl:text-2xl hover:text-black border border-transparent hover:border-white rounded px-3 py-1">
                    Tentang
                </a>
            </nav>
            <div class="mt-6 sm:mt-10 xl:mt-20">
                <img src="{{ asset('/images/slide-3.jpeg') }}" alt="Ternak Sehat"
                    class="w-full max-w-sm sm:max-w-md xl:max-w-xl rounded-lg mx-auto object-contain">
            </div>
        </div>
    </div>

    <!-- Container Tengah -->
    <div id="ContainerTengah" class="w-screen p-6 sm:p-8">
        <section class="text-center max-w-5xl mx-auto">
            <h2
                class="relative inline-block px-10 sm:px-14 py-2 sm:py-4 mt-6 sm:mt-10 text-lg sm:text-2xl xl:text-3xl font-bold border border-black bg-white">
                Menu
                <span class="absolute inset-0 -z-10 -rotate-6 bg-orange-500 translate-x-2 translate-y-3"></span>
            </h2>
            <div class="flex flex-wrap justify-center mt-6 sm:mt-10 xl:mt-20 gap-4 sm:gap-8">
                <!-- Cards Menu -->
                <a href="/GuidePage-Diagnosa" class="group">
                    <div
                        class="bg-orange-500 hover:bg-orange-400 rounded-lg p-6 sm:p-8 w-48 sm:w-64 xl:w-72 text-white text-center transition-transform transform hover:-translate-y-1">
                        <img src="{{ asset('/images/diagnosa.png') }}" alt="Diagnosa Penyakit"
                            class="w-20 sm:w-32 xl:w-40 h-20 sm:h-32 xl:h-40 mx-auto rounded-lg">
                        <p class="mt-4 sm:mt-6 text-sm sm:text-lg xl:text-xl font-semibold">Diagnosa Penyakit</p>
                    </div>
                </a>
                <a href="/GuidePage-knowledge" class="group">
                    <div
                        class="bg-orange-500 hover:bg-orange-400 rounded-lg p-6 sm:p-8 w-48 sm:w-64 xl:w-72 text-white text-center transition-transform transform hover:-translate-y-1">
                        <img src="{{ asset('/images/info.png') }}" alt="Informasi Penyakit"
                            class="w-20 sm:w-32 xl:w-40 h-20 sm:h-32 xl:h-40 mx-auto rounded-lg">
                        <p class="mt-4 sm:mt-6 text-sm sm:text-lg xl:text-xl font-semibold">Informasi Penyakit</p>
                    </div>
                </a>
                <a href="/GuidePage-Riwayat" class="group">
                    <div
                        class="bg-orange-500 hover:bg-orange-400 rounded-lg p-6 sm:p-8 w-48 sm:w-64 xl:w-72 text-white text-center transition-transform transform hover:-translate-y-1">
                        <img src="{{ asset('/images/riwayat.png') }}" alt="Riwayat Penyakit"
                            class="w-20 sm:w-32 xl:w-40 h-20 sm:h-32 xl:h-40 mx-auto rounded-lg">
                        <p class="mt-4 sm:mt-6 text-sm sm:text-lg xl:text-xl font-semibold">Riwayat Penyakit</p>
                    </div>
                </a>
            </div>
        </section>
    </div>

    <!-- Container Bawah -->
    <div id="ContainerBawah" class="container mx-auto px-6 sm:px-8 py-6 sm:py-12 flex-1">
        <section class="max-w-5xl mx-auto">
            <h2
                class="relative inline-block px-10 sm:px-14 py-2 sm:py-4 text-lg sm:text-2xl xl:text-3xl font-bold border border-black bg-white">
                Tentang
                <span class="absolute inset-0 -z-10 -rotate-6 bg-orange-500 translate-x-2 translate-y-3"></span>
            </h2>
            <div class="mt-6 sm:mt-10 flex flex-col xl:flex-row items-center xl:items-start">
                <p class="flex-1 text-justify bg-orange-500 text-white p-6 sm:p-8 rounded-lg shadow-lg">
                    Peternakan sapi memainkan peran penting dalam mendukung ketahanan pangan dan ekonomi, terutama di
                    pedesaan. Namun, salah satu tantangan utama yang dihadapi peternak adalah memastikan kesehatan sapi
                    agar tetap optimal untuk mengantisipasi penurunan produktivitas, peningkatan biaya perawatan, dan
                    bahkan kematian, yang pada akhirnya berdampak pada pendapatan peternak. Sistem ini hadir untuk
                    membantu diagnosa kesehatan sapi dengan metode forward chaining berbasis web dengan menganalisis
                    gejala penyakit dan memberikan rekomendasi diagnosa serta tindakan yang harus diambil.
                </p>
                <img src="{{ asset('/images/dokter.png') }}" alt="Tentang Aplikasi"
                    class="flex-1 max-w-sm mt-6 sm:mt-8 xl:mt-0 xl:ml-10 object-contain">
            </div>
        </section>
    </div>

    <footer class="p-4 sm:p-5 bg-orange-500 text-center mt-auto text-white">
        <p class="font-medium text-xs sm:text-sm xl:text-base">Ternak Sehat © {{ date('Y') }}</p>
    </footer>

</body>

</html>

</html>
{{-- Landing Page --}}
<script>
    document.querySelectorAll('a[href^="#ContainerTengah"], a[href^="#ContainerBawah"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetElement = document.querySelector(this.getAttribute('href'));
            window.scrollTo({
                top: targetElement.offsetTop,
                behavior: 'smooth'
            });
        });
    });
</script>
