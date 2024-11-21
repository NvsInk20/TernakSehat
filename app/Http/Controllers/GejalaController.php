<?php

namespace App\Http\Controllers;

use App\Models\gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function dashboard()
{
    // Hitung jumlah penyakit
    $jumlahGejala = gejala::count();

    // Kirimkan ke view
    return view('admin.dashboard', [
        'jumlahGejala' => $jumlahGejala,
    ]);
}
    public function indexAdd()
    {
        return view('pages.AdminPages.CRUD.crud_Gejala.formAdd', [
            'title' => 'Tambah Data',
            'active' => 'Tambah Data',
        ]);
    }

    /**
     * Menampilkan daftar penyakit dengan paginasi dan fitur pencarian
     */
    public function index(Request $request)
    {
        $query = gejala::query();

        // Menambahkan logika pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('kode_gejala', 'like', "%{$search}%")
                ->orWhere('nama_gejala', 'like', "%{$search}%");
        }

        // Tambahkan paginasi ke query
        $gejala = $query->paginate(5);

        // Cek apakah permintaan AJAX
        if ($request->ajax()) {
            return view('partials.gejalaTable', ['gejala' => $gejala]);
        }

        return view('pages.AdminPages.tabelGejala', [
            'title' => 'Gejala',
            'gejala' => $gejala,
            'activePage' => 'pages.AdminPages.tabelGejala',
        ]);
    }

    /**
     * Menampilkan form untuk menambah penyakit
     */
        public function create()
    {
        // Ambil nomor urut terakhir untuk kolom No
        $lastNo = gejala::max('No'); // Ambil ID terbesar sebagai nomor urut terakhir
        $nextNo = $lastNo ? $lastNo + 1 : 1; // Jika ada data, tambahkan 1, jika tidak mulai dari 1
        // Ambil kode penyakit terakhir di database
        $lastGejala = gejala::orderByRaw('CAST(SUBSTRING(kode_gejala, 2) AS UNSIGNED) DESC')->first();

        // Tentukan kode penyakit berikutnya
        if ($lastGejala) {
            // Mengambil angka terakhir setelah huruf P dan menambahkannya
            $lastKode = (int) substr($lastGejala->kode_gejala, 1); // Mengambil angka setelah huruf P
            $nextKode = 'G' .str_pad($lastKode + 1, 2, '0', STR_PAD_LEFT); // Menambah angka terakhir dan membuat kode baru
        } else {
            // Jika belum ada data, mulai dengan P1
            $nextKode = 'G01';
        }


        // Kirimkan kode penyakit berikutnya dan nomor urut ke view
        return view('pages.AdminPages.CRUD.crud_Gejala.formAdd', compact('nextKode', 'nextNo'));
    }


    /**
     * Menyimpan data penyakit baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_gejala' => 'required|unique:gejala,kode_gejala',
            'nama_gejala' => 'required',
            'No' => 'required|integer',  // Validasi nomor urut (No)
        ]);

        // Menyimpan data penyakit dengan No yang dihitung di controller
        gejala::create([
            'No' => $request->No,  // Menyimpan nomor urut yang telah dihitung
            'kode_gejala' => $request->kode_gejala,
            'nama_gejala' => $request->nama_gejala,
        ]);

        // Mengarahkan kembali ke halaman daftar penyakit dengan pesan sukses
        return redirect()->route('gejala.create')->with('success', 'Gejala berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit penyakit berdasarkan ID
     */
    public function edit($kode_gejala)
    {
        $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();

        return view('pages.AdminPages.CRUD.crud_Gejala.formEdit', [
            'gejala' => $gejala,
            'title' => 'Edit Gejala',
        ]);
    }

    /**
     * Memperbarui data penyakit berdasarkan kode_gejala.
     */
    public function update(Request $request, $kode_gejala)
    {
        // Validasi input
        $request->validate([
            'nama_gejala' => 'required|string|max:255',
        ]);

        // Cari penyakit berdasarkan kode_gejala
        $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();

        // Update data penyakit
        $gejala->update([
            'nama_gejala' => $request->input('nama_gejala'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('gejala.edit', ['kode_gejala' => $kode_gejala])
            ->with('success', 'Gejala berhasil diperbarui!');
    }


    /**
     * Menghapus penyakit berdasarkan ID
     */
    public function destroy($kode_gejala)
{
    $gejala = gejala::where('kode_gejala', $kode_gejala)->first();

    if ($gejala) {
        $gejala->delete();
        return redirect()->route('Admin.gejala')->with('success', 'Gejala berhasil dihapus.');
    }

    return redirect()->route('Admin.gejala')->with('error', 'Gejala tidak ditemukan.');
}


    /**
     * Menghapus beberapa penyakit yang dipilih
     */
    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->input('gejala_ids');

        if ($selectedIds) {
            gejala::whereIn('id', $selectedIds)->delete();
            return redirect()->route('Admin.gejala')->with('success', 'Gejala berhasil dihapus.');
        }

        return redirect()->route('Admin.gejala')->with('error', 'Tidak ada gejala yang dipilih untuk dihapus.');
    }
}
