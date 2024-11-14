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
    {{-- Registrasi Pengguna --}}
    <div class="container-tengah" id="tengah">
        <a href="{{ route('landingpage') }}">
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
    <div class="p-5 bg-orange-500 mx-auto -mt-10"></div>
</body>

</html>
