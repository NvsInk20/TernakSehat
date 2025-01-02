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
    // Ambil jawaban gejala dari sesi
    $answeredGejala = session('answered_gejala', []);

    // Ambil gejala yang belum dijawab
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

    // Simpan jawaban ke sesi
    $answeredGejala = session('answered_gejala', []);
    $answeredGejala[$kodeGejala] = $answer;
    session(['answered_gejala' => $answeredGejala]);

    // Ambil semua penyakit dan aturan
    $penyakit = Penyakit::all();
    $aturan = AturanPenyakit::all();

    foreach ($penyakit as $p) {
        $aturanPenyakit = $aturan->where('kode_penyakit', $p->kode_penyakit);

        // Ambil gejala wajib dan opsional
        $wajib = $aturanPenyakit->where('jenis_gejala', 'wajib');
        $opsional = $aturanPenyakit->where('jenis_gejala', 'opsional');

        // Logika gejala wajib: Semua harus "Iya"
        $wajibTerpenuhi = $wajib->every(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1;
        });

        // Filter gejala opsional berdasarkan gejala wajib yang sudah dijawab "Iya"
        $opsionalFiltered = $opsional->filter(function ($rule) use ($answeredGejala, $wajib) {
            return $wajib->contains(function ($wajibRule) use ($answeredGejala) {
                return isset($answeredGejala[$wajibRule->kode_gejala]) && $answeredGejala[$wajibRule->kode_gejala] == 1;
            });
        });

        // Logika gejala opsional: Minimal satu "Iya"
        $opsionalTerpenuhi = $opsionalFiltered->contains(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1;
        });

        // Jika semua gejala wajib terpenuhi dan minimal satu gejala opsional, arahkan ke hasil diagnosa
        if ($wajibTerpenuhi && $opsionalTerpenuhi) {
            session(['diagnosed_penyakit' => $p->kode_penyakit]); // Simpan hasil diagnosa ke sesi
            return redirect()->route('diagnosa.result');
        }

        // Jika ada gejala wajib yang dijawab "Tidak", abaikan penyakit ini sepenuhnya
        if ($wajib->contains(function ($rule) use ($answeredGejala) {
            return isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 0;
        })) {
            continue; // Lanjutkan ke penyakit berikutnya tanpa menanyakan gejala lain dari penyakit ini
        }
    }

    // Jika gejala wajib dijawab "Tidak", ganti ke gejala wajib penyakit lain
    $remainingQuestions = AturanPenyakit::whereNotIn('kode_gejala', array_keys($answeredGejala))
        ->orderByRaw("FIELD(jenis_gejala, 'wajib', 'opsional')")
        ->get();

    if ($remainingQuestions->isEmpty()) {
        return redirect()->route('diagnosa.result');
    }

    // Jika tidak memenuhi logika, lanjutkan ke pertanyaan berikutnya
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

        // Gejala yang dipilih user tetapi tidak termasuk dalam hasil diagnosa
    $gejalaTerpilih = collect($answeredGejala)->filter(function ($jawaban) {
        return $jawaban == 1; // Hanya gejala yang dijawab "Ya"
    })->keys()->toArray();

    $gejalaTidakMasuk = [];

    if ($diagnosaUtama) {
        // Ambil gejala yang masuk dalam diagnosa utama
        $gejalaHasilDiagnosa = $diagnosaUtama['gejala'] ?? [];

        // Bandingkan dengan gejala yang dipilih user
        $gejalaTidakMasuk = array_filter($gejalaTerpilih, function ($kodeGejala) use ($gejalaHasilDiagnosa, $aturan) {
            $namaGejala = $aturan->firstWhere('kode_gejala', $kodeGejala)?->gejala->nama_gejala ?? '';
            return !in_array($namaGejala, $gejalaHasilDiagnosa);
        });

        // Ambil nama gejala yang tidak masuk, serta nama penyakit yang terkait
        $gejalaTidakMasuk = array_map(function ($kodeGejala) use ($aturan) {
            $namaGejala = $aturan->firstWhere('kode_gejala', $kodeGejala)?->gejala->nama_gejala ?? 'Gejala tidak ditemukan';
            // Dapatkan nama penyakit yang memiliki gejala tersebut
            $penyakitAsal = $aturan->firstWhere('kode_gejala', $kodeGejala)?->gejala->penyakit->nama_penyakit ?? 'Penyakit tidak ditemukan';
            return ['gejala' => $namaGejala, 'penyakit' => $penyakitAsal];
        }, $gejalaTidakMasuk);
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
        'gejalaTidakMasuk' => $gejalaTidakMasuk, // Tambahkan ini
    ]);
}

    public function getDiagnosaHasil()
{
    // Ambil jawaban gejala yang sudah disimpan di sesi
    $answeredGejala = session('answered_gejala', []);
    if (empty($answeredGejala)) {
        return redirect()->route('diagnosa.index')->with('error', 'Silakan jawab pertanyaan terlebih dahulu.');
    }

     // Cek jika semua jawaban adalah "Tidak" (0)
    $allNoAnswers = collect($answeredGejala)->every(fn($answer) => $answer == 0);
    if ($allNoAnswers) {
        return view('pages.UserPages.hasilSimpan', [
            'diagnosaUtama' => [
                'penyakit' => 'Tidak ada penyakit',
                'gejala' => [],
                'solusi' => ['Sapi dalam kondisi sehat. Pastikan tetap memberikan pakan berkualitas dan lingkungan yang bersih.'],
            ],
            'kemungkinan' => [],
        ]);
    }
    $penyakit = Penyakit::all();
    $aturan = AturanPenyakit::all();

    $diagnosaUtama = null;
    $kemungkinan = [];
    $gejalaTerpenuhi = [];

    foreach ($penyakit as $p) {
        $aturanPenyakit = $aturan->where('kode_penyakit', $p->kode_penyakit);
        $wajib = $aturanPenyakit->where('jenis_gejala', 'wajib');
        $opsional = $aturanPenyakit->where('jenis_gejala', 'opsional');

        // Logika AND: Semua gejala wajib harus terpenuhi
        $wajibTerpenuhi = $wajib->every(fn($rule) => isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1);

        // Logika OR: Minimal satu gejala opsional terpenuhi
        $opsionalTerpenuhi = $opsional->filter(fn($rule) => isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1)->count();

        // Jika gejala wajib terpenuhi, diagnosa utama ditentukan
        if ($wajibTerpenuhi) {
            $gejalaTerpenuhi = $aturanPenyakit->filter(fn($rule) => isset($answeredGejala[$rule->kode_gejala]) && $answeredGejala[$rule->kode_gejala] == 1)
                ->pluck('gejala.nama_gejala')
                ->toArray();

            $diagnosaUtama = [
                'penyakit' => $p->nama_penyakit,
                'gejala' => $gejalaTerpenuhi,
                'solusi' => $aturanPenyakit->pluck('solusi.solusi')->unique()->toArray(),
            ];
            break;
        }

        // Hitung kemungkinan untuk penyakit lain jika gejala wajib tidak terpenuhi
        $totalGejala = $wajib->count() + $opsional->count();
        $terpenuhi = ($wajibTerpenuhi ? $wajib->count() : 0) + $opsionalTerpenuhi;

        if ($totalGejala > 0) {
            $kemungkinan[$p->nama_penyakit] = round(($terpenuhi / $totalGejala) * 100, 2);
        }
    }
    // Saring kemungkinan dengan persentase 0%
    $kemungkinan = array_filter($kemungkinan, fn($persentase) => $persentase > 0);

    arsort($kemungkinan);
    // Penyakit dengan kemungkinan tertinggi
    $penyakitTertinggi = key($kemungkinan);
    $persentaseTertinggi = current($kemungkinan);

    // Penyakit kedua jika ada
    $penyakitKedua = count($kemungkinan) > 1 ? array_keys($kemungkinan)[1] : null;
    $persentaseKedua = count($kemungkinan) > 1 ? array_values($kemungkinan)[1] : null;

    $gejalaDipilih = collect($answeredGejala)
        ->filter(fn($jawaban) => $jawaban == 1)
        ->keys()
        ->map(fn($kodeGejala) => $aturan->firstWhere('kode_gejala', $kodeGejala)?->gejala->nama_gejala ?? 'Gejala tidak ditemukan')
        ->toArray();

    return view('pages.UserPages.hasilSimpan', [
        'diagnosaUtama' => $diagnosaUtama,
        'kemungkinan' => $kemungkinan,
        'penyakitTertinggi' => key($kemungkinan),
        'persentaseTertinggi' => current($kemungkinan),
        'solusiTertinggi' => $diagnosaUtama['solusi'] ?? [],
        'penyakitKedua' => count($kemungkinan) > 1 ? array_keys($kemungkinan)[1] : null,
        'persentaseKedua' => count($kemungkinan) > 1 ? array_values($kemungkinan)[1] : null,
        'gejalaDipilih' => $gejalaDipilih,
    ]);
}
    public function simpanHasil(Request $request)
{
    // Pastikan pengguna sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->withErrors(['login' => 'Harap login terlebih dahulu.']);
    }

    // Ambil kode_sapi dari request atau sesi
    $kode_sapi = $request->input('kode_sapi', session('kode_sapi'));

    // Jika kode_sapi tidak ada di request dan session, generate otomatis
    if (!$kode_sapi) {
        $kode_sapi = 'SP-' . strtoupper(Str::random(5));
    }

    // Validasi bahwa kode_sapi tersedia
    if (!$kode_sapi) {
        return redirect()->back()->withErrors(['kode_sapi' => 'Kode sapi tidak ditemukan. Silakan pilih sapi terlebih dahulu.']);
    }

    // Validasi input lainnya
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'gejala' => 'nullable|string|max:5000',
    ]);

    // Ambil hasil diagnosa dari fungsi lain di controller
    $diagnosaHasil = $this->getDiagnosaHasil();
    $kemungkinan = $diagnosaHasil['kemungkinan'] ?? [];
    $gejalaDipilih = $diagnosaHasil['gejalaDipilih'] ?? [];
    $penyakitUtama = $diagnosaHasil['diagnosaUtama']['penyakit'] ?? null;
    $solusi = $diagnosaHasil['diagnosaUtama']['solusi'] ?? ['Tidak bisa memberikan rekomendasi yang aman.'];

    // Tentukan penyakit alternatif
    $penyakitAlternatif = array_keys($kemungkinan);
    $penyakitAlternatif1 = $penyakitAlternatif[0] ?? null;
    $penyakitAlternatif2 = $penyakitAlternatif[1] ?? null;

    // Ambil gejala dari request dan pecah menjadi array
    $gejalaAlternatif = array_map('trim', explode(',', $request->input('gejala', '')));

    // Gejala yang ada di penyakit utama
    $gejalaPenyakitUtama = $diagnosaHasil['diagnosaUtama']['gejala'] ?? [];

    // Menyusun daftar gejala dengan aturan yang benar
    $gejalaDisimpan = [];

    // Proses gejala dari hasil diagnosa
    foreach ($gejalaDipilih as $gejala) {
        if (!in_array($gejala, $gejalaPenyakitUtama)) {
            if (!in_array($gejala . ' (gejala berpotensi terdapat di penyakit alternatif)', $gejalaDisimpan)) {
                $gejalaDisimpan[] = $gejala . ' (gejala berpotensi terdapat di penyakit alternatif)';
            }
        } else {
            if (!in_array($gejala, $gejalaDisimpan)) {
                $gejalaDisimpan[] = $gejala;
            }
        }
    }

    // Proses gejala alternatif
    foreach ($gejalaAlternatif as $gejala) {
        if (empty($gejala)) {
            continue;
        }
        if (!in_array($gejala, $gejalaPenyakitUtama)) {
            if (!in_array($gejala . ' (gejala berpotensi terdapat di penyakit alternatif)', $gejalaDisimpan)) {
                $gejalaDisimpan[] = $gejala . ' (gejala berpotensi terdapat di penyakit alternatif)';
            }
        } else {
            if (!in_array($gejala, $gejalaDisimpan)) {
                $gejalaDisimpan[] = $gejala;
            }
        }
    }

    // Ambil nomor urut terakhir untuk No dan tambahkan 1
    $lastNo = RiwayatDiagnosa::max('No');
    $nextNo = $lastNo ? $lastNo + 1 : 1;

    // Simpan ke RiwayatDiagnosa
    RiwayatDiagnosa::create([
        'No' => $nextNo,
        'kode_user' => auth()->user()->kode_user,
        'nama' => $validatedData['nama'],
        'kode_sapi' => $kode_sapi,
        'penyakit_utama' => $penyakitUtama,
        'gejala' => json_encode($gejalaDisimpan), // Simpan gejala sebagai JSON
        'solusi' => implode('. ', $solusi),
        'penyakit_alternatif_1' => $penyakitAlternatif1,
        'penyakit_alternatif_2' => $penyakitAlternatif2,
        'kode_riwayat' => 'RDG-' . strtoupper(Str::random(5)),
    ]);

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Hasil diagnosa berhasil disimpan.');
}




    // Membantu pengguna untuk memilih mekanisme diagnosa
    public function mulaiDiagnosa(Request $request)
{
    // Reset sesi terkait diagnosa
    session()->forget('answered_gejala');  // Hapus data jawaban gejala sebelumnya
    session()->forget('diagnosed_penyakit');  // Hapus hasil diagnosa yang sudah ada

    // Memeriksa apakah pengguna memilih diagnosa baru atau berdasarkan riwayat
    $pilihan = $request->input('pilihan');

    if ($pilihan == 'baru') {
        // Jika memilih diagnosa baru, generate kode_sapi baru
        session(['kode_sapi' => 'SP-' . strtoupper(Str::random(5))]); // Generate kode sapi baru dan simpan di session
        return redirect()->route('user.diagnosa');
    }

    if ($pilihan == 'riwayat') {
        // Arahkan ke halaman riwayat diagnosa untuk memilih kode_sapi
        return redirect()->route('diagnosa.lanjut', ['kode_sapi' => $request->input('kode_sapi')]);
    }

    // Kembali ke halaman awal dengan pesan kesalahan jika tidak ada pilihan
    return redirect()->route('diagnosaBaru.index')->with('error', 'Pilih opsi yang valid.');
}

    public function lanjutDiagnosa($kode_sapi)
{
    // Ambil data riwayat diagnosa berdasarkan kode_sapi
    $riwayatDiagnosa = RiwayatDiagnosa::where('kode_sapi', $kode_sapi)->first();

    if (!$riwayatDiagnosa) {
        return redirect()->route('diagnosa.index')->with('error', 'Riwayat diagnosa tidak ditemukan untuk kode_sapi ini.');
    }

    // Simpan kode_sapi ke sesi
    session(['kode_sapi' => $riwayatDiagnosa->kode_sapi]);

    // Kembalikan ke halaman diagnosa dengan data riwayat diagnosa
    return view('pages.UserPages.diagnosa', [
        'riwayatDiagnosa' => $riwayatDiagnosa
    ]);
}


    // Reset sesi jawaban
    public function resetDiagnosa()
    {
        session()->forget('answered_gejala');
        return redirect()->route('diagnosa.index')->with('success', 'Diagnosa telah direset.');
    }
}
