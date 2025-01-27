<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\gejala;
use Illuminate\Support\Facades\Storage;
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
        'deskripsi' => 'nullable|string',
        'foto_dokumen.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk multiple file gambar
        'deskripsi_panduan.*' => 'nullable|string', // Validasi deskripsi panduan untuk tiap gambar
    ]);

    // Array untuk menyimpan path foto dan deskripsi panduan
    $fotoDokumen = [];
    $deskripsiPanduan = [];

    // Proses setiap file foto dan deskripsi panduan
    if ($request->hasFile('foto_dokumen')) {
        foreach ($request->file('foto_dokumen') as $index => $file) {
            // Menyimpan foto_dokumen
            $fotoPath = $file->store('foto_gejala', 'public');
            $fotoDokumen[] = $fotoPath;

            // Menyimpan deskripsi panduan untuk tiap gambar
            $deskripsiPanduan[] = $request->deskripsi_panduan[$index] ?? '';
        }
    }

    // Menyimpan data gejala termasuk foto_dokumen
    gejala::create([
        'No' => $request->No,  // Menyimpan nomor urut yang telah dihitung
        'kode_gejala' => $request->kode_gejala,
        'nama_gejala' => $request->nama_gejala,
        'deskripsi' => $request->deskripsi,
        'foto_dokumen' => implode(',', $fotoDokumen), // Menyimpan path gambar sebagai string yang dipisahkan koma
        'deskripsi_panduan' => implode('|', $deskripsiPanduan), // Menyimpan deskripsi panduan sebagai string
    ]);

    // Mengarahkan kembali ke halaman daftar penyakit dengan pesan sukses
    return redirect()->route('gejala.create')->with('success', 'Gejala berhasil ditambahkan!');
}



    /**
     * Menampilkan form untuk mengedit penyakit berdasarkan ID
     */
    public function edit($kode_gejala)
{
    // Ambil data gejala berdasarkan kode_gejala
    $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();

    // Pecah data foto_dokumen menjadi array
    $fotoDokumen = $gejala->foto_dokumen ? explode(',', $gejala->foto_dokumen) : [];
    
    // Pecah data deskripsi_panduan menjadi array
    $deskripsiPanduan = $gejala->deskripsi_panduan ? explode('|', $gejala->deskripsi_panduan) : [];

    // Kirim data ke view
    return view('pages.AdminPages.CRUD.crud_Gejala.formEdit', [
        'gejala' => $gejala,
        'fotoDokumen' => $fotoDokumen,
        'deskripsiPanduan' => $deskripsiPanduan,
        'title' => 'Edit Gejala',
    ]);
}
public function hapusGambar(Request $request)
{
    $request->validate([
        'foto' => 'required|string',
    ]);

    $foto = $request->input('foto');
    $path = storage_path('app/public/' . $foto);

    try {
        // Hapus file gambar dari penyimpanan
        if (file_exists($path)) {
            unlink($path); // Menghapus file dari storage
        } else {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan']);
        }

        // Hapus data gambar dari kolom foto_dokumen di database
        $gejala = Gejala::where('foto_dokumen', 'like', '%' . $foto . '%')->first();
        if ($gejala) {
            // Pecah string menjadi array
            $fileList = explode(',', $gejala->foto_dokumen);

            // Hapus file yang sesuai dari array
            $fileList = array_filter($fileList, function ($file) use ($foto) {
                return trim($file) !== $foto;
            });

            // Gabungkan kembali array menjadi string
            $gejala->foto_dokumen = implode(',', $fileList);

            // Hapus deskripsi jika tidak ada file yang tersisa
            if (empty($fileList)) {
                $gejala->deskripsi_panduan = null;
            }

            // Simpan perubahan di database
            $gejala->save();
        }

        return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Gagal menghapus gambar.', 'error' => $e->getMessage()]);
    }
}
    /**
     * Memperbarui data penyakit berdasarkan kode_gejala.
     */
    public function update(Request $request, $kode_gejala)
{
    // Validasi input
    $request->validate([
        'nama_gejala' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'foto_dokumen.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk multiple file gambar
        'deskripsi_panduan.*' => 'nullable|string', // Validasi deskripsi panduan untuk tiap gambar
        'hapus_gambar.*' => 'nullable|integer', // Validasi untuk gambar yang ingin dihapus
    ]);

    // Cari gejala berdasarkan kode_gejala
    $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();
    // Hapus gambar yang tidak ada di input terbaru
    $existingPhotos = explode(',', $gejala->foto_dokumen);
    $newPhotos = $request->input('foto_dokumen', []);

    $photosToDelete = array_diff($existingPhotos, $newPhotos);

    foreach ($photosToDelete as $photo) {
        if (Storage::exists('public/' . $photo)) {
            Storage::delete('public/' . $photo);
        }
    }

    // Ambil data foto_dokumen dan deskripsi_panduan yang ada
    $fotoDokumen = $gejala->foto_dokumen ? explode(',', $gejala->foto_dokumen) : [];
    $deskripsiPanduan = $gejala->deskripsi_panduan ? explode('|', $gejala->deskripsi_panduan) : [];

    // Hapus gambar yang dipilih untuk dihapus
    if ($request->has('hapus_gambar')) {
        foreach ($request->hapus_gambar as $index) {
            // Hapus file dari storage
            if (isset($fotoDokumen[$index])) {
                \Storage::disk('public')->delete($fotoDokumen[$index]);
                unset($fotoDokumen[$index]);
                unset($deskripsiPanduan[$index]);
            }
        }

        // Reset array untuk menghapus celah
        $fotoDokumen = array_values($fotoDokumen);
        $deskripsiPanduan = array_values($deskripsiPanduan);
    }

    // Proses pengunggahan gambar baru
    if ($request->hasFile('foto_dokumen')) {
        foreach ($request->file('foto_dokumen') as $index => $file) {
            // Simpan gambar baru
            $fotoPath = $file->store('foto_gejala', 'public');
            $fotoDokumen[] = $fotoPath;

            // Simpan deskripsi panduan baru
            $deskripsiPanduan[] = $request->deskripsi_panduan[$index] ?? '';
        }
    }

    // Update data gejala
    $gejala->update([
        'nama_gejala' => $request->input('nama_gejala'),
        'deskripsi' => $request->input('deskripsi'),
        'foto_dokumen' => implode(',', $fotoDokumen), // Gabungkan kembali menjadi string
        'deskripsi_panduan' => implode('|', $deskripsiPanduan), // Gabungkan kembali menjadi string
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
        'No' => 'required|integer',  // Validasi nomor urut (No)
        'deskripsi' => 'nullable|string',
        'foto_dokumen.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk multiple file gambar
        'deskripsi_panduan.*' => 'nullable|string', // Validasi deskripsi panduan untuk tiap gambar
    ]);

    // Array untuk menyimpan path foto dan deskripsi panduan
    $fotoDokumen = [];
    $deskripsiPanduan = [];

    // Proses setiap file foto dan deskripsi panduan
    if ($request->hasFile('foto_dokumen')) {
        foreach ($request->file('foto_dokumen') as $index => $file) {
            // Menyimpan foto_dokumen
            $fotoPath = $file->store('foto_gejala', 'public');
            $fotoDokumen[] = $fotoPath;

            // Menyimpan deskripsi panduan untuk tiap gambar
            $deskripsiPanduan[] = $request->deskripsi_panduan[$index] ?? '';
        }
    }

    // Menyimpan data gejala termasuk foto_dokumen
    gejala::create([
        'No' => $request->No,  // Menyimpan nomor urut yang telah dihitung
        'kode_gejala' => $request->kode_gejala,
        'nama_gejala' => $request->nama_gejala,
        'deskripsi' => $request->deskripsi,
        'foto_dokumen' => implode(',', $fotoDokumen), // Menyimpan path gambar sebagai string yang dipisahkan koma
        'deskripsi_panduan' => implode('|', $deskripsiPanduan), // Menyimpan deskripsi panduan sebagai string
    ]);

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

    // Pecah data foto_dokumen menjadi array
    $fotoDokumen = $gejala->foto_dokumen ? explode(',', $gejala->foto_dokumen) : [];
    
    // Pecah data deskripsi_panduan menjadi array
    $deskripsiPanduan = $gejala->deskripsi_panduan ? explode('|', $gejala->deskripsi_panduan) : [];

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
        'deskripsi' => 'nullable|string',
        'foto_dokumen.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk multiple file gambar
        'deskripsi_panduan.*' => 'nullable|string', // Validasi deskripsi panduan untuk tiap gambar
        'hapus_gambar.*' => 'nullable|integer', // Validasi untuk gambar yang ingin dihapus
    ]);

    // Cari gejala berdasarkan kode_gejala
    $gejala = gejala::where('kode_gejala', $kode_gejala)->firstOrFail();
    // Hapus gambar yang tidak ada di input terbaru
    $existingPhotos = explode(',', $gejala->foto_dokumen);
    $newPhotos = $request->input('foto_dokumen', []);

    $photosToDelete = array_diff($existingPhotos, $newPhotos);

    foreach ($photosToDelete as $photo) {
        if (Storage::exists('public/' . $photo)) {
            Storage::delete('public/' . $photo);
        }
    }

    // Ambil data foto_dokumen dan deskripsi_panduan yang ada
    $fotoDokumen = $gejala->foto_dokumen ? explode(',', $gejala->foto_dokumen) : [];
    $deskripsiPanduan = $gejala->deskripsi_panduan ? explode('|', $gejala->deskripsi_panduan) : [];

    // Hapus gambar yang dipilih untuk dihapus
    if ($request->has('hapus_gambar')) {
        foreach ($request->hapus_gambar as $index) {
            // Hapus file dari storage
            if (isset($fotoDokumen[$index])) {
                \Storage::disk('public')->delete($fotoDokumen[$index]);
                unset($fotoDokumen[$index]);
                unset($deskripsiPanduan[$index]);
            }
        }

        // Reset array untuk menghapus celah
        $fotoDokumen = array_values($fotoDokumen);
        $deskripsiPanduan = array_values($deskripsiPanduan);
    }

    // Proses pengunggahan gambar baru
    if ($request->hasFile('foto_dokumen')) {
        foreach ($request->file('foto_dokumen') as $index => $file) {
            // Simpan gambar baru
            $fotoPath = $file->store('foto_gejala', 'public');
            $fotoDokumen[] = $fotoPath;

            // Simpan deskripsi panduan baru
            $deskripsiPanduan[] = $request->deskripsi_panduan[$index] ?? '';
        }
    }

    // Update data gejala
    $gejala->update([
        'nama_gejala' => $request->input('nama_gejala'),
        'deskripsi' => $request->input('deskripsi'),
        'foto_dokumen' => implode(',', $fotoDokumen), // Gabungkan kembali menjadi string
        'deskripsi_panduan' => implode('|', $deskripsiPanduan), // Gabungkan kembali menjadi string
    ]);

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
    $gejala = gejala::all(); // Ambil semua data gejala

    $pdf = PDF::loadView('pdf.gejala', compact('gejala'))
        ->setPaper('a4', 'portrait'); // Set kertas A4 dengan orientasi portrait

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
