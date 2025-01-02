<?php

namespace App\Http\Controllers;

use App\Models\AturanPenyakit;
use App\Models\penyakit;
use App\Models\gejala;
use App\Models\solusi;
use Illuminate\Http\Request;

class AturanPenyakitController extends Controller
{
    /**
     * Menampilkan daftar aturan penyakit dengan pencarian dan pagination
     */
    public function index(Request $request)
{
    // Ambil penyakit berdasarkan aturanPenyakit dengan eager load relasi gejala dan solusi
    $query = penyakit::whereHas('aturanPenyakit', function ($query) {
        // Memastikan hanya aturanPenyakit yang terkait dengan penyakit yang dipilih
    })
    ->with([
        'aturanPenyakit.gejala',
        'aturanPenyakit.solusi'
    ]);

    // Pencarian berdasarkan nama penyakit atau gejala
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->whereHas('aturanPenyakit', function ($query) use ($search) {
            $query->where('nama_penyakit', 'like', "%{$search}%")
                  ->orWhereHas('gejala', function ($query) use ($search) {
                      $query->where('nama_gejala', 'like', "%{$search}%");
                  });
        });
    }

    // Ambil data penyakit unik dari aturanPenyakit
    $penyakitPaginated = $query->distinct('nama_penyakit')
                               ->orderBy('nama_penyakit') // Urutkan berdasarkan nama penyakit
                               ->paginate(3);

    return view('pages.AdminPages.tabelAturan', [
        'title' => 'Aturan Penyakit',
        'penyakitPaginated' => $penyakitPaginated,
        'activePage' => 'pages.AdminPages.tabelAturan',
    ]);
}

