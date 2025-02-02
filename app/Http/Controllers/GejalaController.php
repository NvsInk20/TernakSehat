<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\gejala;
use App\Models\PanduanGejala;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        'No' => 'required|integer',  // Pastikan kolom ini ada di database
        'deskripsi' => 'nullable|string|max:155',
    ]);

    // Simpan data Gejala
    $gejala = gejala::create([
        'kode_gejala' => $validated['kode_gejala'],
        'nama_gejala' => $validated['nama_gejala'],
        'deskripsi' => $validated['deskripsi'] ?? null,  // Pastikan deskripsi tersimpan
        'No' => $validated['No'], // Simpan nomor urut
    ]);

    // Simpan PanduanGejala jika ada data
    if (isset($validated['deskripsi_panduan']) || $request->hasFile('foto_dokumen')) {
    $fotoFiles = $request->file('foto_dokumen');
    $deskripsiPanduan = $request->input('deskripsi_panduan', []);

    // Pastikan deskripsi_panduan berbentuk array
    if (!is_array($deskripsiPanduan)) {
        $deskripsiPanduan = [$deskripsiPanduan];
    }

    // Looping sesuai jumlah data yang diinput
    $totalData = max(count($deskripsiPanduan), is_array($fotoFiles) ? count($fotoFiles) : 0);
    
    for ($i = 0; $i < $totalData; $i++) {
        $fotoPath = null;

        // Cek apakah ada file yang diupload pada indeks ini
        if (is_array($fotoFiles) && isset($fotoFiles[$i])) {
            $fotoPath = $fotoFiles[$i]->store('panduan_gejala', 'public');
        }

        // Simpan ke dalam tabel PanduanGejala
        PanduanGejala::create([
            'kode_gejala' => $gejala->kode_gejala,
            'foto_dokumen' => $fotoPath ?? null,
            'deskripsi_panduan' => $deskripsiPanduan[$i] ?? null,
        ]);
    }
    }


    // Redirect kembali ke halaman input dengan pesan sukses
    return redirect()->route('gejala.create')->with('success', 'Gejala berhasil ditambahkan!');
}

    /**
     * Menampilkan form untuk mengedit penyakit berdasarkan ID
     */
    public function edit($kode_gejala)
{
    // Ambil data gejala berdasarkan kode_gejala
    $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();

    // Ambil semua PanduanGejala yang terkait dengan kode_gejala
    $panduan = PanduanGejala::where('kode_gejala', $gejala->kode_gejala)->get();

    // Siapkan array untuk menyimpan foto dan deskripsi
    $fotoDokumen = [];
    $deskripsiPanduan = [];

    // Looping semua data PanduanGejala yang ditemukan
    foreach ($panduan as $item) {
        $fotoDokumen[] = $item->foto_dokumen; // Menyimpan setiap foto_dokumen
        $deskripsiPanduan[] = $item->deskripsi_panduan; // Menyimpan setiap deskripsi_panduan
    }

    // Kirim data ke view
    return view('pages.AdminPages.CRUD.crud_Gejala.formEdit', [
        'gejala' => $gejala,
        'fotoDokumen' => $fotoDokumen,
        'deskripsiPanduan' => $deskripsiPanduan,
        'title' => 'Edit Gejala',
    ]);
}

