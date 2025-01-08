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
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-11 2xl:text-4xl">Halaman Diagnosa</h1>
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

            <!-- Header -->

            <!-- Form -->
            <form action="{{ route('diagnosa.mulai') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilih Opsi -->
                <div>
                    <label for="pilihan"
                        class="block font-medium text-gray-700 mb-2 -mt-7 2xl:text-2xl text-left">Pilih
                        Diagnosa</label>
                    <select id="pilihan" name="pilihan"
                        class="w-full border border-gray-300 rounded-md shadow-sm p-3 2xl:text-xl focus:ring-2 focus:ring-orange-400 focus:outline-none">
                        <option value="baru">Diagnosa Baru</option>
                        <option value="riwayat">Lanjutkan Diagnosa dengan Riwayat</option>
                    </select>
                </div>

                <!-- Riwayat Diagnosa (Hidden) -->
                <div id="riwayat-container" class="hidden">
                    <label for="kode_sapi" class="block font-medium text-gray-700 mb-2 2xl:text-2xl text-left">Pilih
                        Kode
                        Sapi</label>
                    <select id="kode_sapi" name="kode_sapi"
                        class="w-full border border-gray-300 rounded-md 2xl:text-xl shadow-sm p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                        @foreach ($riwayat as $item)
                            <option value="{{ $item->kode_sapi }}">{{ $item->kode_sapi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 2xl:text-2xl bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-md transition duration-200">
                    Lanjutkan
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white 2xl:text-xl relative w-full mt-[93px] 2xl:mt-auto bottom-0">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

<script>
    document.getElementById('pilihan').addEventListener('change', function() {
        var riwayatContainer = document.getElementById('riwayat-container');
        riwayatContainer.style.display = this.value === 'riwayat' ? 'block' : 'none';
    });
</script>

</html>
