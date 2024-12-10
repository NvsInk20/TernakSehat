<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\solusi; // Pastikan model penyakit ditulis dengan huruf besar

class SolusiController extends Controller
{
    /**
     * Menampilkan halaman form untuk tambah data penyakit
     */
    public function dashboard()
{
    // Hitung jumlah penyakit
    $jumlahSolusi = solusi::count();

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
        $query = solusi::query();

        // Menambahkan logika pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('kode_solusi', 'like', "%{$search}%")
                ->orWhere('solusi', 'like', "%{$search}%");
        }

        // Tambahkan paginasi ke query
        $solusi = $query->paginate(5);

        // Cek apakah permintaan AJAX
        if ($request->ajax()) {
            return view('partials.solusiTable', ['solusi' => $solusi]);
        }

        return view('pages.AdminPages.tabelsolusi', [
            'title' => 'Solusi',
            'solusi' => $solusi,
            'activePage' => 'pages.AdminPages.tabelSolusi',
        ]);
    }

    /**
     * Menampilkan form untuk menambah penyakit
     */
        public function create()
    {
        // Ambil nomor urut terakhir untuk kolom No
        $lastNo = solusi::max('No'); // Ambil ID terbesar sebagai nomor urut terakhir
        $nextNo = $lastNo ? $lastNo + 1 : 1; // Jika ada data, tambahkan 1, jika tidak mulai dari 1
        // Ambil kode penyakit terakhir di database
        $lastSolusi = solusi::orderByRaw('CAST(SUBSTRING(kode_solusi, 2) AS UNSIGNED) DESC')->first();

        // Tentukan kode penyakit berikutnya
        if ($lastSolusi) {
            // Mengambil angka terakhir setelah huruf P dan menambahkannya
            $lastKode = (int) substr($lastSolusi->kode_solusi, 1); // Mengambil angka setelah huruf P
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
            'kode_solusi' => 'required|unique:solusi,kode_solusi',
            'solusi' => 'required|max:10000',
            'No' => 'required|integer',  // Validasi nomor urut (No)
        ]);

        // Menyimpan data penyakit dengan No yang dihitung di controller
        solusi::create([
            'No' => $request->No,  // Menyimpan nomor urut yang telah dihitung
            'kode_solusi' => $request->kode_solusi,
            'solusi' => $request->solusi,
        ]);

        // Mengarahkan kembali ke halaman daftar penyakit dengan pesan sukses
        return redirect()->route('solusi.create')->with('success', 'Solusi berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit penyakit berdasarkan ID
     */
    public function edit($kode_solusi)
    {
        $solusi = solusi::where('kode_solusi', $kode_solusi)->firstOrFail();

        return view('pages.AdminPages.CRUD.crud_Solusi.formEdit', [
            'solusi' => $solusi,
            'title' => 'Edit Solusi',
        ]);
    }

    /**
     * Memperbarui data penyakit berdasarkan kode_solusi.
     */
    public function update(Request $request, $kode_solusi)
    {
        // Validasi input
        $request->validate([
            'solusi' => 'required|string|max:10000',
        ]);

        // Cari penyakit berdasarkan kode_solusi
        $solusi = solusi::where('kode_solusi', $kode_solusi)->firstOrFail();

        // Update data penyakit
        $solusi->update([
            'solusi' => $request->input('solusi'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('solusi.edit', ['kode_solusi' => $kode_solusi])
            ->with('success', 'Solusi berhasil diperbarui!');
    }


    /**
     * Menghapus penyakit berdasarkan ID
     */
    public function destroy($kode_solusi)
{
    $solusi = solusi::where('kode_solusi', $kode_solusi)->first();

    if ($solusi) {
        $solusi->delete();
        return redirect()->route('Admin.solusi')->with('success', 'Solusi berhasil dihapus.');
    }

    return redirect()->route('Admin.solusi')->with('error', 'Solusi tidak ditemukan.');
}


    /**
     * Menghapus beberapa penyakit yang dipilih
     */
    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->input('solusi_ids');

        if ($selectedIds) {
            solusi::whereIn('id', $selectedIds)->delete();
            return redirect()->route('Admin.solusi')->with('success', 'Solusi berhasil dihapus.');
        }

        return redirect()->route('Admin.solusi')->with('error', 'Tidak ada solusi yang dipilih untuk dihapus.');
    }
}
