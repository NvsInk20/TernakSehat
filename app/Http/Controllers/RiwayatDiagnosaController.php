<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\penyakit;
use App\Models\Pengguna;
// use Barryvdh\DomPDF\Facade as PDF;
use setasign\Fpdi\Fpdi;
use App\Models\solusi;
use Illuminate\Support\Facades\Auth;
use App\Models\gejala;
use PDF;
use App\Models\AturanPenyakit;
use App\Models\RiwayatDiagnosa;

class RiwayatDiagnosaController extends Controller
{
    public function index(Request $request)
{
    // Ambil input pencarian dari pengguna
    $search = $request->input('search');

    // Ambil data riwayat diagnosa untuk pengguna yang sedang login
    $riwayatPaginated = RiwayatDiagnosa::where('kode_user', auth()->user()->kode_user) // Ambil berdasarkan pengguna yang login
        ->with('user') // Memuat relasi user jika diperlukan
        ->when($search, function ($query, $search) {
            // Gunakan 'like' hanya pada kolom yang relevan, pastikan kata kunci tepat pada nama penyakit atau bagian utama.
            return $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%") // Pencarian di nama penyakit
                  ->orWhere('penyakit_utama', 'like', "%{$search}%") // Pencarian di penyakit utama
                  ->orWhere('penyakit_alternatif_1', 'like', "%{$search}%") // Pencarian di penyakit alternatif 1
                  ->orWhere('penyakit_alternatif_2', 'like', "%{$search}%"); // Pencarian di penyakit alternatif 2
            });
        })
        ->orderBy('No', 'asc')
        ->paginate(10)
        ->withQueryString(); // Sertakan query string untuk pencarian di URL

    // Return view dengan data riwayat yang dipaginasi
    return view('pages.UserPages.Riwayat', [
        'riwayatPaginated' => $riwayatPaginated,
        'search' => $search,
    ]);
}


    public function indexDiagnosa()
{
    $riwayat = RiwayatDiagnosa::where('kode_user', auth()->user()->kode_user)
                               ->distinct('kode_sapi') // Menampilkan kode_sapi yang unik
                               ->get(['kode_sapi']); // Ambil hanya kolom kode_sapi
    return view('pages.UserPages.OptionsDiagnosa', [
        'title' => 'Diagnosa',
        'active' => 'Diagnosa',
        'riwayat' => $riwayat, // Pass the variable to the view
    ]);
}


    public function destroy($kode_riwayat)
{
    try {
        $riwayat = RiwayatDiagnosa::findOrFail($kode_riwayat);
        $riwayat->delete();

        return redirect()->route('riwayatDiagnosa.index')->with('success', 'Data berhasil dihapus!');
    } catch (ModelNotFoundException $e) {
        return redirect()->route('riwayatDiagnosa.index')->with('error', 'Data tidak ditemukan!');
    } catch (\Exception $e) {
        return redirect()->route('riwayatDiagnosa.index')->with('error', 'Terjadi kesalahan saat menghapus data!');
    }
}
    public function hapusSemua()
{
    // Menghapus semua data riwayat diagnosa
    RiwayatDiagnosa::truncate();

    // Redirect dengan pesan sukses
    return redirect()->route('riwayatDiagnosa.index')->with('success', 'Semua data riwayat diagnosa berhasil dihapus.');
}


    public function cetakPDF($kode_riwayat)
{
    // Ambil data riwayat diagnosa berdasarkan kode
    $riwayat = RiwayatDiagnosa::where('kode_riwayat', $kode_riwayat)->firstOrFail();

    // Siapkan data gejala dan solusi langsung dari kolom tabel
    // Decode gejala dari JSON menjadi array
    $gejala = json_decode($riwayat->gejala, true); // Pastikan gejala disimpan dalam format JSON
    $solusi = $riwayat->solusi; // Asumsikan solusi masih dalam bentuk string dengan pemisah '|'

    // Data untuk dikirim ke view PDF
    $data = [
        'riwayat' => $riwayat,
        'gejala' => $gejala, // Gejala sudah menjadi array setelah decode
        'solusi' => $solusi ? explode('|', $solusi) : [], // Pisahkan solusi dengan pemisah '|'
    ];

    // Generate PDF
    $pdf = PDF::loadView('pdf.riwayat_diagnosa', $data);

    return $pdf->stream('Hasil_Diagnosa_' . $riwayat->kode_sapi . '.pdf');
}




    public function cetakSemuaPDFGabungan()
{
    // Ambil semua data riwayat pengguna yang login
    $riwayat = RiwayatDiagnosa::where('kode_user', auth()->user()->kode_user)->get();

    if ($riwayat->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada riwayat diagnosa yang ditemukan.');
    }

    // Inisialisasi FPDI
    $pdf = new \setasign\Fpdi\Fpdi();

    foreach ($riwayat as $item) {
        // Decode gejala dari JSON menjadi array
        $gejala = json_decode($item->gejala, true); // Pastikan gejala disimpan dalam format JSON
        if (!is_array($gejala)) {
            $gejala = []; // Default ke array kosong jika decode gagal
        }

        // Pisahkan solusi jika ada, dengan pemisah '|'
        $solusi = $item->solusi ? explode('|', $item->solusi) : [];

        // Generate PDF individu menggunakan view
        $individualPdf = PDF::loadView('pdf.riwayat_diagnosa', [
            'riwayat' => $item,
            'gejala' => $gejala, // Gejala langsung sebagai array
            'solusi' => $solusi, // Solusi sebagai array
        ])->output();

        // Simpan PDF sementara
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tmpFilePath, $individualPdf);

        // Gabungkan file PDF individu
        $pageCount = $pdf->setSourceFile($tmpFilePath);
        for ($page = 1; $page <= $pageCount; $page++) {
            $tplId = $pdf->importPage($page);
            $pdf->AddPage();
            $pdf->useTemplate($tplId);
        }

        // Hapus file sementara
        unlink($tmpFilePath);
    }

    // Kirim file PDF gabungan ke browser
    return response()->streamDownload(function () use ($pdf) {
        $pdf->Output('I', 'CetakSemua_riwayat.pdf');
    }, 'gabungan_riwayat.pdf');
}


    public function cetakSemuaPDFGabunganAdmin($kode_user)
{
    // Ambil semua data riwayat diagnosa milik pengguna berdasarkan kode_user
    $riwayat = RiwayatDiagnosa::where('kode_user', $kode_user)->get();

    // Periksa jika data kosong
    if ($riwayat->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada riwayat diagnosa yang ditemukan untuk pengguna ini.');
    }

    // Inisialisasi FPDI
    $pdf = new \setasign\Fpdi\Fpdi();

    foreach ($riwayat as $item) {
        // Decode gejala dari JSON menjadi array
        $gejala = json_decode($item->gejala, true); // Pastikan gejala disimpan dalam format JSON
        if (!is_array($gejala)) {
            $gejala = []; // Default ke array kosong jika decode gagal
        }

        // Pisahkan solusi jika ada, dengan pemisah '|'
        $solusi = $item->solusi ? explode('|', $item->solusi) : [];

        // Generate PDF untuk setiap riwayat menggunakan view
        $individualPdf = PDF::loadView('pdf.riwayat_diagnosa', [
            'riwayat' => $item,
            'gejala' => $gejala, // Kirim gejala sebagai array
            'solusi' => $solusi, // Kirim solusi sebagai array
        ])->output();

        // Simpan PDF ke file sementara
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tmpFilePath, $individualPdf);

        // Gabungkan PDF individu ke file utama dengan FPDI
        $pageCount = $pdf->setSourceFile($tmpFilePath);
        for ($page = 1; $page <= $pageCount; $page++) {
            $tplId = $pdf->importPage($page);
            $pdf->AddPage();
            $pdf->useTemplate($tplId);
        }

        // Hapus file sementara
        unlink($tmpFilePath);
    }

    // Kembalikan file PDF gabungan untuk di-download
    return response()->streamDownload(function () use ($pdf) {
        $pdf->Output('I', 'CetakSemua_Riwayat_Diagnosa.pdf');
    }, 'gabungan_riwayat_diagnosa.pdf');
}


    public function showRiwayatUsers(Request $request)
{
    // Periksa apakah pengguna memiliki role "admin"
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.'); // Tampilkan error jika bukan admin
    }

    // Mulai query dari model Pengguna
    $query = Pengguna::query();

    // Menambahkan logika pencarian
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->where('kode_user', 'like', "%{$search}%")
            ->orWhere('nama', 'like', "%{$search}%");
    }

    // Lakukan paginasi untuk hasil query
    $users = $query->orderBy('No', 'asc')->paginate(10);

    // Kirim data ke view
    return view('pages.AdminPages.tabelRiwayat', [
        'title' => 'Tabel Riwayat Diagnosa',
        'users' => $users,
    ]);
}

    public function showRiwayat(Request $request, $kode_user)
{
    $query = RiwayatDiagnosa::where('kode_user', $kode_user); // Mengambil data berdasarkan kode_user

    // Menambahkan logika pencarian
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->where('penyakit_utama', 'like', "%{$search}%")
            ->orWhere('penyakit_alternatif_1', 'like', "%{$search}%")
            ->orWhere('penyakit_alternatif_2', 'like', "%{$search}%");
    }
    if (url()->previous() !== url()->current()) {
        session(['previous_url' => url()->previous()]);
    }

    // Menambahkan paginasi ke query
    $riwayatPaginated = $query->paginate(10);

    // Cek apakah permintaan AJAX
    if ($request->ajax()) {
        return view('partials.riwayatDiagnosaTable', ['riwayatPaginated' => $riwayatPaginated]);
    }

    // Mengirimkan data ke view utama
    return view('pages.UserPages.riwayatDiagnosa', [
        'title' => 'Riwayat Diagnosa',
        'riwayatPaginated' => $riwayatPaginated,
        'kode_user' => $kode_user,
        'activePage' => 'pages.UserPages.riwayatDiagnosa',
    ]);
}

