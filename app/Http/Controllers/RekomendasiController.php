<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rekomendasi; // Pastikan model penyakit ditulis dengan huruf besar

class RekomendasiController extends Controller
{
    /**
     * Menampilkan halaman form untuk tambah data penyakit
     */
    public function dashboard()
{
    // Hitung jumlah penyakit
    $jumlahSolusi = rekomendasi::count();

    // Kirimkan ke view
    return view('admin.dashboard', [
        'jumlahSolusi' => $jumlahSolusi,
    ]);
}
    public function indexAdd()
    {
        return view('pages.AdminPages.CRUD.crud_Solusi.formAdd', [
            'title' => 'Tambah Data',
            'active' => 'Tambah Data',
        ]);
    }

    /**
     * Menampilkan daftar penyakit dengan paginasi dan fitur pencarian
     */
    public function index(Request $request)
    {
        $query = rekomendasi::query();

        // Menambahkan logika pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('kode_rekomendasi', 'like', "%{$search}%")
                ->orWhere('rekomendasi', 'like', "%{$search}%");
        }

        // Tambahkan paginasi ke query
        $rekomendasi = $query->paginate(5);

        // Cek apakah permintaan AJAX
        if ($request->ajax()) {
            return view('partials.solusiTable', ['rekomendasi' => $rekomendasi]);
        }

