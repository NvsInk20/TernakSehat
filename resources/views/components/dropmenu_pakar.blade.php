<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="max-w-52 -mt-[5px]">
    <form method="GET" x-data="{ selectedPage: '{{ request()->segment(2) }}', openDropdown: false }">
        <div>
            <button @click.prevent="openDropdown = !openDropdown" type="button" class="dropdown-btn">
                <span
                    x-text="selectedPage ? (selectedPage === 'penyakit' ? 'Data Penyakit' : selectedPage === 'gejala' ? 'Data Gejala' : 'Data Solusi') : 'Pilih Data'"></span>
                <svg class="w-5 h-5 ml-2 transition-transform transform" fill="currentColor" viewBox="0 0 20 20"
                    :class="{ 'rotate-180': openDropdown }">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="dropdown-items" x-show="openDropdown" x-transition>
            <a href="/ahli_pakar/penyakit" class="{{ request()->segment(2) === 'penyakit' ? 'active' : '' }}">Data
                Penyakit</a>
            <a href="/ahli_pakar/gejala" class="{{ request()->segment(2) === 'gejala' ? 'active' : '' }}">Data
                Gejala</a>
            <a href="/ahli_pakar/solusi" class="{{ request()->segment(2) === 'solusi' ? 'active' : '' }}">Data
                Solusi</a>
        </div>

    </form>

</div>
<style>
    /* Styling tombol utama */
    .dropdown-btn {
        background-color: #2563eb;
        color: #ffffff;
        font-weight: bold;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .dropdown-btn:hover {
        background-color: #1e40af;
    }

    /* Styling dropdown items */
    .dropdown-items {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 5px;
        padding: 5px 0;
        position: relative;
        z-index: 10;
    }

    .dropdown-items a {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #1f2937;
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .dropdown-items a:hover {
        background-color: #f3f4f6;
        color: #1e40af;
    }

    /* Gaya untuk item aktif */
    .dropdown-items a.active {
        background-color: #2563eb;
        color: #ffffff;
        font-weight: bold;
    }

    /* Tambahkan transisi untuk dropdown */
    .dropdown-items[x-show="false"] {
        display: none;
    }
</style>
