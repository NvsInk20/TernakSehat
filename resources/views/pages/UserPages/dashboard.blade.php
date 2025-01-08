<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Flowbite CSS -->
    @vite('resources/css/app.css')
    <link rel="icon" href="/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
    @if (session('success'))
        <div class="bg-green-500 text-white lg:p-3 pl-16 p-3 2xl:text-xl rounded mb-4 transition-opacity duration-300"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-3 2xl:text-xl rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @include('components.navbar')

    <div class="hidden xl:block">
        @include('components.dropSettings')
    </div>
    <div class="sm:hidden block mt-28 w-1/2 mx-auto">
        <img src="/images/logo.png" class="w-40" alt="Logo">
    </div>
    <main>
        <div class="xl:py-10 px-4 mt-0">
            <div id="halamanAtas" class="2xl:h-[88vh]">
                <div class="ml-4 2xl:ml-20">
                    <div class="mb-10 flex flex-col md:flex-row 2xl:mb-16">
                        <div class="md:w-1/2 p-8 2xl:mt-36 xl:mt-14 mt-5">
                            <h2 class="xl:text-5xl text-[23px] font-bold 2xl:text-7xl text-gray-800">Sistem Pakar
                                Diagnosa Kesehatan Sapi</h2>
                            <p class="text-gray-600 mt-4 text-base sm:text-lg md:text-xl 2xl:text-2xl">Sistem pakar
                                untuk diagnosa kesehatan sapi untuk membantu mendeteksi penyakit secara cepat dan tepat.
                            </p>
                            <button
                                class="mt-6 bg-orange-400 text-white 2xl:text-2xl font-semibold py-2 px-6 2xl:py-4 2xl:px-8 rounded-full hover:bg-orange-500"><a
                                    href="/diagnosa/options">Mulai Diagnosa</a></button>
                        </div>
                        <div class="md:w-1/2 flex justify-center ml-3 p-8 relative">
                            <div
                                class="absolute lg:max-w-80 lg:ml-20 lg:h-80 xl:ml-40 2xl:ml-48 2xl:mt-20 ml-2 w-[83%] h-[76%] rounded-xl 2xl:max-w-[33rem] 2xl:h-5/6 inset-0 bg-gradient-to-r from-orange-300 to-orange-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl z-0 mt-10">
                            </div>
                            <img src="/images/sapii.png" alt="Cow Image"
                                class="relative rounded-lg lg:ml-3 2xl:w-3/5 2xl:mt-14 lg:w-80 shadow-lg z-10 -ml-10 max-w-full">
                        </div>
                    </div>
                </div>
            </div>

            <div id="section" class="2xl:h-screen h-screen">
                <div class="bg-orange-100 rounded-lg shadow-lg p-10 " id="latar">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <div class="absolute -bottom-2 -right-2 2xl:h-16 bg-orange-500 rounded-lg w-full h-full">
                            </div>
                            <div
                                class="relative bg-white border 2xl:mt-20 border-black 2xl:text-3xl px-4 2xl:px-10 2xl:py-5 py-2 rounded-lg text-black xl:text-2xl text-lg font-semibold">
                                Daftar Penyakit
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-6">
                        <img src="/images/dokter.png" alt="Doctor Illustration"
                            class="w-72 2xl:w-1/3 h-72 2xl:h-3/5 mt-10 xl:ml-16 xl:w-96 xl:h-96 -ml-8 absolute max-w-full">
                    </div>
                    <div class="mt-[22rem] xl:ml-[45%] xl:mt-40 2xl:mt-72 2xl:ml-[52%]">
                        <h2
                            class="text-gray-700 text-lg 2xl:text-5xl xl:text-4xl 2xl:w-[48rem] xl:w-[36rem] font-semibold">
                            Daftar Penyakit Hewan Ternak Sapi Di Kabupaten Boyolali</h2>
                        <p class="text-gray-600 2xl:text-lg text-sm 2xl:w-[45rem] mt-2 xl:w-[36rem]">Mulai dari berbagai
                            penyakit sapi beserta penyebab dan pencegahannya untuk meningkatkan kesehatan hewan.</p>
                        <button
                            class="mt-6 bg-orange-400 text-white 2xl:text-2xl font-semibold py-2 px-6 2xl:py-4 2xl:px-8  rounded-full hover:bg-orange-500">
                            <a href="/User/penyakit">Cek Penyakit</a></button>
                    </div>
                </div>
            </div>

            <div class="section3">
                <div class="flex-row 2xl:min-h-60" id="latar3">
                    <div class="text-center mt-16" id="footerUser">
                        <div class="relative inline-block">
                            <div class="absolute -bottom-2 -right-2 2xl:h-16 bg-orange-500 rounded-lg w-full h-full">
                            </div>
                            <div
                                class="relative bg-white border 2xl:mt-20 border-black 2xl:text-3xl px-4 2xl:px-10 2xl:py-5 py-2 rounded-lg text-black text-lg xl:text-2xl font-semibold">
                                Manfaat Sistem
                            </div>
                        </div>
                    </div>
                    <div class="flexitems-center mt-16" id="footerContent">
                        <div class="relative inline-block 2xl:ml-[11rem]">
                            <div class="absolute -bottom-2 2xl:mt-1 -right-2 bg-orange-500 rounded-lg w-full h-full">
                            </div>
                            <div
                                class="relative bg-white text-md 2xl:text-2xl xl:text-xl xl:ml-2 xl:w-[38rem] -ml-12 w-[18rem] 2xl:w-[47rem] border border-black px-4 py-2 rounded-lg text-black font-semibold">
                                <p>
                                    sistem ini bisa membantu peternak mengambil langkah cepat dalam menangani penyakit,
                                    mencegah penyebaran penyakit lebih lanjut, serta mengurangi risiko kerugian ekonomi
                                    akibat penyakit yang terlambat diobati. Selain itu, sistem pakar juga dapat
                                    meningkatkan produktivitas dan efisiensi peternakan karena memungkinkan pengelolaan
                                    kesehatan ternak yang lebih baik dan tepat waktu.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="ml-[60%] hidden xl:block 2xl:block mt-20 2xl:mt-1">
                        <img src="/images/footerSapi.png" alt="Doctor Illustration" class="ml-20 2xl:w-[30rem] -mt-80">

                    </div>
                </div>
            </div>
    </main>
    <script>
        // Tailwind Custom Script for Smooth Scroll
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
    <!-- Footer -->
    <footer class="p-5 bg-orange-500 text-center text-white mt-16 xl:mt-0 2xl:mt-0 2xl:text-xl">
        <p class="font-medium">Ternak Sehat © {{ date('Y') }}</p>
    </footer>
</body>

</html>