// Pakar Pages
    public function indexByPakar(Request $request)
{
    // Ambil penyakit berdasarkan aturanPenyakit dengan eager load relasi gejala dan solusi
    $query = Penyakit::whereHas('aturanPenyakit', function ($query) {
        // Memastikan hanya aturanPenyakit yang terkait dengan penyakit yang dipilih
    })
    ->with([
        'aturanPenyakit.gejala',
        'aturanPenyakit.solusi'
    ]);

    // Pencarian berdasarkan nama penyakit atau gejala
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->whereHas('aturanPenyakit', function ($query) use ($search) {
            $query->where('nama_penyakit', 'like', "%{$search}%")
                  ->orWhereHas('gejala', function ($query) use ($search) {
                      $query->where('nama_gejala', 'like', "%{$search}%");
                  });
        });
    }

    // Ambil data penyakit unik dari aturanPenyakit
    $penyakitPaginated = $query->distinct('nama_penyakit')
                               ->orderBy('nama_penyakit') // Urutkan berdasarkan nama penyakit
                               ->paginate(3);

    return view('pages.PakarPages.tabelAturan', [
        'title' => 'Aturan Penyakit',
        'penyakitPaginated' => $penyakitPaginated,
        'activePage' => 'pages.PakarPages.tabelAturan',
    ]);

}

    public function indexUser(Request $request)
{
    // Ambil penyakit berdasarkan aturanPenyakit dengan eager load relasi gejala dan solusi
    $query = Penyakit::whereHas('aturanPenyakit', function ($query) {
        // Memastikan hanya aturanPenyakit yang terkait dengan penyakit yang dipilih
    })
    ->with([
        'aturanPenyakit.gejala',
        'aturanPenyakit.solusi'
    ]);

    // Pencarian berdasarkan nama penyakit atau gejala
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->whereHas('aturanPenyakit', function ($query) use ($search) {
            $query->where('nama_penyakit', 'like', "%{$search}%")
                  ->orWhereHas('gejala', function ($query) use ($search) {
                      $query->where('nama_gejala', 'like', "%{$search}%");
                  });
        });
    }

    // Ambil data penyakit unik dari aturanPenyakit
    $penyakitPaginated = $query->distinct('nama_penyakit')
                               ->orderBy('nama_penyakit') // Urutkan berdasarkan nama penyakit
                               ->paginate(3);

    return view('pages.UserPages.tabelAturan', [
        'title' => 'Aturan Penyakit',
        'penyakitPaginated' => $penyakitPaginated,
        'activePage' => 'pages.UserPages.tabelAturan',
    ]);
}

    
    /**
     * Menampilkan form untuk menambahkan aturan penyakit
     */
    public function create()
{
    // Ambil kode_relasi terakhir dari database, jika tidak ada default ke 'R00'
    $kode_relasi_terakhir = AturanPenyakit::orderBy('kode_relasi', 'desc')->first()->kode_relasi ?? 'R00';
    
    // Ekstrak angka dari kode_relasi terakhir dan tambahkan 1
    $angka_terakhir = (int)substr($kode_relasi_terakhir, 1);
    $angka_baru = $angka_terakhir + 1;

    // Generate kode_relasi baru dengan format 'R' + angka baru (2 digit)
    $kode_relasi = 'R' . str_pad($angka_baru, 2, '0', STR_PAD_LEFT);

    // Ambil data penyakit, gejala, dan solusi untuk form
    $penyakit = penyakit::all();
    $gejala = gejala::all();
    $solusi = solusi::all();

    // Kirim data ke view
    return view('pages.AdminPages.CRUD.crud_aturan.formAdd', [
        'penyakit' => $penyakit,
        'gejala' => $gejala,
        'solusi' => $solusi,
        'kode_relasi' => $kode_relasi
    ]);
}


    /**
     * Menyimpan aturan penyakit baru
     */
    public function store(Request $request)
{
    $request->validate([
        'kode_relasi' => 'required|string|max:10',
        'kode_penyakit' => 'required|string|max:10',
        'kode_gejala' => 'required|array',
        'kode_gejala.*' => 'required|string|max:10',
        'jenis_gejala' => 'required|array',
        'jenis_gejala.*' => 'required|in:wajib,opsional',
        'kode_solusi' => 'required|string|max:10',
    ]);
    // Cek apakah penyakit sudah ada di aturan
    $existingAturan = AturanPenyakit::where('kode_penyakit', $request->kode_penyakit)->exists();
    if ($existingAturan) {
        return redirect()->route('aturanPenyakit.create')
            ->with('error', 'Penyakit yang ditambahkan sudah ada dalam aturan!');
    }

    // Simpan setiap kombinasi gejala dan jenis gejala
    foreach ($request->kode_gejala as $index => $kodeGejala) {
        AturanPenyakit::create([
            'kode_relasi' => $request->kode_relasi,
            'kode_penyakit' => $request->kode_penyakit,
            'kode_gejala' => $kodeGejala,
            'jenis_gejala' => $request->jenis_gejala[$index],
            'kode_solusi' => $request->kode_solusi,
        ]);
    }

    return redirect()->route('aturanPenyakit.create')->with('success', 'Aturan Penyakit berhasil ditambahkan!');
}



    /**
     * Menampilkan form untuk mengedit aturan penyakit
     */
    public function edit($kode_relasi)
    {
        $aturanPenyakit = AturanPenyakit::where('kode_relasi', $kode_relasi)->get();
        if ($aturanPenyakit->isEmpty()) {
            abort(404, 'Aturan Penyakit tidak ditemukan.');
        }

        return view('pages.AdminPages.CRUD.crud_aturan.formEdit', [
            'aturanPenyakit' => $aturanPenyakit,
            'penyakit' => Penyakit::all(),
            'gejala' => Gejala::all(),
            'solusi' => Solusi::all(),
            'kode_relasi' => $kode_relasi,
        ]);
    }

    /**
     * Memperbarui aturan penyakit
     */
    public function update(Request $request, $kode_relasi)
    {
        $request->validate([
            'kode_penyakit' => 'required|exists:penyakit,kode_penyakit',
            'kode_gejala' => 'required|array',
            'kode_gejala.*' => 'required|exists:gejala,kode_gejala',
            'jenis_gejala' => 'required|array',
            'jenis_gejala.*' => 'required|in:wajib,opsional',
            'kode_solusi' => 'required|exists:solusi,kode_solusi',
        ]);

        AturanPenyakit::where('kode_relasi', $kode_relasi)->delete();

        foreach ($request->kode_gejala as $index => $kodeGejala) {
            AturanPenyakit::create([
                'kode_relasi' => $kode_relasi,
                'kode_penyakit' => $request->kode_penyakit,
                'kode_gejala' => $kodeGejala,
                'jenis_gejala' => $request->jenis_gejala[$index],
                'kode_solusi' => $request->kode_solusi,
            ]);
        }

        return redirect()->route('aturanPenyakit.edit', ['kode_relasi' => $kode_relasi])
    ->with('success', 'Aturan Penyakit berhasil diperbarui!');

    }

    /**
     * Menghapus aturan penyakit
     */
    public function destroy($kode_relasi)
    {
        AturanPenyakit::where('kode_relasi', $kode_relasi)->delete();

        return redirect()->route('Admin.aturanPenyakit')
            ->with('success', 'Aturan Penyakit berhasil dihapus!');
    }


    // Pakar Pages
    /**
     * Menampilkan form untuk menambahkan aturan penyakit
     */
    public function createByPakar()
{
    // Ambil kode_relasi terakhir dari database, jika tidak ada default ke 'R00'
    $kode_relasi_terakhir = AturanPenyakit::orderBy('kode_relasi', 'desc')->first()->kode_relasi ?? 'R00';
    
    // Ekstrak angka dari kode_relasi terakhir dan tambahkan 1
    $angka_terakhir = (int)substr($kode_relasi_terakhir, 1);
    $angka_baru = $angka_terakhir + 1;

    // Generate kode_relasi baru dengan format 'R' + angka baru (2 digit)
    $kode_relasi = 'R' . str_pad($angka_baru, 2, '0', STR_PAD_LEFT);

    // Ambil data penyakit, gejala, dan solusi untuk form
    $penyakit = penyakit::all();
    $gejala = gejala::all();
    $solusi = solusi::all();

    // Kirim data ke view
    return view('pages.PakarPages.CRUD.crud_aturan.formAdd', [
        'penyakit' => $penyakit,
        'gejala' => $gejala,
        'solusi' => $solusi,
        'kode_relasi' => $kode_relasi
    ]);
}
    /**
     * Menyimpan aturan penyakit baru
     */
    public function storeByPakar(Request $request)
{
    $request->validate([
        'kode_relasi' => 'required|string|max:10',
        'kode_penyakit' => 'required|string|max:10',
        'kode_gejala' => 'required|array',
        'kode_gejala.*' => 'required|string|max:10',
        'jenis_gejala' => 'required|array',
        'jenis_gejala.*' => 'required|in:wajib,opsional',
        'kode_solusi' => 'required|string|max:10',
    ]);
    // Cek apakah penyakit sudah ada di aturan
    $existingAturan = AturanPenyakit::where('kode_penyakit', $request->kode_penyakit)->exists();
    if ($existingAturan) {
        return redirect()->route('aturanPenyakitPakar.create')
            ->with('error', 'Penyakit yang ditambahkan sudah ada dalam aturan!');
    }

    // Simpan setiap kombinasi gejala dan jenis gejala
    foreach ($request->kode_gejala as $index => $kodeGejala) {
        AturanPenyakit::create([
            'kode_relasi' => $request->kode_relasi,
            'kode_penyakit' => $request->kode_penyakit,
            'kode_gejala' => $kodeGejala,
            'jenis_gejala' => $request->jenis_gejala[$index],
            'kode_solusi' => $request->kode_solusi,
        ]);
    }

    return redirect()->route('aturanPenyakitPakar.create')->with('success', 'Aturan Penyakit berhasil ditambahkan!');
}

    /**
     * Menampilkan form untuk mengedit aturan penyakit
     */
    public function editByPakar($kode_relasi)
    {
        $aturanPenyakit = AturanPenyakit::where('kode_relasi', $kode_relasi)->get();
        if ($aturanPenyakit->isEmpty()) {
            abort(404, 'Aturan Penyakit tidak ditemukan.');
        }

        return view('pages.PakarPages.CRUD.crud_aturan.formEdit', [
            'aturanPenyakit' => $aturanPenyakit,
            'penyakit' => Penyakit::all(),
            'gejala' => Gejala::all(),
            'solusi' => Solusi::all(),
            'kode_relasi' => $kode_relasi,
        ]);
    }

    /**
     * Memperbarui aturan penyakit
     */
    public function updateByPakar(Request $request, $kode_relasi)
    {
        $request->validate([
            'kode_penyakit' => 'required|exists:penyakit,kode_penyakit',
            'kode_gejala' => 'required|array',
            'kode_gejala.*' => 'required|exists:gejala,kode_gejala',
            'jenis_gejala' => 'required|array',
            'jenis_gejala.*' => 'required|in:wajib,opsional',
            'kode_solusi' => 'required|exists:solusi,kode_solusi',
        ]);

        AturanPenyakit::where('kode_relasi', $kode_relasi)->delete();

        foreach ($request->kode_gejala as $index => $kodeGejala) {
            AturanPenyakit::create([
                'kode_relasi' => $kode_relasi,
                'kode_penyakit' => $request->kode_penyakit,
                'kode_gejala' => $kodeGejala,
                'jenis_gejala' => $request->jenis_gejala[$index],
                'kode_solusi' => $request->kode_solusi,
            ]);
        }

        return redirect()->route('aturanPenyakitPakar.edit', ['kode_relasi' => $kode_relasi])
    ->with('success', 'Aturan Penyakit berhasil diperbarui!');

    }

    /**
     * Menghapus aturan penyakit
     */
    public function destroyByPakar($kode_relasi)
    {
        AturanPenyakit::where('kode_relasi', $kode_relasi)->delete();

        return redirect()->route('Pakar.aturanPenyakit')
            ->with('success', 'Aturan Penyakit berhasil dihapus!');
    }

}
