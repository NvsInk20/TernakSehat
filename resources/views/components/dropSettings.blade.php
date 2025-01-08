{{-- DropDown --}}
<div class="absolute top-0 left-0" id="container">
    <!-- Dropdown Kiri -->
    <div class="relative" x-data="{ openSort1: false }">
        <!-- Tombol Dropdown dengan Logo Akun -->
        <button @click.prevent="openSort1 = !openSort1"
            class="flex items-center py-3 px-6 2xl:px-8 2xl:py-4 2xl:mt-3 text-md font-semibold bg-white rounded-full shadow-md hover:bg-gray-100 focus:outline-none">
            <!-- Logo Akun -->
            <img src="/images/profile.png" alt="Akun" class="w-10 h-10 2xl:w-14 2xl:h-14 rounded-full">
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{ 'rotate-180': openSort1, 'rotate-0': !openSort1 }"
                class="w-6 2xl:w-10 2xl:h-10 h-6 ml-2 transition-transform duration-200 transform">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

        <!-- Isi Dropdown -->
        <div x-show="openSort1" x-transition
            class="absolute right-0 mt-3 w-48 2xl:w-60 rounded-lg shadow-lg bg-white z-20">
            <div class="py-3 2xl:py-4">
                <!-- Form untuk Settings -->
                <a href="{{ route('profile.settings', Auth::user()->kode_auth) }}"
                    class="block px-5 py-3 2xl:text-xl text-md text-gray-700 hover:bg-gray-100 rounded flex items-center w-full text-left">
                    <img src="/images/settings.png" alt="settings" class="mr-3 w-6 2xl:w-10">
                    Settings
                </a>


                <!-- Form untuk Logout -->
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-5 py-3 text-md 2xl:text-xl text-gray-700 hover:bg-gray-100 rounded flex items-center w-full text-left">
                        <img src="/images/logout.png" alt="logout" class="mr-3 w-6 2xl:w-10">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
