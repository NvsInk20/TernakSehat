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
</head>

<body class="bg-orange-100 font-sans">
    <!-- Navbar -->
    @include('components.navbar')
    <div class="hidden sm:block">
        @include('components.dropSettings')
    </div>

    <!-- Main Content -->
    <main
        class="flex flex-col items-center min-h-[43rem] xl:min-h-full 2xl:h-[42rem] justify-center xl:h-[30rem] 2xl:min-h-full 2xl:mb-[12rem]">
        <h1 class="text-3xl font-bold text-gray-800 2xl:text-4xl 2xl:mt-10 2xl:mb-24 mb-9">Halaman Diagnosa</h1>
        <div
            class="relative bg-white 2xl:max-w-2xl 2xl:mt-14 rounded-lg shadow-xl p-12 max-w-[20rem] text-center xl:max-w-lg w-full">
            <!-- Background Design -->
            <div
                class="absolute -z-10 bg-orange-400 rounded-lg transform -rotate-6 top-4 left-3 xl:left-4 2xl:left-4 w-[93%] xl:w-full 2xl:w-full h-full scale-105">
            </div>
            <div
                class="absolute -z-20 bg-orange-300 rounded-lg transform -rotate-3 top-6 hidden sm:block left-6 w-full h-full scale-105">
            </div>

            <div
                class="absolute -z-10 bg-orange-400 rounded-lg transform -rotate-6 top-4 left-4 w-full hidden sm:block h-full scale-105">
            </div>
            <div
                class="absolute -z-20 bg-orange-300 rounded-lg transform -rotate-3 top-6 left-6 w-full hidden sm:block h-full scale-105">
            </div>

            <!-- Pertanyaan -->
            @if (isset($question) && $question && $question->gejala)
                <p class="text-xl text-gray-700 mb-8 2xl:text-3xl 2xl:mt-7">
                    Apakah sapi mengalami {{ $question->gejala->nama_gejala }}?
                </p>

                <!-- Tambahkan field deskripsi opsional -->
                @if (!empty($question->gejala->deskripsi))
                    <p class="text-gray-500 italic text-sm 2xl:text-lg mb-6">
                        Deskripsi: {{ $question->gejala->deskripsi }}
                    </p>
                @endif

                <!-- Hapus keterangan 'Opsional' atau 'Wajib dijawab' jika tidak ingin ditampilkan -->
                <form action="{{ route('diagnosa.answer') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kode_gejala" value="{{ $question->kode_gejala }}">
                    <div class="flex justify-center space-x-6 2xl:text-2xl">
                        <button type="submit" name="answer" value="1"
                            class="bg-green-400 text-white font-semibold 2xl:py-4 py-3 px-8 rounded-full hover:bg-orange-500">
                            Iya
                        </button>
                        <button type="submit" name="answer" value="0"
                            class="bg-green-400 text-white font-semibold py-3 px-8 rounded-full hover:bg-orange-500">
                            Tidak
                        </button>
                    </div>
                </form>
            @else
                <p class="text-xl text-red-600 font-semibold 2xl:text-2xl 2xl:mt-[2rem]">
                    Tolong diperhatikan dengan baik gejala yang akan muncul.
                </p>
                <a href="{{ route('diagnosa.index') }}"
                    class="mt-8 inline-block bg-orange-400 2xl:text-2xl text-white font-semibold 2xl:px-9 2xl:py-5 xl:py-3 xl:px-8 px-5 py-3 rounded-full hover:bg-orange-500">
                    Mulai Lakukan Diagnosa
                </a>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white 2xl:text-xl relative w-full mt-[93px] 2xl:mt-auto bottom-0">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

</html>
