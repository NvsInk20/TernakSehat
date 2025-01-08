<div class="max-w-full -mt-10">
    <!-- Logo dan Nama Brand -->
    <div class="xl:ml-12 absolute hidden 2xl:block xl:block xl:-mt-6">
        <img src="/images/logo.png" alt="Logo" class="xl:w-24 xl:h-24 w-4 h-4 rounded-full mr-3 2xl:w-32 2xl:h-32">
    </div>

    <!-- Hamburger Menu Button (Mobile) -->
    <div class="lg:hidden fixed top-4 left-4 z-50 flex items-center space-x-5">
        <button id="hamburger-btn" class="p-2 bg-orange-500 rounded-full shadow-md text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
        <span id="menu-label" class="hidden text-gray-700 font-medium text-lg">Menu</span>
    </div>


    <!-- Sidebar Menu (Hidden by Default) -->
    <div id="sidebar-menu"
        class="fixed top-0 left-0 h-full w-1/2 max-w-sm bg-orange-100 shadow-lg z-40 transform -translate-x-full transition-transform duration-300">
        <div class="p-4 mt-14">
            <ul class="space-y-4">
                <li>
                    <a href="/User/Dashboard" class="block text-gray-700 hover:text-orange-600">Dashboard</a>
                </li>
                <li>
                    <a href="/diagnosa/options" class="block text-gray-700 hover:text-orange-600">Diagnosa</a>
                </li>
                <li>
                    <a href="/user/riwayat-diagnosa" class="block text-gray-700 hover:text-orange-600">Riwayat</a>
                </li>
                <li>
                    <a href="{{ route('profile.settings', Auth::user()->kode_auth) }}"
                        class="block text-gray-700 hover:text-orange-600">Settings</a>
                </li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="block text-gray-700 hover:text-orange-600">
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Navbar for larger screens -->
    <nav
        class="hidden lg:block bg-orange-200 rounded-full px-4 py-2 w-[21rem] ml-3 xl:w-[30rem] 2xl:w-[44rem] 2xl:mt-20 mb-10 shadow-md mt-20 xl:ml-28 2xl:ml-32 2xl:px-2 2xl:py-4">
        <div class="flex items-center ml-2 xl:ml-16 2xl:ml-24">
            <ul class="flex space-x-8 xl:space-x-10 2xl:space-x-12 text-lg xl:text-xl 2xl:text-3xl font-medium">
                <li>
                    <a href="/User/Dashboard"
                        class="{{ request()->is('User/Dashboard') ? 'text-black font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/diagnosa/options"
                        class="{{ request()->is('/diagnosa/options*') || request()->is('diagnosa*') || request()->is('another-pattern*') ? 'text-black font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Diagnosa
                    </a>
                </li>
                <li>
                    <a href="/user/riwayat-diagnosa"
                        class="{{ request()->is('user/riwayat-diagnosa') ? 'text-black font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Riwayat
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- JavaScript for Hamburger Menu Toggle -->
<script>
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const sidebarMenu = document.getElementById('sidebar-menu');
    const menuLabel = document.getElementById('menu-label');

    // Toggle menu saat tombol hamburger diklik
    hamburgerBtn.addEventListener('click', (event) => {
        event.stopPropagation(); // Mencegah klik tombol menutup menu
        if (sidebarMenu.classList.contains('-translate-x-full')) {
            sidebarMenu.classList.remove('-translate-x-full');
            sidebarMenu.classList.add('translate-x-0');
            menuLabel.classList.remove('hidden'); // Tampilkan tulisan "Menu"
        } else {
            sidebarMenu.classList.remove('translate-x-0');
            sidebarMenu.classList.add('-translate-x-full');
            menuLabel.classList.add('hidden'); // Sembunyikan tulisan "Menu"
        }
    });

    // Tutup menu saat klik di luar sidebar
    document.addEventListener('click', (event) => {
        if (!sidebarMenu.contains(event.target) && !hamburgerBtn.contains(event.target)) {
            sidebarMenu.classList.remove('translate-x-0');
            sidebarMenu.classList.add('-translate-x-full');
            menuLabel.classList.add('hidden'); // Sembunyikan tulisan "Menu"
        }
    });
</script>
