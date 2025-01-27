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
                <img src="{{ asset('/images/logo.png') }}" alt="Ternak Sehat"
                    class="w-24 sm:w-28 lg:w-52 xl:w-36 2xl:w-56 2xl:mt-16 h-auto rounded-lg">
            </div>
            <h1
                class="mt-6 sm:mt-12 xl:mt-20 2xl:mt-36 sm:text-2xl xl:text-5xl 2xl:text-[4rem] 2xl:w-[90%] font-bold leading-snug text-center xl:text-left xl:w-[100%]">
                Sistem Pakar Diagnosa Kesehatan Hewan Ternak Sapi
            </h1>
            <p
                class="mt-4 xl:text-[100%] 2xl:w-[65%] 2xl:text-[130%] sm:mt-6 text-sm sm:text-base text-gray-600 w-full xl:w-3/4 text-center xl:text-left">
                Menjaga kesehatan sapi merupakan langkah krusial untuk memaksimalkan produktivitas dan kesejahteraan
                ternak Anda.
            </p>
        </div>

        <!-- Bagian Kanan -->
        <div class="flex-1 bg-orange-500 text-white p-6 sm:p-10 flex flex-col items-center">
            <nav class="mb-6 flex flex-wrap justify-center 2xl:mt-7 space-x-3">
                <a href="{{ route('login') }}"
                    class="hover:bg-white text-base sm:text-lg sm:space-x-1 xl:text-[180%] xl:mt-[10%] 2xl:text-5xl hover:text-black border border-transparent hover:border-white rounded px-3 py-1">
                    Masuk
                </a>
                <a href="#ContainerTengah"
                    class="hover:bg-white text-base sm:text-lg sm:space-x-1 xl:text-[180%] xl:mt-[10%] 2xl:text-5xl hover:text-black border border-transparent hover:border-white rounded px-3 py-1">
                    Panduan
                </a>
                <a href="#ContainerBawah"
                    class="hover:bg-white text-base sm:text-lg sm:space-x-1 xl:text-[180%] xl:mt-[10%] 2xl:text-5xl hover:text-black border border-transparent hover:border-white rounded px-3 py-1">
                    Tentang
                </a>
            </nav>
            <div class="mt-6 sm:mt-10 xl:mt-20">
                <img src="{{ asset('/images/slide-3.jpeg') }}" alt="Ternak Sehat"
                    class="w-full xl:rounded-3xl max-w-sm sm:max-w-md xl:max-w-[80%] 2xl:mt-[7%] 2xl:max-w-3xl xl:mt-0 rounded-lg mx-auto object-contain">
            </div>
        </div>
    </div>

    <!-- Container Tengah -->
    <div id="ContainerTengah" class="w-screen p-6 sm:p-8 2xl:min-h-screen xl:mb-[60px] xl:min-h-screen">
        <section class="text-center max-w-5xl mx-auto xl:max-w-screen-xl 2xl:max-w-screen-xl">
            <h2
                class="relative inline-block xl:text-[2em] px-10 sm:px-14 xl:mb-20 py-2 sm:py-4 mt-6 sm:mt-10 text-lg sm:text-2xl 2xl:text-5xl font-bold border border-black bg-white">
                Panduan
                <span class="absolute inset-0 -z-10 -rotate-6 bg-orange-500 translate-x-2 translate-y-3"></span>
            </h2>
            <div class="flex flex-wrap justify-center mt-16 xl:mt-20 2xl:mt-40 gap-6 sm:gap-8 2xl:gap-12">
                <!-- Cards Menu -->
                <a href="/GuidePage-Diagnosa" class="group">
                    <div
                        class="bg-orange-500 hover:bg-orange-400 rounded-lg p-6 sm:p-8 2xl:p-20 w-56 sm:w-72 xl:w-[100%] 2xl:w-[390px] text-white text-center transition-transform transform hover:scale-105">
                        <img src="{{ asset('/images/diagnosa.png') }}" alt="Diagnosa Penyakit"
                            class="w-24 sm:w-36 2xl:w-48 h-24 sm:h-36 xl:h-32 2xl:h-48 mx-auto rounded-lg">
                        <p class="mt-6 sm:mt-8 text-base sm:text-lg 2xl:text-2xl xl:text-xl font-semibold">Diagnosa
                            Penyakit</p>
                    </div>
                </a>
                <a href="/GuidePage-knowledge" class="group">
                    <div
                        class="bg-orange-500 hover:bg-orange-400 rounded-lg p-6 sm:p-8 2xl:p-20 w-56 sm:w-72 xl:w-[100%] 2xl:w-[390px] text-white text-center transition-transform transform hover:scale-105">
                        <img src="{{ asset('/images/info.png') }}" alt="Informasi Penyakit"
                            class="w-24 sm:w-36 2xl:w-48 h-24 sm:h-36 xl:h-32 2xl:h-48 mx-auto rounded-lg">
                        <p class="mt-6 sm:mt-8 text-base sm:text-lg 2xl:text-2xl xl:text-xl font-semibold">Informasi
                            Penyakit</p>
                    </div>
                </a>
                <a href="/GuidePage-Riwayat" class="group">
                    <div
                        class="bg-orange-500 hover:bg-orange-400 rounded-lg p-6 sm:p-8 2xl:p-20 w-56 sm:w-72 xl:w-[100%] 2xl:w-[390px] text-white text-center transition-transform transform hover:scale-105">
                        <img src="{{ asset('/images/riwayat.png') }}" alt="Riwayat Penyakit"
                            class="w-24 sm:w-36 2xl:w-48 h-24 sm:h-36 xl:h-32 2xl:h-48 mx-auto rounded-lg">
                        <p class="mt-6 sm:mt-8 text-base sm:text-lg 2xl:text-2xl xl:text-xl font-semibold">Riwayat
                            Diagnosa</p>
                    </div>
                </a>
            </div>
        </section>
    </div>

    <!-- Container Bawah -->
    <div id="ContainerBawah"
        class="container mx-auto px-6 2xl:mt-[-10%] xl:-mt-[11%] lg:min-w-screen xl:min-h-screen 2xl:min-h-screen sm:px-8 lg:-mt-36 py-6 sm:py-12 flex-1">
        <section class="lg:max-w-5xl max-w-80 mx-auto xl:max-w-screen-xl  2xl:max-w-screen-2xl">
            <h2
                class="relative mb-6 inline-block lg:mt-20 px-10 sm:px-14 py-2 sm:py-4 2xl:py-6 text-lg sm:text-2xl 2xl:text-4xl font-bold border border-black bg-white">
                Tentang
                <span class="absolute inset-0 -z-10 -rotate-6 bg-orange-500 translate-x-2 translate-y-3"></span>
            </h2>
            <div class="mt-6 sm:mt-10 flex flex-col xl:flex-row items-center xl:items-start">
                <p
                    class="flex-1 text-justify md:w-96 2xl:max-w-[55%] xl:max-w-[50%] 2xl:text-[22px] xl:text-[14px] lg:w-1/2 lg:mt-20 xl:-mt-2 bg-orange-500 text-white p-6 sm:p-8 text-sm sm:text-base rounded-lg shadow-lg">
                    Peternakan sapi memainkan peran penting dalam mendukung ketahanan pangan dan ekonomi, untuk
                    memastikan kesehatan sapi agar tetap optimal untuk mengantisipasi penurunan produktivitas,
                    peningkatan
                    biaya perawatan, dan bahkan kematian, yang pada akhirnya berdampak pada pendapatan peternak. Sistem
                    ini
                    hadir untuk membantu diagnosa kesehatan sapi dengan metode forward chaining berbasis web dengan
                    menganalisis gejala penyakit dan memberikan rekomendasi diagnosa serta tindakan yang harus diambil.
                </p>
                <img src="{{ asset('/images/dokter.png') }}" alt="Tentang Aplikasi"
                    class="flex-1 lg:max-w-sm xl:max-w-[30%] xl:ml-[10%] max-w-72 mt-6 sm:mt-8 xl:mt-[-7%] 2xl:ml-[10%] 2xl:-mt-20 object-contain">
            </div>
        </section>
    </div>

    <footer class="p-4 sm:p-5 xl:p-8 2xl:-mt-[4%] bg-orange-500 text-center mt-auto text-white">
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