// Tangani semua error agar tidak menampilkan halaman HTML
public function hapusGambar(Request $request)
{
    try {
        $validated = $request->validate([
            'foto' => 'required|string',
            'kode_gejala' => 'required|string'
        ]);

        $panduanGejala = PanduanGejala::where('kode_gejala', $validated['kode_gejala'])
                                      ->where('foto_dokumen', $validated['foto'])
                                      ->first();

        if (!$panduanGejala) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Gunakan path relatif dari storage Laravel
        $filePath = 'panduan_gejala/' . basename($panduanGejala->foto_dokumen);

        Log::info('Mencoba menghapus file: ' . storage_path('app/public/' . $filePath));

        // Periksa apakah file ada di storage
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            Log::info('File berhasil dihapus: ' . $filePath);
        } else {
            Log::warning('File tidak ditemukan: ' . $filePath);
        }

        // Hapus dari database
        $panduanGejala->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data dan gambar berhasil dihapus'
        ]);
    } catch (\Throwable $e) {
        Log::error('Terjadi kesalahan saat menghapus gambar: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

public function update(Request $request, $kode_gejala)
{
    // Validasi input
    $request->validate([
        'nama_gejala' => 'required|string|max:255',
        'deskripsi' => 'nullable|string|max:155',
        'foto_dokumen.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'deskripsi_panduan.*' => 'nullable|string',
    ]);

    // Ambil data gejala berdasarkan kode_gejala
    $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();

    // Update data gejala tanpa menghapus yang tidak berubah
    $gejala->update([
        'nama_gejala' => $request->input('nama_gejala'),
        'deskripsi' => $request->input('deskripsi'),
    ]);

    // Ambil semua data panduan gejala lama
    $existingGuides = PanduanGejala::where('kode_gejala', $gejala->kode_gejala)->get();

    foreach ($existingGuides as $index => $panduan) {
        // Periksa apakah ada perubahan deskripsi
        if (isset($request->deskripsi_panduan[$index])) {
            $panduan->deskripsi_panduan = $request->deskripsi_panduan[$index];
        }

        // Cek apakah ada gambar baru diunggah untuk panduan ini
        if ($request->hasFile("foto_dokumen.$index")) {
            $file = $request->file("foto_dokumen.$index");

            // Hapus gambar lama jika ada gambar baru diunggah
            if ($panduan->foto_dokumen) {
                $oldPhotoPath = public_path('storage/' . $panduan->foto_dokumen);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            // Simpan gambar baru
            $newFilePath = $file->store('panduan_gejala', 'public');
            $panduan->foto_dokumen = $newFilePath;
        }

        // Simpan perubahan pada data panduan
        $panduan->save();
    }

    // **Tambahkan data baru jika pengguna menambahkan panduan baru**
    if ($request->has('deskripsi_panduan')) {
        foreach ($request->deskripsi_panduan as $index => $deskripsi) {
            if (!isset($existingGuides[$index])) { // Jika index belum ada, berarti data baru
                $newFotoPath = null;

                // Jika ada gambar baru diunggah
                if ($request->hasFile("foto_dokumen.$index")) {
                    $file = $request->file("foto_dokumen.$index");
                    $newFotoPath = $file->store('panduan_gejala', 'public');
                }

                // Simpan data baru ke database
                PanduanGejala::create([
                    'kode_gejala' => $gejala->kode_gejala,
                    'foto_dokumen' => $newFotoPath,
                    'deskripsi_panduan' => $deskripsi,
                ]);
            }
        }
    }

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
            if ($gejala->foto_dokumen) {
                Storage::disk('public')->delete($gejala->foto_dokumen);
            }
            $gejala->delete();
            return redirect()->route('Admin.gejala')->with('success', 'Gejala berhasil dihapus.');
        }

        return redirect()->route('Admin.gejala')->with('error', 'Gejala tidak ditemukan.');
}

//Ahli Pakar
    public function indexByPakar(Request $request)
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

        return view('pages.PakarPages.tabelGejala', [
            'title' => 'Gejala',
            'gejala' => $gejala,
            'activePage' => 'pages.PakarPages.tabelGejala',
        ]);
    }

    /**
     * Menampilkan form untuk menambah penyakit
     */
        public function createByPakar()
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
        return view('pages.PakarPages.CRUD.crud_Gejala.formAdd', compact('nextKode', 'nextNo'));
    }


    /**
     * Menyimpan data penyakit baru ke database
     */
    public function storeByPakar(Request $request)
    {
     // Validasi input
    $validated = $request->validate([
        'kode_gejala' => 'required|unique:gejala,kode_gejala',
        'nama_gejala' => 'required',
        'No' => 'required|integer',  // Pastikan kolom ini ada di database
        'deskripsi' => 'nullable|string|max:155',
    ]);

    // Simpan data Gejala
    $gejala = gejala::create([
        'kode_gejala' => $validated['kode_gejala'],
        'nama_gejala' => $validated['nama_gejala'],
        'deskripsi' => $validated['deskripsi'] ?? null,  // Pastikan deskripsi tersimpan
        'No' => $validated['No'], // Simpan nomor urut
    ]);

    // Simpan PanduanGejala jika ada data
    if (isset($validated['deskripsi_panduan']) || $request->hasFile('foto_dokumen')) {
    $fotoFiles = $request->file('foto_dokumen');
    $deskripsiPanduan = $request->input('deskripsi_panduan', []);

    // Pastikan deskripsi_panduan berbentuk array
    if (!is_array($deskripsiPanduan)) {
        $deskripsiPanduan = [$deskripsiPanduan];
    }

    // Looping sesuai jumlah data yang diinput
    $totalData = max(count($deskripsiPanduan), is_array($fotoFiles) ? count($fotoFiles) : 0);
    
    for ($i = 0; $i < $totalData; $i++) {
        $fotoPath = null;

        // Cek apakah ada file yang diupload pada indeks ini
        if (is_array($fotoFiles) && isset($fotoFiles[$i])) {
            $fotoPath = $fotoFiles[$i]->store('panduan_gejala', 'public');
        }

        // Simpan ke dalam tabel PanduanGejala
        PanduanGejala::create([
            'kode_gejala' => $gejala->kode_gejala,
            'foto_dokumen' => $fotoPath ?? null,
            'deskripsi_panduan' => $deskripsiPanduan[$i] ?? null,
        ]);
    }
    }

    // Mengarahkan kembali ke halaman daftar penyakit dengan pesan sukses
    return redirect()->route('gejalaPakar.create')->with('success', 'Gejala berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit penyakit berdasarkan ID
     */
    public function editByPakar($kode_gejala)
    {
       // Ambil data gejala berdasarkan kode_gejala
    $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();

    // Ambil semua PanduanGejala yang terkait dengan kode_gejala
    $panduan = PanduanGejala::where('kode_gejala', $gejala->kode_gejala)->get();

    // Siapkan array untuk menyimpan foto dan deskripsi
    $fotoDokumen = [];
    $deskripsiPanduan = [];

    // Looping semua data PanduanGejala yang ditemukan
    foreach ($panduan as $item) {
        $fotoDokumen[] = $item->foto_dokumen; // Menyimpan setiap foto_dokumen
        $deskripsiPanduan[] = $item->deskripsi_panduan; // Menyimpan setiap deskripsi_panduan
    }

    // Kirim data ke view
    return view('pages.PakarPages.CRUD.crud_Gejala.formEdit', [
        'gejala' => $gejala,
        'fotoDokumen' => $fotoDokumen,
        'deskripsiPanduan' => $deskripsiPanduan,
        'title' => 'Edit Gejala',
    ]);
    }

    /**
     * Memperbarui data penyakit berdasarkan kode_gejala.
     */
    public function updateByPakar(Request $request, $kode_gejala)
    {
       // Validasi input
    $request->validate([
        'nama_gejala' => 'required|string|max:255',
        'deskripsi' => 'nullable|string|max:155',
        'foto_dokumen.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'deskripsi_panduan.*' => 'nullable|string',
    ]);

    // Ambil data gejala berdasarkan kode_gejala
    $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();

    // Update data gejala tanpa menghapus yang tidak berubah
    $gejala->update([
        'nama_gejala' => $request->input('nama_gejala'),
        'deskripsi' => $request->input('deskripsi'),
    ]);

    // Ambil semua data panduan gejala lama
    $existingGuides = PanduanGejala::where('kode_gejala', $gejala->kode_gejala)->get();

    foreach ($existingGuides as $index => $panduan) {
        // Periksa apakah ada perubahan deskripsi
        if (isset($request->deskripsi_panduan[$index])) {
            $panduan->deskripsi_panduan = $request->deskripsi_panduan[$index];
        }

        // Cek apakah ada gambar baru diunggah untuk panduan ini
        if ($request->hasFile("foto_dokumen.$index")) {
            $file = $request->file("foto_dokumen.$index");

            // Hapus gambar lama jika ada gambar baru diunggah
            if ($panduan->foto_dokumen) {
                $oldPhotoPath = public_path('storage/' . $panduan->foto_dokumen);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            // Simpan gambar baru
            $newFilePath = $file->store('panduan_gejala', 'public');
            $panduan->foto_dokumen = $newFilePath;
        }

        // Simpan perubahan pada data panduan
        $panduan->save();
    }

    // **Tambahkan data baru jika pengguna menambahkan panduan baru**
    if ($request->has('deskripsi_panduan')) {
        foreach ($request->deskripsi_panduan as $index => $deskripsi) {
            if (!isset($existingGuides[$index])) { // Jika index belum ada, berarti data baru
                $newFotoPath = null;

                // Jika ada gambar baru diunggah
                if ($request->hasFile("foto_dokumen.$index")) {
                    $file = $request->file("foto_dokumen.$index");
                    $newFotoPath = $file->store('panduan_gejala', 'public');
                }

                // Simpan data baru ke database
                PanduanGejala::create([
                    'kode_gejala' => $gejala->kode_gejala,
                    'foto_dokumen' => $newFotoPath,
                    'deskripsi_panduan' => $deskripsi,
                ]);
            }
        }
    }

    // Redirect dengan pesan sukses
    return redirect()->route('gejalaPakar.edit', ['kode_gejala' => $kode_gejala])
        ->with('success', 'Gejala berhasil diperbarui!');
    }


    /**
     * Menghapus penyakit berdasarkan ID
     */
    public function destroyByPakar($kode_gejala)
{
    $gejala = gejala::where('kode_gejala', $kode_gejala)->first();

    if ($gejala) {
        $gejala->delete();
        return redirect()->route('Pakar.gejala')->with('success', 'Gejala berhasil dihapus.');
    }

    return redirect()->route('Pakar.gejala')->with('error', 'Gejala tidak ditemukan.');
}


    public function cetakPdf()
{
    // Ambil semua data gejala
    $gejala = gejala::all();

    // Ambil data panduan gejala terkait untuk setiap gejala
    foreach ($gejala as $item) {
        // Mengambil data foto_dokumen dan deskripsi_panduan terkait dengan gejala
        $item->panduanGejala = PanduanGejala::where('kode_gejala', $item->kode_gejala)->get();
    }

    // Buat PDF dengan data gejala dan panduan gejala
    $pdf = PDF::loadView('pdf.gejala', compact('gejala'))
        ->setPaper('a4', 'portrait'); // Set kertas A4 dengan orientasi portrait

    // Kembalikan PDF sebagai stream untuk didownload atau ditampilkan
    return $pdf->stream('Panduan_Gejala.pdf');
}


    // /**
    //  * Menghapus beberapa penyakit yang dipilih
    //  */
    // public function deleteSelected(Request $request)
    // {
    //     $selectedIds = $request->input('gejala_ids');

    //     if ($selectedIds) {
    //         gejala::whereIn('id', $selectedIds)->delete();
    //         return redirect()->route('Admin.gejala')->with('success', 'Gejala berhasil dihapus.');
    //     }

    //     return redirect()->route('Admin.gejala')->with('error', 'Tidak ada gejala yang dipilih untuk dihapus.');
    // }
}