        return view('pages.AdminPages.tabelSolusi', [
            'title' => 'rekomendasi',
            'rekomendasi' => $rekomendasi,
            'activePage' => 'pages.AdminPages.tabelSolusi',
        ]);
    }

    /**
     * Menampilkan form untuk menambah penyakit
     */
        public function create()
    {
        // Ambil nomor urut terakhir untuk kolom No
        $lastNo = rekomendasi::max('No'); // Ambil ID terbesar sebagai nomor urut terakhir
        $nextNo = $lastNo ? $lastNo + 1 : 1; // Jika ada data, tambahkan 1, jika tidak mulai dari 1
        // Ambil kode penyakit terakhir di database
        $lastSolusi = rekomendasi::orderByRaw('CAST(SUBSTRING(kode_rekomendasi, 2) AS UNSIGNED) DESC')->first();

        // Tentukan kode penyakit berikutnya
        if ($lastSolusi) {
            // Mengambil angka terakhir setelah huruf P dan menambahkannya
            $lastKode = (int) substr($lastSolusi->kode_rekomendasi, 1); // Mengambil angka setelah huruf P
            $nextKode = 'S' .str_pad($lastKode + 1, 2, '0', STR_PAD_LEFT); // Menambah angka terakhir dan membuat kode baru
        } else {
            // Jika belum ada data, mulai dengan P1
            $nextKode = 'S01';
        }


        // Kirimkan kode penyakit berikutnya dan nomor urut ke view
        return view('pages.AdminPages.CRUD.crud_Solusi.formAdd', compact('nextKode', 'nextNo'));
    }


    /**
     * Menyimpan data penyakit baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_rekomendasi' => 'required|unique:rekomendasi,kode_rekomendasi',
            'rekomendasi' => 'required|max:10000',
            'No' => 'required|integer',  // Validasi nomor urut (No)
        ]);

        // Menyimpan data penyakit dengan No yang dihitung di controller
        rekomendasi::create([
            'No' => $request->No,  // Menyimpan nomor urut yang telah dihitung
            'kode_rekomendasi' => $request->kode_rekomendasi,
            'rekomendasi' => $request->rekomendasi,
        ]);

        // Mengarahkan kembali ke halaman daftar penyakit dengan pesan sukses
        return redirect()->route('solusi.create')->with('success', 'Rekomendasi berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit penyakit berdasarkan ID
     */
    public function edit($kode_rekomendasi)
    {
        $rekomendasi = rekomendasi::where('kode_rekomendasi', $kode_rekomendasi)->firstOrFail();

        return view('pages.AdminPages.CRUD.crud_Solusi.formEdit', [
            'rekomendasi' => $rekomendasi,
            'title' => 'Edit Rekomendasi',
        ]);
    }

    /**
     * Memperbarui data penyakit berdasarkan kode_solusi.
     */
    public function update(Request $request, $kode_rekomendasi)
    {
        // Validasi input
        $request->validate([
            'rekomendasi' => 'required|string|max:10000',
        ]);

        // Cari penyakit berdasarkan kode_solusi
        $rekomendasi = rekomendasi::where('kode_rekomendasi', $kode_rekomendasi)->firstOrFail();

        // Update data penyakit
        $rekomendasi->update([
            'rekomendasi' => $request->input('rekomendasi'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('solusi.edit', ['kode_rekomendasi' => $kode_rekomendasi])
            ->with('success', 'Rekomendasi berhasil diperbarui!');
    }


    /**
     * Menghapus penyakit berdasarkan ID
     */
    public function destroy($kode_rekomendasi)
{
    $rekomendasi = rekomendasi::where('kode_rekomendasi', $kode_rekomendasi)->first();

    if ($rekomendasi) {
        $rekomendasi->delete();
        return redirect()->route('Admin.solusi')->with('success', 'Rekomendasi berhasil dihapus.');
    }

    return redirect()->route('Admin.solusi')->with('error', 'Rekomendasi tidak ditemukan.');
}


// Ahli Pakar
    public function indexByPakar(Request $request)
    {
        $query = rekomendasi::query();

        // Menambahkan logika pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('kode_rekomendasi', 'like', "%{$search}%")
                ->orWhere('rekomendasi', 'like', "%{$search}%");
        }

        // Tambahkan paginasi ke query
        $rekomendasi = $query->paginate(5);

        // Cek apakah permintaan AJAX
        if ($request->ajax()) {
            return view('partials.solusiTable', ['rekomendasi' => $rekomendasi]);
        }

        return view('pages.PakarPages.tabelSolusi', [
            'title' => 'Rekomendasi',
            'rekomendasi' => $rekomendasi,
            'activePage' => 'pages.PakarPages.tabelSolusi',
        ]);
    }

    /**
     * Menampilkan form untuk menambah penyakit
     */
        public function createByPakar()
    {
        // Ambil nomor urut terakhir untuk kolom No
        $lastNo = rekomendasi::max('No'); // Ambil ID terbesar sebagai nomor urut terakhir
        $nextNo = $lastNo ? $lastNo + 1 : 1; // Jika ada data, tambahkan 1, jika tidak mulai dari 1
        // Ambil kode penyakit terakhir di database
        $lastSolusi = rekomendasi::orderByRaw('CAST(SUBSTRING(kode_rekomendasi, 2) AS UNSIGNED) DESC')->first();

        // Tentukan kode penyakit berikutnya
        if ($lastSolusi) {
            // Mengambil angka terakhir setelah huruf P dan menambahkannya
            $lastKode = (int) substr($lastSolusi->kode_rekomendasi, 1); // Mengambil angka setelah huruf P
            $nextKode = 'S' .str_pad($lastKode + 1, 2, '0', STR_PAD_LEFT); // Menambah angka terakhir dan membuat kode baru
        } else {
            // Jika belum ada data, mulai dengan P1
            $nextKode = 'S01';
        }


        // Kirimkan kode penyakit berikutnya dan nomor urut ke view
        return view('pages.PakarPages.CRUD.crud_Solusi.formAdd', compact('nextKode', 'nextNo'));
    }


    /**
     * Menyimpan data penyakit baru ke database
     */
    public function storeByPakar(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_rekomendasi' => 'required|unique:rekomendasi,kode_rekomendasi',
            'rekomendasi' => 'required|max:10000',
            'No' => 'required|integer',  // Validasi nomor urut (No)
        ]);

        // Menyimpan data penyakit dengan No yang dihitung di controller
        rekomendasi::create([
            'No' => $request->No,  // Menyimpan nomor urut yang telah dihitung
            'kode_rekomendasi' => $request->kode_rekomendasi,
            'rekomendasi' => $request->rekomendasi,
        ]);

        // Mengarahkan kembali ke halaman daftar penyakit dengan pesan sukses
        return redirect()->route('solusiPakar.create')->with('success', 'Rekomendasi berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit penyakit berdasarkan ID
     */
    public function editByPakar($kode_rekomendasi)
    {
        $rekomendasi = rekomendasi::where('kode_rekomendasi', $kode_rekomendasi)->firstOrFail();

        return view('pages.PakarPages.CRUD.crud_Solusi.formEdit', [
            'rekomendasi' => $rekomendasi,
            'title' => 'Edit Rekomendasi',
        ]);
    }

    /**
     * Memperbarui data penyakit berdasarkan kode_solusi.
     */
    public function updateByPakar(Request $request, $kode_rekomendasi)
    {
        // Validasi input
        $request->validate([
            'rekomendasi' => 'required|string|max:10000',
        ]);

        // Cari penyakit berdasarkan kode_solusi
        $rekomendasi = rekomendasi::where('kode_rekomendasi', $kode_rekomendasi)->firstOrFail();

        // Update data penyakit
        $rekomendasi->update([
            'rekomendasi' => $request->input('rekomendasi'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('solusiPakar.edit', ['kode_rekomendasi' => $kode_rekomendasi])
            ->with('success', 'Rekomendasi berhasil diperbarui!');
    }


    /**
     * Menghapus penyakit berdasarkan ID
     */
    public function destroyByPakar($kode_rekomendasi)
{
    $rekomendasi = rekomendasi::where('kode_rekomendasi', $kode_rekomendasi)->first();

    if ($rekomendasi) {
        $rekomendasi->delete();
        return redirect()->route('Pakar.solusi')->with('success', 'Rekomendasi berhasil dihapus.');
    }

    return redirect()->route('Pakar.solusi')->with('error', 'Rekomendasi tidak ditemukan.');
}


    // /**
    //  * Menghapus beberapa penyakit yang dipilih
    //  */
    // public function deleteSelected(Request $request)
    // {
    //     $selectedIds = $request->input('solusi_ids');

    //     if ($selectedIds) {
    //         solusi::whereIn('id', $selectedIds)->delete();
    //         return redirect()->route('Admin.solusi')->with('success', 'Solusi berhasil dihapus.');
    //     }

    //     return redirect()->route('Admin.solusi')->with('error', 'Tidak ada solusi yang dipilih untuk dihapus.');
    // }
}
