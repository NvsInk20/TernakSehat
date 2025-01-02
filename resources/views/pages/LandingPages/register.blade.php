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
    <link rel="icon" href="/images/logo.png">
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
    {{-- Registrasi Pengguna --}}
    <div class="container-tengah" id="tengah">
        <a href="{{ route('login') }}">
            <div class="back">
                Kembali
            </div>
        </a>
        <section class="menu-section">
            <h2>Registrasi</h2>
            <div class="menu-items">
                <div class="menu-item">
                    <a href="/RegistrasiAhliPakar">
                        <img src="{{ asset('images/ahlipakar.png') }}" alt="Ternak Sehat">
                        <p>Ahli Pakar</p>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="/RegistrasiUser">
                        <img src="{{ asset('images/peternak.png') }}" alt="Ternak Sehat">
                        <p>User (Peternak)</p>
                    </a>
                </div>
            </div>
        </section>
    </div>
    </div>
    {{-- Footer --}}
    <footer class="p-5 bg-orange-500 text-center text-white mt-12">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

</html>
