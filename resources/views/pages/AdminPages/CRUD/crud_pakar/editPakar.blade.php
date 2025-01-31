<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perbarui Akun</title>
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

<body class="bg-orange-100 min-h-screen flex items-center justify-center">
    @include('components.dropSettings')
    @if (session('success'))
        <div class="bg-green-500 text-white p-3 mb-4 transition-opacity duration-300" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-3 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg w-full xl:my-10 max-w-lg mx-auto p-6 sm:p-10">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('/images/logo.png') }}" alt="Ternak Sehat" class="w-24 h-24">
        </div>
        <h1 class="text-3xl font-semibold text-center mb-6 text-gray-800">Perbarui Akun</h1>

        <!-- Update Profile Form -->
        <form
            action="{{ route('admin.updatePakar', ['role' => $role, 'kode' => $user->kode_ahliPakar ?? $user->kode_user]) }}"
            method="POST">
            @csrf
            @method('PUT') <!-- This will make the form use PUT method -->

            <!-- Nama Field -->
            <div class="mb-6">
                <label for="nama" class="block text-gray-700 text-sm font-medium">Nama</label>
                <input type="text" id="nama" name="nama" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    value="{{ old('nama', $user->nama) }}">
                @error('nama')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- username Field -->
            <div class="mb-6">
                <label for="username" class="block text-gray-700 text-sm font-medium">Username</label>
                <input type="text" id="username" name="username" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    value="{{ old('username', $user->username) }}">
                @error('username')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nomor Telepon Field -->
            <div class="relative mb-6">
                <label for="nomor_telp" class="text-gray-600 text-sm">Nomor Telepon (Opsional)</label>
                <input type="text" id="nomor_telp" name="nomor_telp"
                    class="form-control mt-2 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    placeholder="Masukkan nomor telepon (opsional)" value="{{ old('nomor_telp', $nomorTelepon) }}">
                @error('nomor_telp')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <!-- Spesialis Field -->
            <div class="mb-6">
                <label for="spesialis" class="block text-gray-700 text-sm font-medium">Spesialis</label>
                <input type="text" id="spesialis" name="spesialis" required
                    class="mt-2 h-12 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                    value="{{ old('spesialis', $spesialis) }}">
                @error('spesialis')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field (Optional) -->
            <div class="relative mb-6">
                <label for="password" class="block text-gray-700 text-sm font-medium">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="mt-2 h-12 w-full pr-12 border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                        placeholder="Kosongkan jika tidak ingin mengubah">
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700">
                        <!-- Ikon mata -->
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12m0 0a3 3 0 11-6 0 3 3 0 016 0zm6-0.5c0-3.5-4-6.5-9-6.5S3 8.5 3 12s4 6.5 9 6.5 9-3 9-6.5z" />
                            <path id="eyeSlash" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 4l16 16" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="relative mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium">Konfirmasi
                    Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="mt-2 h-12 w-full pr-12 border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-orange-500"
                        placeholder="Masukkan ulang password">
                    <button type="button" id="toggleConfirmPassword"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700">
                        <!-- Ikon mata -->
                        <svg id="eyeIconConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12m0 0a3 3 0 11-6 0 3 3 0 016 0zm6-0.5c0-3.5-4-6.5-9-6.5S3 8.5 3 12s4 6.5 9 6.5 9-3 9-6.5z" />
                            <path id="eyeSlashConfirmPassword" class="hidden" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M4 4l16 16" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <script>
                // Password toggle
                const togglePassword = document.querySelector('#togglePassword');
                const passwordInput = document.querySelector('#password');
                const eyeSlash = document.querySelector('#eyeSlash');

                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeSlash.classList.toggle('hidden');
                });

                // Confirm Password toggle
                const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
                const confirmPasswordInput = document.querySelector('#password_confirmation');
                const eyeSlashConfirmPassword = document.querySelector('#eyeSlashConfirmPassword');

                toggleConfirmPassword.addEventListener('click', function() {
                    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPasswordInput.setAttribute('type', type);
                    eyeSlashConfirmPassword.classList.toggle('hidden');
                });
            </script>


            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-orange-500 text-white text-sm px-6 py-3 rounded-lg hover:bg-orange-600 
               hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 
               focus:ring-orange-400 transition-transform duration-300 ease-in-out">
                    Perbarui Profil
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ session('previous_url', route('admin.pakar')) }}"
                class="flex items-center justify-center p-4 rounded-lg border border-orange-500 text-orange-500 
        hover:bg-orange-500 hover:text-white transition group">
                <span>Kembali</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 ml-2 transform transition-transform duration-300 group-hover:translate-x-40">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</body>

</html>
