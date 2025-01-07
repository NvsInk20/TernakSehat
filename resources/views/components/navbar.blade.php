<div class="max-w-full -mt-10">

    <!-- Logo dan Nama Brand -->
    <div class="xl:ml-12 absolute hidden 2xl:block xl:block xl:-mt-6">
        <img src="/images/logo.png" alt="Logo" class="xl:w-24 xl:h-24 w-4 h-4 rounded-full mr-3 2xl:w-32 2xl:h-32">
    </div>

    <nav
        class="bg-orange-200 rounded-full px-4 py-2 w-[21rem] ml-3 xl:w-[30rem] 2xl:w-[44rem] 2xl:mt-20 mb-10 shadow-md mt-20 xl:ml-28 2xl:ml-32 2xl:px-2 2xl:py-4">
        <div class="flex items-center ml-2 xl:ml-16 2xl:ml-24">
            <!-- Link Navigasi -->
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
