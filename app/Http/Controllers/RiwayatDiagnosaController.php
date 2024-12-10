<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\penyakit;
use App\Models\Pengguna;
use App\Models\solusi;
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
            return $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('penyakit_utama', 'like', "%{$search}%")
                        ->orWhere('penyakit_alternatif_1', 'like', "%{$search}%") // Tambahkan pencarian alternatif 1
                        ->orWhere('penyakit_alternatif_2', 'like', "%{$search}%"); // Tambahkan pencarian alternatif 2
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
    public function cetakPDF($kode_riwayat)
    {
        // Ambil data diagnosa berdasarkan ID
        $riwayat = RiwayatDiagnosa::findOrFail($kode_riwayat);

        // Convert gejala dari string ke array (jika ada)
        $gejalaArray = $riwayat->gejala ? explode(',', $riwayat->gejala) : [];

        // Generate PDF
        $pdf = PDF::loadView('pdf.riwayat_diagnosa', compact('riwayat', 'gejalaArray'));

        // Unduh atau tampilkan PDF
        return $pdf->stream('Hasil_Diagnosa_Sapi_' . $riwayat->kode_sapi . '.pdf');
    }


}
