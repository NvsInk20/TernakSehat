<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panduan Penggunaan - Ternak Sehat</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('/images/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-50 font-poppins overflow-x-hidden 2xl:min-h-screen flex flex-col xl:min-h-screen min-h-screen">
    <!-- Header -->
    <header class="text-white p-5 bg-orange-500 shadow-md 2xl:max-h-36 max-h-20 max-w-full">
        <div class="container mx-auto flex justify-between 2xl:max-w-full 2xl:mt-10">
            <!-- H1 Section -->
            <h1 class="text-lg font-bold 2xl:text-3xl xl:text-xl sm:text-lg">
                Panduan Penggunaan Sistem
            </h1>
            <!-- Hamburger Button -->
            <button id="hamburger" class="lg:hidden absolute ml-[80%] text-white focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <!-- Navigation Section -->
            <nav id="nav-menu"
                class="hidden lg:flex flex-col lg:flex-row 2xl:text-3xl space-y-4 lg:space-y-0 lg:space-x-8 text-2xl font-medium bg-orange-500 lg:bg-transparent lg:static absolute right-0 top-16 w-full lg:w-auto">
                <a href="/GuidePage-Diagnosa"
                    class="block px-4 py-2 lg:inline-block hover:text-slate-800 text-black">Diagnosa Penyakit</a>
                <a href="/GuidePage-knowledge" class="block px-4 py-2 lg:inline-block hover:text-slate-800">Informasi
                    Penyakit</a>
                <a href="/GuidePage-Riwayat" class="block px-4 py-2 lg:inline-block hover:text-slate-800">Riwayat
                    Diagnosa</a>
            </nav>

        </div>
    </header>

    <div class="flex justify-start mt-5 2xl:mt-11 sm:ml-10 lg:ml-10 xl:ml-10 2xl:ml-10 ml-2">
        <a href="{{ session('previous_url', route('landingpage')) }}"
            class="flex items-center px-2 py-1 xl:px-5 xl:py-2 2xl:px-9 2xl:py-6 2xl:rounded-2xl rounded-lg border border-blue-500 text-blue-500 
        hover:bg-blue-500 hover:text-white transition duration-300 group shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6 mr-3 group-hover:-translate-x-2 transition-transform duration-300 2xl:w-10 2xl:h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
            </svg>
            <span class="text-base xl:text-xl 2xl:text-4xl font-medium">Kembali</span>
        </a>
    </div>


    <!-- Panduan Diagnosa Penyakit -->
    <section id="diagnosa" class="py-10 2xl:max-w-[90%] 2xl:mx-auto">
        <div class="container mx-auto h-[47rem] xl:h-[31rem] flex-col 2xl:h-[60rem] 2xl:max-w-max">
            <h2 class="text-center text-2xl xl:text-2xl 2xl:text-6xl mx-auto font-bold text-orange-500 mb-5">Diagnosa
                Penyakit</h2>
            <div class="flex flex-col  md:flex-col items-center bg-white shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/diagnosa.png') }}" alt="Diagnosa Penyakit"
                    class="w-full h-64 2xl:max-w-full xl:h-64 md:w-1/2 2xl:h-1/2 object-contain">
                <div class="mt-5 md:mt-0 md:ml-5">
                    <p class="text-gray-600 2xl:text-3xl mb-4">
                        Fitur ini membantu pengguna mendiagnosa penyakit sapi berdasarkan gejala yang terdeteksi.
                        Pengguna hanya
                        perlu memilih gejala yang sesuai, dan sistem akan memberikan analisis serta rekomendasi.
                    </p>
                    <ul class="list-disc list-inside text-gray-600 2xl:text-3xl">
                        <li>Masuk Ke halaman diagnosa dengan klik tombol <strong>Diagnosa</strong></li>
                        <li>Pilih diagnosa dengan data baru atau data lama</li>
                        <li>Perhatikan dengan baik gejala yang ditampilkan agar sesuai dengan hasil yang diharapkan</li>
                        <li>Silahkan klik <strong>Mulai Lakukan DIagnosa</strong></li>
                        <li>Silahkan jawab pertanyaan dengan memperhatikan beberapa gejala yang muncul dengan baik</li>
                        <li>Setelah berhasil maka akan menampilkan hasil diagnosa berdasarkan dengan gejala yang dipilih
                            dan juga memberikan sebuah rekomendasi pengobaan yang bisa dilakukan</li>
                        <li>Kamu juga bisa menyimpan hasil diagnosa untuk kebutuhan seperti manajemen peternakan agar
                            kondisi kesehatan hewan ternak bisa terjaga dan terpantau dengan baik</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    {{-- Section 1 --}}
    <section id="diagnosa"
        class="py-10 mt-48 md:mt-14 2xl:mt-72 h-[1rem] 2xl:mb-[22rem] md:-mb-[40%] 2xl:h-[15rem] 2xl:max-w-[90%] 2xl:mx-auto xl:h-[52rem] sm:mt-52">
        <div class="container mx-auto flex-col 2xl:max-w-full 2xl:h-[37rem]">
            <div
                class="flex flex-col xl:w-full md:w-11/12 2xl:h-full md:mx-auto sm:w-11/12 sm:mx-auto lg:w-11/12 lg:mx-auto md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-1.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-3/5 h-auto max-h-[500px] object-contain">
                <div class="mt-5">
                    <p
                        class="text-gray-600 lg:text-lg 2xl:text-4xl xl:text-2xl md:-mt-5 md:ml-10 md:text-base lg:ml-10">
                        Masuk Ke halaman diagnosa dengan klik tombol <strong>Diagnosa</strong>
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- Section 2 --}}
    <section id="diagnosa"
        class="py-10 mt-48 md:mt-14 h-[1rem] 2xl:mb-[8rem] md:-mb-[40%] 2xl:h-[15rem] 2xl:max-w-[90%] 2xl:mx-auto xl:h-[52rem] sm:mt-52">
        <div class="container mx-auto flex-col 2xl:max-w-full 2xl:h-[37rem]">
            <div
                class="flex flex-col xl:w-full md:w-11/12 2xl:h-full md:mx-auto sm:w-11/12 sm:mx-auto lg:w-11/12 lg:mx-auto md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-2.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-3/5 h-auto max-h-[500px] object-contain">
                <div class="mt-5">
                    <p
                        class="text-gray-600 lg:text-lg 2xl:text-4xl xl:text-2xl md:-mt-5 md:ml-10 md:text-base lg:ml-10">
                        Pilih diagnosa dengan data baru atau data lama
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- Section 3 --}}
    <section id="diagnosa"
        class="py-10 mt-48 md:mt-14 2xl:mt-72 h-[1rem] 2xl:mb-[8rem] md:-mb-[40%] 2xl:h-[15rem] 2xl:max-w-[90%] 2xl:mx-auto xl:h-[52rem] sm:mt-52">
        <div class="container mx-auto flex-col 2xl:max-w-full 2xl:h-[37rem]">
            <div
                class="flex flex-col xl:w-full md:w-11/12 2xl:h-full md:mx-auto sm:w-11/12 sm:mx-auto lg:w-11/12 lg:mx-auto md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-3.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-3/5 h-auto max-h-[500px] object-contain">
                <div class="mt-5">
                    <p
                        class="text-gray-600 lg:text-lg 2xl:text-4xl xl:text-2xl md:-mt-5 md:ml-10 md:text-base lg:ml-10">
                        Perhatikan dengan baik gejala yang ditampilkan agar sesuai dengan hasil yang diharapkan
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 4 --}}
    <section id="diagnosa"
        class="py-10 mt-56 md:mt-14 2xl:mt-72 h-[1rem] 2xl:mb-[8rem] md:-mb-[40%] 2xl:h-[15rem] 2xl:max-w-[90%] 2xl:mx-auto xl:h-[52rem] sm:mt-52">
        <div class="container mx-auto flex-col 2xl:max-w-full 2xl:h-[37rem]">
            <div
                class="flex flex-col xl:w-full md:w-11/12 2xl:h-full md:mx-auto sm:w-11/12 sm:mx-auto lg:w-11/12 lg:mx-auto md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-3.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-3/5 h-auto max-h-[500px] object-contain">
                <div class="mt-5">
                    <p
                        class="text-gray-600 lg:text-lg 2xl:text-4xl xl:text-2xl md:-mt-5 md:ml-10 md:text-base lg:ml-10">
                        Silahkan klik <strong>Mulai Lakukan DIagnosa</strong>
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 5 --}}
    <section id="diagnosa"
        class="py-10 mt-44 md:mt-14 2xl:mt-72 h-[1rem] 2xl:mb-[8rem] md:-mb-[40%] 2xl:h-[15rem] 2xl:max-w-[90%] 2xl:mx-auto xl:h-[52rem] sm:mt-52">
        <div class="container mx-auto flex-col 2xl:max-w-full 2xl:h-[37rem]">
            <div
                class="flex flex-col xl:w-full md:w-11/12 2xl:h-full md:mx-auto sm:w-11/12 sm:mx-auto lg:w-11/12 lg:mx-auto md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-4.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-3/5 h-auto max-h-[500px] object-contain">
                <div class="mt-5">
                    <p
                        class="text-gray-600 lg:text-lg 2xl:text-4xl xl:text-2xl md:-mt-5 md:ml-10 md:text-base lg:ml-10">
                        Silahkan jawab pertanyaan dengan memperhatikan beberapa gejala yang muncul dengan baik
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- Section 6 --}}
    <section id="diagnosa"
        class="py-10 mt-56 md:mt-14 2xl:mt-72 h-[1rem] 2xl:mb-[8rem] md:-mb-[40%] 2xl:h-[15rem] 2xl:max-w-[90%] 2xl:mx-auto xl:h-[52rem] sm:mt-52">
        <div class="container mx-auto flex-col h-[1rem] 2xl:max-w-full 2xl:h-[37rem]">
            <div
                class="flex flex-col xl:w-full md:w-11/12 2xl:h-full md:mx-auto sm:w-11/12 sm:mx-auto lg:w-11/12 lg:mx-auto md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-6.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-3/5 h-auto max-h-[500px] object-contain">
                <div class="mt-5">
                    <p
                        class="text-gray-600 lg:text-lg 2xl:text-4xl xl:text-2xl md:-mt-5 md:ml-10 md:text-base lg:ml-10">
                        Setelah berhasil maka akan menampilkan hasil diagnosa berdasarkan dengan gejala yang
                        dipilih
                        dan
                        juga memberikan sebuah rekomendasi pengobaan yang bisa dilakukan
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- Section 7 --}}
    <section id="diagnosa"
        class="py-10 mt-64 md:mt-14 2xl:mt-72 2xl:mb-[29rem] 2xl:h-[15rem] 2xl:max-w-[90%] 2xl:mx-auto xl:h-[30rem] sm:mt-52">
        <div class="container mx-auto h-[20rem] flex-col 2xl:max-w-full xl:h-[3rem] 2xl:h-[37rem]">
            <div
                class="flex flex-col xl:w-full md:w-11/12 2xl:h-full md:mx-auto sm:w-11/12 sm:mx-auto lg:w-11/12 lg:mx-auto md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-5.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-3/5 h-auto max-h-[500px] object-contain">
                <div class="mt-5">
                    <p
                        class="text-gray-600 lg:text-lg 2xl:text-4xl xl:text-2xl md:-mt-5 md:ml-10 md:text-base lg:ml-10">
                        Pengguna juga bisa menyimpan hasil diagnosa untuk kebutuhan seperti manajemen peternakan
                        agar
                        kondisi kesehatan hewan ternak bisa terjaga dan terpantau dengan baik
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500  text-center 2xl:p-10 2xl:text-2xl md:mt-10 text-white lg:mt-auto">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hamburger = document.getElementById('hamburger');
            const navMenu = document.getElementById('nav-menu');

            // Toggle menu visibility
            hamburger.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent click from propagating to document
                navMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!navMenu.classList.contains('hidden') && !navMenu.contains(e.target) && e.target !==
                    hamburger) {
                    navMenu.classList.add('hidden');
                }
            });
        });
        // Menambahkan class "active" berdasarkan hash URL
        const navLinks = document.querySelectorAll('.nav-link');
        const currentHash = window.location.hash;

        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentHash) {
                link.classList.add('font-bold');
            } else {
                link.classList.remove('font-bold');
            }
        });

        // Tambahkan event listener untuk memperbarui class saat pengguna berpindah bagian
        window.addEventListener('hashchange', () => {
            const newHash = window.location.hash;

            navLinks.forEach(link => {
                if (link.getAttribute('href') === newHash) {
                    link.classList.add('font-bold');
                } else {
                    link.classList.remove('font-bold');
                }
            });
        });
    </script>
</body>


</html>
