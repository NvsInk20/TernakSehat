<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi Pengguna</title>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="icon" href="/images/logo.png">
    <!-- Flowbite CSS -->
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-orange-100 min-h-screen flex items-center justify-center">
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
    <div
        class="bg-white shadow-lg rounded-lg my-10 mx-4 xl:my-10 max-w-md xl:mx-auto mt-10 mb-10 p-6 sm:p-10 lg:max-w-lg">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('/images/logo.png') }}" alt="Ternak Sehat" class="w-24 h-24">
        </div>
        <h1 class="text-2xl font-semibold text-center mb-6">Registrasi Pengguna</h1>
        <form action="/Register" method="POST">
            @csrf

            <!-- Nama Field -->
            <div class="relative mb-6">
                <label for="nama" class="text-gray-600 text-sm">Nama</label>
                <input type="text" id="nama" name="nama" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan nama" value="{{ old('nama') }}">
                @error('nama')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- username Field -->
            <div class="relative mb-6">
                <label for="username" class="text-gray-600 text-sm">Username</label>
                <input type="text" id="username" name="username" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan username" value="{{ old('username') }}">
                @error('username')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nomor Telepon Field -->
            <div class="relative mb-6">
                <label for="nomor_telp" class="text-gray-600 text-sm">Nomor Telepon (Opsional)</label>
                <input type="text" id="nomor_telp" name="nomor_telp"
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan nomor telepon (opsional)" value="{{ old('nomor_telp') }}">
                @error('nomor_telp')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>


            <!-- Password Field -->
            <div class="relative mb-6">
                <label for="password" class="text-gray-600 text-sm">Password</label>
                <input type="password" id="password" name="password" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan password">
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-2 mt-7 flex items-center px-2 text-gray-500 hover:text-gray-700">
                    <!-- Ikon mata dengan coretan dinamis -->
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" class="w-6 h-6">
                        <!-- Bentuk mata -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12m0 0a3 3 0 11-6 0 3 3 0 016 0zm6-0.5c0-3.5-4-6.5-9-6.5S3 8.5 3 12s4 6.5 9 6.5 9-3 9-6.5z" />
                        <!-- Coretan dinamis -->
                        <path id="eyeSlash" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M4 4l16 16" />
                    </svg>
                </button>
                @error('password')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <script>
                const togglePassword = document.querySelector('#togglePassword');
                const passwordInput = document.querySelector('#password');
                const eyeSlash = document.querySelector('#eyeSlash');

                togglePassword.addEventListener('click', function() {
                    // Toggle the input type
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the coretan pada ikon mata
                    eyeSlash.classList.toggle('hidden');
                });
            </script>

            <!-- Confirm Password Field -->
            <div class="relative mb-6">
                <label for="password_confirmation" class="text-gray-600 text-sm">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan ulang password">
                <button type="button" id="toggleConfirmPassword"
                    class="absolute inset-y-0 right-2 mt-7 flex items-center px-2 text-gray-500 hover:text-gray-700">
                    <!-- Ikon mata dengan coretan dinamis -->
                    <svg id="eyeIconConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <!-- Bentuk mata -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12m0 0a3 3 0 11-6 0 3 3 0 016 0zm6-0.5c0-3.5-4-6.5-9-6.5S3 8.5 3 12s4 6.5 9 6.5 9-3 9-6.5z" />
                        <!-- Coretan dinamis -->
                        <path id="eyeSlashConfirmPassword" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 4l16 16" />
                    </svg>
                </button>
                @error('password_confirmation')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <script>
                const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
                const confirmPasswordInput = document.querySelector('#password_confirmation');
                const eyeSlashConfirmPassword = document.querySelector('#eyeSlashConfirmPassword');

                toggleConfirmPassword.addEventListener('click', function() {
                    // Toggle the input type
                    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPasswordInput.setAttribute('type', type);

                    // Toggle the coretan pada ikon mata
                    eyeSlashConfirmPassword.classList.toggle('hidden');
                });
            </script>

            <!-- Display Role Field -->
            <div class="relative mb-6">
                <label class="text-gray-600 text-sm">Role</label>
                <input type="text" value="User (Peternak)" disabled
                    class="bg-gray-200 mt-2 h-10 w-full border-b-2 border-gray-300 text-gray-700 focus:outline-none cursor-not-allowed"
                    placeholder="User (Peternak)">
            </div>

            <!-- Hidden Role Field for Ahli Pakar -->
            <input type="hidden" name="role" value="user">

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-400 text-white font-semibold rounded-md px-6 py-2 mt-3">
                    Daftar
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-orange-500 hover:underline">Kembali ke halaman utama</a>
        </div>
    </div>
</body>

</html>
