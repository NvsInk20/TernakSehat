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

<body class="bg-gray-50 font-poppins">
    <!-- Header -->
    <header class="text-white p-5 bg-orange-500 shadow-md max-w-full max-h-20">
        <div class="container mx-auto flex justify-between">
            <div class="flex space-x-3">
                <h1 class="text-lg font-bold mt-2">Panduan Penggunaan Sistem</h1>
            </div>
            <nav class="space-x-5 mt-2">
                <a href="" class="nav-link text-white hover:text-slate-800">Diagnosa</a>
                <a href="/GuidePage-knowledge" class="nav-link text-white hover:text-slate-800">Pengetahuan Penyakit</a>
                <a href="/GuidePage-Riwayat" class="nav-link text-white hover:text-slate-800">Riwayat Penyakit</a>
            </nav>
        </div>
    </header>
    <div class="flex justify-start mt-5 ml-10">
        <a href="{{ session('previous_url', route('landingpage')) }}"
            class="flex items-center px-4 py-2 rounded-lg border border-blue-500 text-blue-500 
        hover:bg-blue-500 hover:text-white transition duration-300 group shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 mr-2 group-hover:-translate-x-2 transition-transform duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
            </svg>
            <span class="text-sm font-medium">Kembali</span>
        </a>
    </div>

    <!-- Panduan Diagnosa Penyakit -->
    <section id="diagnosa" class="py-10">
        <div class="container mx-auto flex-col">
            <h2 class="text-center text-2xl mx-auto font-bold text-orange-500 mb-5">Diagnosa Penyakit</h2>
            <div class="flex flex-col md:flex-row items-center bg-white shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/diagnosa.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-1/2 h-64 object-contain">
                <div class="mt-5 md:mt-0 md:ml-5">
                    <p class="text-gray-600 mb-4">
                        Fitur ini membantu Anda mendiagnosa penyakit sapi berdasarkan gejala yang terdeteksi. Anda hanya
                        perlu memilih gejala yang sesuai, dan sistem akan memberikan analisis serta rekomendasi.
                    </p>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Masuk Ke halaman diagnosa dengan klik tombol <strong>Diagnosa</strong>.</li>
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
    <section id="diagnosa" class="py-10 -mt-60">
        <div class="container mx-auto flex-col">
            <div class="flex flex-col md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-1.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-1/2 h-64 object-contain">
                <div class="mt-5">
                    <p class="text-gray-600 text-2xl mb-4">
                        Masuk Ke halaman diagnosa dengan klik tombol <strong>Diagnosa</strong>
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- Section 2 --}}
    <section id="diagnosa" class="py-10 -mt-60">
        <div class="container mx-auto flex-col">
            <div class="flex flex-col md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-2.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-1/2 h-64 object-contain">
                <div class="mt-5 md:mt-0 md:ml-5">
                    <p class="text-gray-600 justify-start text-2xl mb-4">
                        Pilih diagnosa dengan data baru atau data lama
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- Section 3 --}}
    <section id="diagnosa" class="py-10 -mt-60">
        <div class="container mx-auto flex-col">
            <div class="flex flex-col md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-3.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-1/2 h-64 object-contain">
                <div class="mt-5 md:mt-0 md:ml-5">
                    <p class="text-gray-600 justify-start text-2xl mb-4">
                        Perhatikan dengan baik gejala yang ditampilkan agar sesuai dengan hasil yang diharapkan
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 4 --}}
    <section id="diagnosa" class="py-10 -mt-60">
        <div class="container mx-auto flex-col">
            <div class="flex flex-col md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-3.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-1/2 h-64 object-contain">
                <div class="mt-5 md:mt-0 md:ml-5">
                    <p class="text-gray-600 justify-start text-2xl mb-4">
                        Silahkan klik <strong>Mulai Lakukan DIagnosa</strong>
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 5 --}}
    <section id="diagnosa" class="py-10 -mt-60">
        <div class="container mx-auto flex-col">
            <div class="flex flex-col md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-4.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-1/2 h-64 object-contain">
                <div class="mt-5 md:mt-0 md:ml-5">
                    <p class="text-gray-600 justify-start text-2xl mb-4">
                        Silahkan jawab pertanyaan dengan memperhatikan beberapa gejala yang muncul dengan baik
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- Section 6 --}}
    <section id="diagnosa" class="py-10 -mt-60">
        <div class="container mx-auto flex-col">
            <div class="flex flex-col md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-6.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-1/2 h-64 object-contain">
                <div class="mt-5 md:mt-0 md:ml-5">
                    <p class="text-gray-600 justify-start text-2xl mb-4">
                        Setelah berhasil maka akan menampilkan hasil diagnosa berdasarkan dengan gejala yang dipilih dan
                        juga memberikan sebuah rekomendasi pengobaan yang bisa dilakukan
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- Section 7 --}}
    <section id="diagnosa" class="py-10 -mt-60">
        <div class="container mx-auto flex-col">
            <div class="flex flex-col md:flex-row items-center bg-orange-300 shadow-lg rounded-lg p-5">
                <img src="{{ asset('/images/Diagnosa/rule-5.png') }}" alt="Diagnosa Penyakit"
                    class="w-full md:w-1/2 h-64 object-contain">
                <div class="mt-5 md:mt-0 md:ml-5">
                    <p class="text-gray-600 justify-start text-2xl mb-4">
                        Kamu juga bisa menyimpan hasil diagnosa untuk kebutuhan seperti manajemen peternakan agar
                        kondisi kesehatan hewan ternak bisa terjaga dan terpantau dengan baik
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>

    <script>
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
