<div class="max-w-full -mt-10">

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
                        class="{{ request()->is('User/Diagnosa*') || request()->is('diagnosa*') || request()->is('another-pattern*') ? 'text-black font-bold' : 'text-gray-700' }} hover:text-orange-600">
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
