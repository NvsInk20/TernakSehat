<div class="max-w-full -mt-10">
    {{-- DropDown --}}
    <div class="absolute top-0 left-0" id="container">
        <!-- Dropdown Kiri -->
        <div class="relative" x-data="{ openSort1: false }">
            <!-- Tombol Dropdown dengan Logo Akun -->
            <button @click.prevent="openSort1 = !openSort1"
                class="flex items-center py-3 px-6 text-md font-semibold bg-white rounded-full shadow-md hover:bg-gray-100 focus:outline-none">
                <!-- Logo Akun -->
                <img src="/images/profile.png" alt="Akun" class="w-10 h-10 rounded-full">
                <svg fill="currentColor" viewBox="0 0 20 20"
                    :class="{ 'rotate-180': openSort1, 'rotate-0': !openSort1 }"
                    class="w-6 h-6 ml-2 transition-transform duration-200 transform">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Isi Dropdown -->
            <div x-show="openSort1" x-transition class="absolute right-0 mt-3 w-48 rounded-lg shadow-lg bg-white z-20">
                <div class="py-3">
                    <!-- Form untuk Settings -->
                    <form action="/settings/{id}/edit" method="GET">
                        <button type="submit"
                            class="block px-5 py-3 text-md text-gray-700 hover:bg-gray-100 rounded flex items-center w-full text-left">
                            <img src="/images/settings.png" alt="settings" class="mr-3 w-6">
                            Settings
                        </button>
                    </form>

                    <!-- Form untuk Logout -->
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                            class="block px-5 py-3 text-md text-gray-700 hover:bg-gray-100 rounded flex items-center w-full text-left">
                            <img src="/images/logout.png" alt="logout" class="mr-3 w-6">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logo dan Nama Brand -->
    <div class="ml-12 absolute -mt-6">
        <img src="/images/logo.png" alt="Logo" class="w-24 h-24 rounded-full mr-3">
    </div>

    <nav class="bg-orange-200 rounded-full px-4 py-2 w-1/3 mb-10 shadow-md mt-20 ml-24">
        <div class="flex items-center ml-20">
            <!-- Link Navigasi -->
            <ul class="flex space-x-8 text-lg font-medium">
                <li>
                    <a href="/User/Dashboard"
                        class="{{ request()->is('User/Dashboard') ? 'text-black font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/User/Diagnosa"
                        class="{{ request()->is('User/Diagnosa') ? 'text-black font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Diagnosa
                    </a>
                </li>
                <li>
                    <a href="/User/Riwayat"
                        class="{{ request()->is('User/Riwayat') ? 'text-black font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Riwayat
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
