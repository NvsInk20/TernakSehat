<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AturanPenyakit;
use App\Models\RiwayatDiagnosa;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Solusi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiagnosaController extends Controller
{
    // Menampilkan pertanyaan pertama
    public function index()
{
    // Ambil gejala yang belum dijawab, urutkan berdasarkan gejala wajib dulu
    $answeredGejala = session('answered_gejala', []);
    $question = AturanPenyakit::with('gejala')
        ->whereNotIn('kode_gejala', array_keys($answeredGejala)) // Hindari gejala yang sudah dijawab
        ->orderByRaw("FIELD(jenis_gejala, 'wajib', 'opsional')") // Prioritaskan gejala wajib
        ->first();

    // Jika tidak ada pertanyaan lagi, arahkan ke hasil diagnosa
    if (!$question) {
        return redirect()->route('diagnosa.result');
    }

    return view('pages.UserPages.diagnosa', compact('question'));
}

public function answerQuestion(Request $request)
{
    $answer = $request->input('answer'); // 1 untuk 'Iya', 0 untuk 'Tidak'
    $kodeGejala = $request->input('kode_gejala');

    // Simpan jawaban di sesi
    $answeredGejala = session('answered_gejala', []);
    $answeredGejala[$kodeGejala] = $answer; // Simpan jawaban
    session(['answered_gejala' => $answeredGejala]);

    // Cek apakah semua gejala wajib terpenuhi dan semua gejala opsional sudah dijawab
    $penyakit = Penyakit::all();
    $aturan = AturanPenyakit::all();

    foreach ($penyakit as $p) {
        $aturanPenyakit = $aturan->where('kode_penyakit', $p->kode_penyakit);

        // Ambil gejala wajib dan opsional
        $wajib = $aturanPenyakit->where('jenis_gejala', 'wajib');
        $opsional = $aturanPenyakit->where('jenis_gejala', 'opsional');

        // Logika AND: Semua gejala wajib harus terpenuhi
        $wajibTerpenuhi = $wajib->every(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1;
        });

        // Logika: Semua gejala opsional harus dijawab
        $opsionalSudahDijawab = $opsional->every(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]);
        });

        // Jika semua gejala wajib terpenuhi dan semua opsional sudah dijawab, arahkan ke hasil diagnosa
        if ($wajibTerpenuhi && $opsionalSudahDijawab) {
            return redirect()->route('diagnosa.result');
        }
    }

    // Jika kondisi belum terpenuhi, lanjutkan ke pertanyaan berikutnya
    return redirect()->route('diagnosa.index');
}

    // Menampilkan hasil diagnosa
