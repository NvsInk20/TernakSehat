<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Diagnosa</title>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
    @include('components.dropSettings')

    <!-- Main Content -->
    <main class="flex flex-col items-center justify-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-16">Halaman Diagnosa</h1>
        <div class="relative bg-white rounded-lg shadow-xl p-12 text-center max-w-lg w-full">
            <div
                class="absolute bg-orange-300 rounded-lg transform -rotate-6 -z-10 top-6 left-6 w-full h-full scale-110">
            </div>
            <div
                class="absolute bg-orange-400 rounded-lg transform -rotate-3 -z-20 top-10 left-10 w-full h-full scale-110">
            </div>

            <!-- Pertanyaan -->
            @if (isset($question) && $question && $question->gejala)
                <p class="text-xl text-gray-700 mb-8">
                    Apakah sapi mengalami {{ $question->gejala->nama_gejala }}?
                </p>

                <!-- Hapus keterangan 'Opsional' atau 'Wajib dijawab' jika tidak ingin ditampilkan -->
                <form action="{{ route('diagnosa.answer') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kode_gejala" value="{{ $question->kode_gejala }}">
                    <div class="flex justify-center space-x-6">
                        <button type="submit" name="answer" value="1"
                            class="bg-green-400 text-white font-semibold py-3 px-8 rounded-full hover:bg-orange-500">
                            Iya
                        </button>
                        <button type="submit" name="answer" value="0"
                            class="bg-green-400 text-white font-semibold py-3 px-8 rounded-full hover:bg-orange-500">
                            Tidak
                        </button>
                    </div>
                </form>
            @else
                <p class="text-xl text-red-600 font-semibold">
                    Tolong diperhatikan dengan baik gejala yang akan muncul.
                </p>
                <a href="{{ route('diagnosa.result') }}"
                    class="mt-8 inline-block bg-orange-400 text-white font-semibold py-3 px-8 rounded-full hover:bg-orange-500">
                    Mulai Lakukan Diagnosa
                </a>
                <a href="{{ route('user.dashboard') }}"
                    class="mt-4 inline-block bg-gray-400 text-white font-semibold py-3 px-8 rounded-full hover:bg-gray-500">
                    Kembali ke Dashboard
                </a>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white mt-28">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

</html>
