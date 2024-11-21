<?php

namespace App\Http\Controllers;

use App\Models\penyakit; // Pastikan model penyakit ditulis dengan huruf besar
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    /**
     * Menampilkan halaman form untuk tambah data penyakit
     */
    public function dashboard()
{
    // Hitung jumlah penyakit
    $jumlahPenyakit = penyakit::count();

    // Kirimkan ke view
    return view('admin.dashboard', [
        'jumlahPenyakit' => $jumlahPenyakit,
    ]);
}
    public function indexAdd()
    {
        return view('pages.AdminPages.CRUD.crud_Penyakit.formAdd', [
            'title' => 'Tambah Data',
            'active' => 'Tambah Data',
        ]);
    }

    /**
     * Menampilkan daftar penyakit dengan paginasi dan fitur pencarian
     */
    public function index(Request $request)
    {
        $query = penyakit::query();

        // Menambahkan logika pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('kode_penyakit', 'like', "%{$search}%")
                ->orWhere('nama_penyakit', 'like', "%{$search}%");
        }

        // Tambahkan paginasi ke query
        $penyakit = $query->paginate(5);

        // Cek apakah permintaan AJAX
        if ($request->ajax()) {
            return view('partials.penyakitTable', ['penyakit' => $penyakit]);
        }

        return view('pages.AdminPages.tabelPenyakit', [
            'title' => 'Penyakit',
            'penyakit' => $penyakit,
            'activePage' => 'pages.AdminPages.tabelPenyakit',
        ]);
    }

    /**
     * Menampilkan form untuk menambah penyakit
     */
        public function create()
    {
        // Ambil nomor urut terakhir untuk kolom No
        $lastNo = penyakit::max('No'); // Ambil ID terbesar sebagai nomor urut terakhir
        $nextNo = $lastNo ? $lastNo + 1 : 1; // Jika ada data, tambahkan 1, jika tidak mulai dari 1
        // Ambil kode penyakit terakhir di database
        $lastPenyakit = penyakit::orderByRaw('CAST(SUBSTRING(kode_penyakit, 2) AS UNSIGNED) DESC')->first();

        // Tentukan kode penyakit berikutnya
        if ($lastPenyakit) {
            // Mengambil angka terakhir setelah huruf P dan menambahkannya
            $lastKode = (int) substr($lastPenyakit->kode_penyakit, 1); // Mengambil angka setelah huruf P
            $nextKode = 'P' .str_pad($lastKode + 1, 2, '0', STR_PAD_LEFT); // Menambah angka terakhir dan membuat kode baru
        } else {
            // Jika belum ada data, mulai dengan P1
            $nextKode = 'P01';
        }


        // Kirimkan kode penyakit berikutnya dan nomor urut ke view
        return view('pages.AdminPages.CRUD.crud_Penyakit.formAdd', compact('nextKode', 'nextNo'));
    }


    /**
     * Menyimpan data penyakit baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_penyakit' => 'required|unique:penyakit,kode_penyakit',
            'nama_penyakit' => 'required',
            'No' => 'required|integer',  // Validasi nomor urut (No)
        ]);

        // Menyimpan data penyakit dengan No yang dihitung di controller
        penyakit::create([
            'No' => $request->No,  // Menyimpan nomor urut yang telah dihitung
            'kode_penyakit' => $request->kode_penyakit,
            'nama_penyakit' => $request->nama_penyakit,
        ]);

        // Mengarahkan kembali ke halaman daftar penyakit dengan pesan sukses
        return redirect()->route('penyakit.create')->with('success', 'Penyakit berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit penyakit berdasarkan ID
     */
    public function edit($kode_penyakit)
    {
        $penyakit = penyakit::where('kode_penyakit', $kode_penyakit)->firstOrFail();

        return view('pages.AdminPages.CRUD.crud_Penyakit.formEdit', [
            'penyakit' => $penyakit,
            'title' => 'Edit Penyakit',
        ]);
    }

    /**
     * Memperbarui data penyakit berdasarkan kode_penyakit.
     */
    public function update(Request $request, $kode_penyakit)
    {
        // Validasi input
        $request->validate([
            'nama_penyakit' => 'required|string|max:255',
        ]);

        // Cari penyakit berdasarkan kode_penyakit
        $penyakit = penyakit::where('kode_penyakit', $kode_penyakit)->firstOrFail();

        // Update data penyakit
        $penyakit->update([
            'nama_penyakit' => $request->input('nama_penyakit'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('penyakit.edit', ['kode_penyakit' => $kode_penyakit])
            ->with('success', 'Penyakit berhasil diperbarui!');
    }


    /**
     * Menghapus penyakit berdasarkan ID
     */
    public function destroy($kode_penyakit)
{
    $penyakit = penyakit::where('kode_penyakit', $kode_penyakit)->first();

    if ($penyakit) {
        $penyakit->delete();
        return redirect()->route('Admin.penyakit')->with('success', 'Penyakit berhasil dihapus.');
    }

    return redirect()->route('Admin.penyakit')->with('error', 'Penyakit tidak ditemukan.');
}


    /**
     * Menghapus beberapa penyakit yang dipilih
     */
    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->input('penyakit_ids');

        if ($selectedIds) {
            penyakit::whereIn('id', $selectedIds)->delete();
            return redirect()->route('Admin.penyakit')->with('success', 'Penyakit berhasil dihapus.');
        }

        return redirect()->route('Admin.penyakit')->with('error', 'Tidak ada penyakit yang dipilih untuk dihapus.');
    }
}
