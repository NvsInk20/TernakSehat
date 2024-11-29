<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Flowbite CSS -->
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    @if (session('success'))
        <div class="text-green-600 absolute text-sm mb-2 mt-10 ml-[50%] text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="text-red-600 text-sm mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="left">
            <div class="image-container">
                <img src="{{ asset('images/logo.png') }}" alt="Ternak Sehat">
            </div>
        </div>
        <div class="right">
            <nav>
                <a href="{{ route('landingpage') }}">Kembali</a>
            </nav>
        </div>
    </div>
    <!-- component -->
    <div class="kartu">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- component -->
            <div class="bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
                <div class="relative py-4 sm:max-w-xl sm:mx-auto">
                    <div
                        class="absolute inset-0 mt-4 bg-gradient-to-r from-orange-300 to-orange-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
                    </div>
                    <div class="relative px-4 py-4 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                        <div class="max-w-screen mx-36">
                            <div>
                                <h1 class="text-2xl mt-2 font-semibold text-center">Silahkan Login</h1>
                            </div>
                            <div class="divide-y divide-gray-200">
                                <div
                                    class="relative py-8 text-base leading-6 space-y-4 text-gray-700 -ml-32 sm:text-lg sm:leading-7">
                                    <div class="relative -mr-32">
                                        <label for="email"
                                            class="absolute left-0 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-4 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">E-Mail
                                        </label>
                                        <input autocomplete="off" id="email" name="email" type="email"
                                            class="form-control @error('email') border-red-600 @enderror mt-6 peer placeholder-transparent h-10 w-full my-3 border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600"
                                            placeholder="email" required value="{{ old('email') }}"
                                            style="border-color: orange !important;" />
                                        @error('email')
                                            <div class="text-red-600 text-sm -mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="relative -mr-32">
                                        <label for="password"
                                            class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-4 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password

                                        </label>
                                        <input autocomplete="off" id="password" name="password" type="password"
                                            class="form-control @error('password') border-red-600 @enderror peer placeholder-transparent my-3 h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600"
                                            placeholder="password" required style="border-color: orange !important;" />
                                        @error('password')
                                            <div class="text-red-600 text-sm -mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    @if ($errors->has('login'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('login') }}
                                        </div>
                                    @endif
                                    <div class="relative">
                                        <button
                                            class="bg-orange-500 hover:bg-orange-400 hover:text-black text-white rounded-md px-6 py-2 ml-48 mt-3">Login</button>
                                    </div>
                                </div>
                                <h2 class="-ml-4 mb-4">Belum punya akun? <a class="cursor-pointer"
                                        href="/Register"><span class="text-orange-700 hover:text-orange-400">Daftar
                                            Sekarang!</span></a></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