public function chartData()
{
    // Statistik penyakit utama berdasarkan riwayat diagnosa
    $chartData = RiwayatDiagnosa::select('penyakit_utama', \DB::raw('COUNT(*) as count'))
        ->groupBy('penyakit_utama')
        ->orderBy('count', 'desc')
        ->take(10) // Ambil 10 penyakit utama paling sering
        ->get();

    // Ambil penyakit dengan diagnosa terbanyak
    $mostDiagnosedDisease = $chartData->first(); // Disease with the highest count

    // Data untuk dikembalikan ke view atau API
    return response()->json([
        'labels' => $chartData->pluck('penyakit_utama'), // Nama penyakit utama
        'data' => $chartData->pluck('count'), // Jumlah kasus
        'mostDiagnosedDisease' => $mostDiagnosedDisease ? $mostDiagnosedDisease->penyakit_utama : 'Riwayat Diagnosa Belum Ada', // Penyakit dengan diagnosa terbanyak
    ]);
}

public function chartTable(Request $request)
{
    // Ambil data berdasarkan riwayat diagnosa pengguna yang sedang login
    $query = RiwayatDiagnosa::query();

    // Tambahkan filter pencarian jika ada
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->where('penyakit_utama', 'like', "%{$search}%")
            ->orWhere('penyakit_alternatif_1', 'like', "%{$search}%")
            ->orWhere('penyakit_alternatif_2', 'like', "%{$search}%");
    }

    // Data untuk tabel dengan paginasi
    $chartTable = $query->where('kode_user', auth()->user()->kode_user)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Tentukan folder view berdasarkan role pengguna
    $role = auth()->user()->role;
    $viewFolder = $role === 'ahli pakar' ? 'PakarPages' : 'AdminPages';

    // Kirim data ke view yang sesuai
    return view("pages.$viewFolder.dashboard", [
        'chartTable' => $chartTable,
    ]);
}


}
