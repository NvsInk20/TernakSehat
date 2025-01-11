<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\penyakit;
use App\Models\Pengguna;
// use Barryvdh\DomPDF\Facade as PDF;
use setasign\Fpdi\Fpdi;
use App\Models\rekomendasi;
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

    // Query utama
    $riwayatPaginated = RiwayatDiagnosa::where('kode_user', auth()->user()->kode_user) // Ambil berdasarkan pengguna yang login
        ->when($search, function ($query, $search) {
            // Cek apakah input berupa tanggal lengkap (format: YYYY-MM-DD)
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $search)) {
                $query->whereDate('created_at', $search); // Pencarian tanggal penuh
            }
            // Cek apakah input berupa tahun saja (format: YYYY)
            elseif (preg_match('/^\d{4}$/', $search)) {
                $query->whereYear('created_at', $search); // Pencarian berdasarkan tahun
            }
            // Cek apakah input berupa bulan (angka: 1-12 atau nama bulan)
            elseif (is_numeric($search) && intval($search) >= 1 && intval($search) <= 12) {
                $query->whereMonth('created_at', $search); // Pencarian berdasarkan angka bulan
            } else {
                // Mapping nama bulan ke angka (untuk pencarian bulan dalam bahasa Indonesia)
                $bulanMap = [
                    'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
                    'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
                    'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
                    'jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4,
                    'mei' => 5, 'jun' => 6, 'jul' => 7, 'agu' => 8,
                    'sep' => 9, 'okt' => 10, 'nov' => 11, 'des' => 12
                ];
                $searchLower = strtolower($search);
                if (array_key_exists($searchLower, $bulanMap)) {
                    $query->whereMonth('created_at', $bulanMap[$searchLower]);
                }
            }
        })
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
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
    $rekomendasi = $riwayat->rekomendasi; // Asumsikan solusi masih dalam bentuk string dengan pemisah '|'

    // Data untuk dikirim ke view PDF
    $data = [
        'riwayat' => $riwayat,
        'gejala' => $gejala, // Gejala sudah menjadi array setelah decode
        'rekomendasi' => $rekomendasi ? explode('|', $rekomendasi) : [], // Pisahkan solusi dengan pemisah '|'
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
        $rekomendasi = $item->rekomendasi ? explode('|', $item->rekomendasi) : [];

        // Generate PDF individu menggunakan view
        $individualPdf = PDF::loadView('pdf.riwayat_diagnosa', [
            'riwayat' => $item,
            'gejala' => $gejala, // Gejala langsung sebagai array
            'rekomendasi' => $rekomendasi, // Solusi sebagai array
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
        $rekomendasi = $item->rekomendasi ? explode('|', $item->rekomendasi) : [];

        // Generate PDF untuk setiap riwayat menggunakan view
        $individualPdf = PDF::loadView('pdf.riwayat_diagnosa', [
            'riwayat' => $item,
            'gejala' => $gejala, // Kirim gejala sebagai array
            'rekomendasi' => $rekomendasi, // Kirim solusi sebagai array
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
    $query = pengguna::query();

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
    // Membuat query utama berdasarkan pengguna yang dipilih
    $query = RiwayatDiagnosa::where('kode_user', $kode_user); // Membatasi data hanya untuk pengguna tertentu

    // Menambahkan logika pencarian
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');

        // Tambahkan filter pencarian
        $query->where(function ($q) use ($search) {
            // Pencarian berdasarkan penyakit
            $q->where('penyakit_utama', 'like', "%{$search}%")
              ->orWhere('penyakit_alternatif_1', 'like', "%{$search}%")
              ->orWhere('penyakit_alternatif_2', 'like', "%{$search}%");

            // Logika tambahan untuk pencarian waktu
            $q->orWhere(function ($subQuery) use ($search) {
                // Cek apakah input berupa tanggal lengkap (format: YYYY-MM-DD)
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $search)) {
                    $subQuery->whereDate('created_at', $search); // Pencarian tanggal penuh
                }
                // Cek apakah input berupa tahun saja (format: YYYY)
                elseif (preg_match('/^\d{4}$/', $search)) {
                    $subQuery->whereYear('created_at', $search); // Pencarian berdasarkan tahun
                }
                // Cek apakah input berupa angka bulan (1-12) atau nama bulan (bahasa Indonesia)
                elseif (is_numeric($search) && intval($search) >= 1 && intval($search) <= 12) {
                    $subQuery->whereMonth('created_at', $search); // Pencarian berdasarkan angka bulan
                } else {
                    // Mapping nama bulan ke angka (untuk pencarian bulan dalam bahasa Indonesia)
                    $bulanMap = [
                        'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
                        'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
                        'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
                        'jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4,
                        'mei' => 5, 'jun' => 6, 'jul' => 7, 'agu' => 8,
                        'sep' => 9, 'okt' => 10, 'nov' => 11, 'des' => 12
                    ];
                    $searchLower = strtolower($search);
                    if (array_key_exists($searchLower, $bulanMap)) {
                        $subQuery->whereMonth('created_at', $bulanMap[$searchLower]);
                    }
                }
            });
        });
    }

    // Menyimpan URL sebelumnya untuk navigasi
    if (url()->previous() !== url()->current()) {
        session(['previous_url' => url()->previous()]);
    }

    // Menambahkan paginasi ke query
    $riwayatPaginated = $query->orderBy('created_at', 'desc')->paginate(10);

    // Cek apakah permintaan AJAX
    if ($request->ajax()) {
        return view('partials.riwayatDiagnosaTable', ['riwayatPaginated' => $riwayatPaginated]);
    }

    // Mengirimkan data ke view utama
    return view('pages.UserPages.riwayatDiagnosa', [
        'title' => 'Riwayat Diagnosa',
        'riwayatPaginated' => $riwayatPaginated,
        'kode_user' => $kode_user,
        'search' => $request->search ?? '',
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