public function showResult()
{
    $answeredGejala = session('answered_gejala', []);
    if (empty($answeredGejala)) {
        return redirect()->route('diagnosa.index')->with('error', 'Silakan jawab pertanyaan terlebih dahulu.');
    }

    // Cek jika semua jawaban "Tidak" (0)
    $allNoAnswers = collect($answeredGejala)->every(function ($answer) {
        return $answer == 0;
    });

    if ($allNoAnswers) {
        return view('pages.UserPages.hasil', [
            'diagnosaUtama' => [
                'penyakit' => 'Tidak ada penyakit',
                'gejala' => [],
                'solusi' => ['Sapi dalam kondisi sehat. Pastikan tetap memberikan pakan berkualitas dan lingkungan yang bersih.'],
            ],
            'kemungkinan' => [],
        ]);
    }

    // Ambil data penyakit dan aturan
    $penyakit = Penyakit::all();
    $aturan = AturanPenyakit::all();

    $diagnosaUtama = null;
    $kemungkinan = [];

    foreach ($penyakit as $p) {
        $aturanPenyakit = $aturan->where('kode_penyakit', $p->kode_penyakit);

        // Evaluasi aturan dengan logika AND dan OR
        $wajib = $aturanPenyakit->where('jenis_gejala', 'wajib');
        $opsional = $aturanPenyakit->where('jenis_gejala', 'opsional');

        // Logika AND: Semua gejala wajib harus terpenuhi
        $wajibTerpenuhi = $wajib->every(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1;
        });

        // Logika OR: Minimal satu gejala opsional terpenuhi
        $opsionalTerpenuhi = $opsional->filter(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1;
        })->count();

        // Diagnosa utama ditentukan hanya jika gejala wajib terpenuhi
        if ($wajibTerpenuhi) {
            $gejalaTerpenuhi = $aturanPenyakit->filter(function ($rule) use ($answeredGejala) {
                return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1;
            })->pluck('gejala.nama_gejala')->toArray(); // Hanya ambil gejala yang dijawab "Iya"

            $diagnosaUtama = [
                'penyakit' => $p->nama_penyakit,
                'gejala' => $gejalaTerpenuhi, // Gejala yang dijawab "Iya"
                'solusi' => $aturanPenyakit->pluck('solusi.solusi')->unique()->toArray(),
            ];
            break; // Hentikan pencarian setelah diagnosa utama ditemukan
        }

        // Hitung kemungkinan hanya jika gejala wajib tidak terpenuhi
        $totalGejala = $wajib->count() + $opsional->count();
        $terpenuhi = ($wajibTerpenuhi ? $wajib->count() : 0) + $opsionalTerpenuhi;

        if ($totalGejala > 0) {
            $kemungkinan[$p->nama_penyakit] = round(($terpenuhi / $totalGejala) * 100, 2);
        }
    }

    // Saring penyakit dengan persentase 0%
    $kemungkinan = array_filter($kemungkinan, function($persentase) {
        return $persentase > 0;
    });

    // Urutkan kemungkinan penyakit berdasarkan persentase
    arsort($kemungkinan);

    // Menentukan dua penyakit dengan kemungkinan tertinggi
    $penyakitTertinggi = key($kemungkinan); // Penyakit dengan kemungkinan tertinggi
    $persentaseTertinggi = current($kemungkinan);

    // Penyakit kedua jika ada
    $penyakitKedua = null;
    $persentaseKedua = 0;
    if (count($kemungkinan) > 1) {
        next($kemungkinan); // Pindah ke penyakit kedua
        $penyakitKedua = key($kemungkinan);
        $persentaseKedua = current($kemungkinan);
    }

    // Ambil solusi untuk penyakit dengan kemungkinan tertinggi
    $solusiTertinggi = '';
    if ($penyakitTertinggi) {
        $penyakitTertinggiObj = $penyakit->firstWhere('nama_penyakit', $penyakitTertinggi);
        $aturanPenyakitTertinggi = $aturan->where('kode_penyakit', $penyakitTertinggiObj->kode_penyakit);
        $solusiTertinggi = $aturanPenyakitTertinggi->pluck('solusi.solusi')->unique()->toArray();
    }

    // Solusi untuk penyakit kedua
    $solusiKedua = [];
    if ($penyakitKedua) {
        $penyakitKeduaObj = $penyakit->firstWhere('nama_penyakit', $penyakitKedua);
        $aturanPenyakitKedua = $aturan->where('kode_penyakit', $penyakitKeduaObj->kode_penyakit);
        $solusiKedua = $aturanPenyakitKedua->pluck('solusi.solusi')->unique()->toArray();
    }

    return view('pages.UserPages.hasil', [
        'diagnosaUtama' => $diagnosaUtama,
        'kemungkinan' => $kemungkinan,
        'penyakitTertinggi' => $penyakitTertinggi,
        'persentaseTertinggi' => $persentaseTertinggi,
        'solusiTertinggi' => $solusiTertinggi,
        'penyakitKedua' => $penyakitKedua,
        'persentaseKedua' => $persentaseKedua,
        'solusiKedua' => $solusiKedua,
    ]);
}


    public function getDiagnosaHasil()
{
    // Ambil jawaban gejala yang sudah disimpan di sesi
    $answeredGejala = session('answered_gejala', []);
    if (empty($answeredGejala)) {
        return redirect()->route('diagnosa.index')->with('error', 'Silakan jawab pertanyaan terlebih dahulu.');
    }

    // Cek jika semua jawaban "Tidak" (0)
    $allNoAnswers = collect($answeredGejala)->every(function ($answer) {
        return $answer == 0;
    });

    if ($allNoAnswers) {
        return view('pages.UserPages.hasilSimpan', [
            'diagnosaUtama' => [
                'penyakit' => 'Tidak ada penyakit',
                'gejala' => [],
                'solusi' => ['Sapi dalam kondisi sehat. Pastikan tetap memberikan pakan berkualitas dan lingkungan yang bersih.'],
            ],
            'kemungkinan' => [],
            'penyakitTertinggi' => null,
            'persentaseTertinggi' => null,
            'solusiTertinggi' => null,
            'penyakitKedua' => null,
            'persentaseKedua' => null,
            'solusiKedua' => null,
        ]);
    }

    // Ambil data penyakit dan aturan
    $penyakit = Penyakit::all();
    $aturan = AturanPenyakit::all();

    $diagnosaUtama = null;
    $kemungkinan = [];

    foreach ($penyakit as $p) {
        $aturanPenyakit = $aturan->where('kode_penyakit', $p->kode_penyakit);

        // Evaluasi aturan dengan logika AND dan OR
        $wajib = $aturanPenyakit->where('jenis_gejala', 'wajib');
        $opsional = $aturanPenyakit->where('jenis_gejala', 'opsional');

        $wajibTerpenuhi = $wajib->every(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1;
        });

        $opsionalTerpenuhi = $opsional->filter(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1;
        })->count();

        if ($wajibTerpenuhi) {
            $diagnosaUtama = [
                'penyakit' => $p->nama_penyakit,
                'gejala' => $aturanPenyakit->pluck('gejala.nama_gejala')->toArray(),
                'solusi' => $aturanPenyakit->pluck('solusi.solusi')->unique()->toArray(),
            ];
            break;
        }

        $totalGejala = $wajib->count() + $opsional->count();
        $terpenuhi = ($wajibTerpenuhi ? $wajib->count() : 0) + $opsionalTerpenuhi;

        if ($totalGejala > 0) {
            $kemungkinan[$p->nama_penyakit] = round(($terpenuhi / $totalGejala) * 100, 2);
        }
    }

    $kemungkinan = array_filter($kemungkinan, function ($persentase) {
        return $persentase > 0;
    });

    arsort($kemungkinan);

    $penyakitTertinggi = key($kemungkinan);
    $persentaseTertinggi = current($kemungkinan);

    $penyakitKedua = null;
    $persentaseKedua = null;
    if (count($kemungkinan) > 1) {
        next($kemungkinan);
        $penyakitKedua = key($kemungkinan);
        $persentaseKedua = current($kemungkinan);
    }

    $solusiTertinggi = $penyakitTertinggi ? $aturan->where('kode_penyakit', $penyakit->firstWhere('nama_penyakit', $penyakitTertinggi)->kode_penyakit)->pluck('solusi.solusi')->unique()->toArray() : [];
    $solusiKedua = $penyakitKedua ? $aturan->where('kode_penyakit', $penyakit->firstWhere('nama_penyakit', $penyakitKedua)->kode_penyakit)->pluck('solusi.solusi')->unique()->toArray() : [];

    return view('pages.UserPages.hasilSimpan', [
        'diagnosaUtama' => $diagnosaUtama,
        'kemungkinan' => $kemungkinan,
        'penyakitTertinggi' => $penyakitTertinggi,
        'persentaseTertinggi' => $persentaseTertinggi,
        'solusiTertinggi' => $solusiTertinggi,
        'penyakitKedua' => $penyakitKedua,
        'persentaseKedua' => $persentaseKedua,
        'solusiKedua' => $solusiKedua,
    ]);
}



    public function simpanHasil(Request $request)
{
    // Cek apakah pengguna sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->withErrors(['login' => 'Harap login terlebih dahulu.']);
    }

    // Validasi input
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'kode_sapi' => 'required|string|max:255',
        'penyakit_utama' => 'nullable|string|max:255',
        'gejala' => 'nullable|string', // Tidak wajib
        'solusi' => 'nullable|string|max:10000', // Tidak wajib
        'penyakit_alternatif_1' => 'nullable|string|max:255',
        'penyakit_alternatif_2' => 'nullable|string|max:255',
    ]);

    // Pisahkan gejala menjadi array (jika ada)
    $gejala = $validatedData['gejala'] ?? null;
    $gejalaArray = $gejala ? explode(', ', $gejala) : [];

    // Cari penyakit utama
    $penyakitUtama = isset($validatedData['penyakit_utama']) && $validatedData['penyakit_utama'] !== null
        ? Penyakit::where('nama_penyakit', $validatedData['penyakit_utama'])->first()
        : null;

    // Cari penyakit alternatif 1 dan 2
    $penyakitAlternatif1 = isset($validatedData['penyakit_alternatif_1']) && $validatedData['penyakit_alternatif_1'] !== null
        ? Penyakit::where('nama_penyakit', $validatedData['penyakit_alternatif_1'])->first()
        : null;

    $penyakitAlternatif2 = isset($validatedData['penyakit_alternatif_2']) && $validatedData['penyakit_alternatif_2'] !== null
        ? Penyakit::where('nama_penyakit', $validatedData['penyakit_alternatif_2'])->first()
        : null;

    // Ambil nomor urut terakhir untuk 'No' dan tambahkan 1
    $lastNo = RiwayatDiagnosa::max('No');
    $nextNo = $lastNo ? $lastNo + 1 : 1;

    // Pastikan ada setidaknya satu penyakit untuk disimpan
    if (!$penyakitUtama && !$penyakitAlternatif1 && !$penyakitAlternatif2) {
        return back()->withErrors(['diagnosa' => 'Diagnosa gagal: Tidak ada penyakit yang dapat disimpan.'])->withInput();
    }

    // Simpan RiwayatDiagnosa
    RiwayatDiagnosa::create([
        'No' => $nextNo,
        'kode_user' => auth()->user()->kode_user,
        'nama' => $validatedData['nama'],
        'kode_sapi' => $validatedData['kode_sapi'],
        'penyakit_utama' => $penyakitUtama ? $penyakitUtama->nama_penyakit : null,  // Simpan nama penyakit utama
        'gejala' => $gejala ? implode(',', $gejalaArray) : null, // Gejala diproses sebagai string
        'solusi' => $validatedData['solusi'] ?? null,  // Simpan solusi, bisa null
        'penyakit_alternatif_1' => $penyakitAlternatif1 ? $penyakitAlternatif1->nama_penyakit : null,  // Simpan nama penyakit alternatif 1
        'penyakit_alternatif_2' => $penyakitAlternatif2 ? $penyakitAlternatif2->nama_penyakit : null,  // Simpan nama penyakit alternatif 2
        'kode_riwayat' => 'RDG-' . strtoupper(Str::random(5)),
    ]);

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Hasil diagnosa berhasil disimpan.');
}



    // Reset sesi jawaban
    public function resetDiagnosa()
    {
        session()->forget('answered_gejala');
        return redirect()->route('diagnosa.index')->with('success', 'Diagnosa telah direset.');
    }
}
