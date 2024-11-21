<?php

namespace App\Http\Controllers;

use App\Models\AturanPenyakit;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Solusi;
use Illuminate\Http\Request;

class DiagnosaController extends Controller
{
    // Menampilkan pertanyaan pertama
    public function index()
    {
        // Ambil gejala yang belum dijawab, baik wajib maupun opsional
        $answeredGejala = session('answered_gejala', []);
        $question = AturanPenyakit::with('gejala')
            ->whereNotIn('kode_gejala', array_keys($answeredGejala)) // Menghindari gejala yang sudah dijawab
            ->first();

        // Jika tidak ada pertanyaan lagi, arahkan ke hasil diagnosa
        if (!$question) {
            return redirect()->route('diagnosa.result');
        }

        return view('pages.UserPages.diagnosa', compact('question'));
    }

    // Menyimpan jawaban pengguna dan lanjutkan ke pertanyaan berikutnya
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
            $diagnosaUtama = [
                'penyakit' => $p->nama_penyakit,
                'gejala' => $aturanPenyakit->pluck('gejala.nama_gejala')->toArray(),
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

    // Reset sesi jawaban
    public function resetDiagnosa()
    {
        session()->forget('answered_gejala');
        return redirect()->route('diagnosa.index')->with('success', 'Diagnosa telah direset.');
    }
}
