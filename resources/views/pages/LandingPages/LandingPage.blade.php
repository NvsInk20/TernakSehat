<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Flowbite CSS -->
    @vite('resources/css/app.css')
    <link rel="icon" href="images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="left-section">
            <div class="image-container">
                <img src="{{ asset('images/logo.png') }}" alt="Ternak Sehat">
            </div>
            <h1>Sistem Pakar Diagnosa Kesehatan Hewan Ternak Sapi</h1>
            <p>Menjaga kesehatan sapi merupakan langkah krusial untuk memaksimalkan produktivitas dan kesejahteraan
                ternak Anda.</p>
        </div>
        <div class="right-section">
            <nav>
                <a href="{{ route('login') }}">Login</a>
                <a href="#tengah">Daftar Menu</a>
                <a href="#bawah">Tentang</a>
            </nav>
            <div id="sapi">
                <img src="{{ asset('images/sapi.png') }}" alt="Ternak Sehat">
            </div>
        </div>
    </div>

    {{-- Container Tengah --}}
    <div class="container-tengah" id="tengah">
        <section class="menu-section">
            <h2>Menu</h2>
            <div class="menu-items">
                <a href="/GuidePage-Diagnosa">
                    <div class="menu-item">
                        <img src="{{ asset('images/diagnosa.png') }}" alt="Ternak Sehat">
                        <p>Diagnosa Penyakit</p>
                    </div>
                </a>
                <a href="/GuidePage-knowledge">
                <div class="menu-item">
                    <img src="{{ asset('images/info.png') }}" alt="Ternak Sehat">
                    <p>Informasi Penyakit</p>
                </div>
                </a>
                <a href="/GuidePage-Riwayat">
                    <div class="menu-item">
                    <img src="{{ asset('images/riwayat.png') }}" alt="Ternak Sehat">
                    <p>Riwayat Penyakit</p>
                </div>
                </a>
            </div>
        </section>
    </div>
    {{-- Container Bawah --}}
    <div class="container-bawah" id="bawah">
        <section class="menu-section">
            <h2>Tentang</h2>
            <p>Peternakan sapi memainkan peran penting dalam mendukung ketahanan pangan dan ekonomi, terutama di
                pedesaan. Namun, salah satu tantangan utama yang dihadapi peternak adalah memastikan kesehatan sapi agar
                tetap optimal dan untuk mengantisipasi penurunan produktivitas, peningkatan biaya perawatan, dan bahkan
                kematian, yang pada akhirnya berdampak pada pendapatan peternak. Sistem ini hadir untuk membantu
                diagnosa kesehatan sapi dengan metode forward chaining berbasis web dengan menganalisis gejala penyakit
                dan memberikan rekomendasi diagnosa, serta tindakan yang harus diambil.</p>
        </section>
    </div>
    </div>
    {{-- Footer --}}
    <footer class="p-5 bg-orange-500 text-center text-white mt-12">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>
<script>
    // Correct selector to target links with href="#tengah" or href="#bawah"
    document.querySelectorAll('a[href^="#tengah"], a[href^="#bawah"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            // Get the target element by href value
            const targetElement = document.querySelector(this.getAttribute('href'));

            // Smoothly scroll to the target element
            window.scrollTo({
                top: targetElement.offsetTop,
                behavior: 'smooth'
            });
        });
    });
</script>

</html>
