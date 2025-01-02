<?php

namespace App\Http\Controllers;

use App\Models\AkunPengguna;
use App\Models\AhliPakar;
use App\Models\admin;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function indexLogin()
    {
        // Periksa apakah pengguna sudah login
        if (Auth::check()) {
            // Redirect ke dashboard berdasarkan role
            return $this->redirectToDashboard();
        }

        return view('pages.LandingPages.login'); // Tampilkan halaman login
    }

    public function indexRegister()
    {
        // Periksa apakah pengguna sudah login
        if (Auth::check()) {
            // Redirect ke dashboard berdasarkan role
            return $this->redirectToDashboard();
        }

        return view('pages.LandingPages.register'); // Tampilkan halaman registrasi
    }

    public function redirectToDashboard()
    {
        $user = Auth::user();

        // Redirect sesuai dengan role
        switch ($user->role) {
            case 'admin':
                return redirect('/Admin/Dashboard');
            case 'ahli pakar':
                return redirect('/ahli_pakar/Dashboard');
            case 'user':
                return redirect('/User/Dashboard');
            default:
                return redirect('/'); // Redirect default
        }
    }

    /**
     * Fungsi untuk registrasi akun baru
     */
    public function register(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:akun_pengguna,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:ahli pakar,user',
            'spesialis' => 'nullable|string|max:255',
            'nomor_telp' => 'nullable|string|max:15',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Maksimal 2MB
        ]);

        // Upload dokumen pendukung jika ada
        if ($request->hasFile('dokumen_pendukung')) {
            $filePath = $request->file('dokumen_pendukung')->store('dokumen_pendukung', 'public');
            $validatedData['dokumen_pendukung'] = $filePath;
        }

        // Tentukan nomor urut untuk user/ahli pakar
        if ($validatedData['role'] === 'ahli pakar') {
            $lastNoAhliPakar = AhliPakar::max('No');
            $nextNo = $lastNoAhliPakar ? $lastNoAhliPakar + 1 : 1;

            // Buat data ahli pakar
            $ahliPakar = AhliPakar::create([
                'No' => $nextNo,
                'kode_ahliPakar' => 'AP-' . strtoupper(uniqid()),
                'nama' => $validatedData['nama'],
                'nomor_telp' => $validatedData['nomor_telp'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'spesialis' => $validatedData['spesialis'],
                'dokumen_pendukung' => $validatedData['dokumen_pendukung'] ?? null,
            ]);

            // Tambahkan kode ke akun_pengguna
            $validatedData['kode_ahliPakar'] = $ahliPakar->kode_ahliPakar;
            $validatedData['kode_user'] = null;
        } else {
            $lastNoUser = Pengguna::max('No');
            $nextNo = $lastNoUser ? $lastNoUser + 1 : 1;

            // Buat data user
            $pengguna = Pengguna::create([
                'No' => $nextNo,
                'kode_user' => 'USR-' . strtoupper(uniqid()),
                'nama' => $validatedData['nama'],
                'nomor_telp' => $validatedData['nomor_telp'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Tambahkan kode ke akun_pengguna
            $validatedData['kode_user'] = $pengguna->kode_user;
            $validatedData['kode_ahliPakar'] = null;
        }

        // Tambahkan data ke tabel akun_pengguna
        $validatedData['No'] = AkunPengguna::max('No') + 1; // Nomor urut berikutnya
        AkunPengguna::create($validatedData);

        // Urutkan ulang data di tabel akun_pengguna
        $akunPengguna = AkunPengguna::orderBy('No', 'asc')->get();
        foreach ($akunPengguna as $index => $data) {
            $data->update(['No' => $index + 1]); // Update kolom No agar urut
        }

        // Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Registrasi berhasil!');
    }
    public function editProfile($kode_auth)
{
    $akunPengguna = Auth::user();

    if (!$akunPengguna || $akunPengguna->kode_auth !== $kode_auth) {
        return redirect()->route('login')->withErrors('Anda tidak memiliki akses ke profil ini.');
    }

    $userDetails = null;

    // Ambil data relasi berdasarkan role
    switch ($akunPengguna->role) {
        case 'user':
            $userDetails = Pengguna::where('kode_user', $akunPengguna->kode_user)->first();
            break;

        case 'ahli pakar':
            $userDetails = AhliPakar::where('kode_ahliPakar', $akunPengguna->kode_ahliPakar)->first();
            break;

        case 'admin':
            $userDetails = Admin::where('kode_admin', $akunPengguna->kode_admin)->first();
            break;

        default:
            return redirect()->route('login')->withErrors('Role pengguna tidak valid.');
    }

    if (!$userDetails) {
        return redirect()->route('login')->withErrors('Data pengguna tidak ditemukan.');
    }

    // Simpan URL halaman sebelumnya ke dalam session
    if (url()->previous() !== url()->current()) {
        session(['previous_url' => url()->previous()]);
    }

    // Kirim data ke view
    return view('components.settings', [
        'user' => $akunPengguna,
        'userDetails' => $userDetails,
        'nomorTelepon' => $userDetails->nomor_telp ?? '',
        'dokumenPendukung' => $userDetails->dokumen_pendukung ?? null,
        'spesialis' => $userDetails->spesialis ?? null, // Menambahkan spesialis
    ]);
}

    public function viewDokumen($fileName)
{
    $filePath = 'dokumen_pendukung/' . $fileName;

    // Periksa apakah file ada di disk publik
    if (!Storage::disk('public')->exists($filePath)) {
        abort(404, 'File tidak ditemukan.');
    }

    // Dapatkan path absolut file
    $file = Storage::disk('public')->path($filePath);

    // Tentukan MIME type secara otomatis untuk fleksibilitas
    $mimeType = Storage::disk('public')->mimeType($filePath);

    // Mengirim file PDF dengan header yang mencegah download otomatis
    return response()->file($file, [
        'Content-Type' => $mimeType, // Sesuaikan MIME type dengan file
        'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        'Cache-Control' => 'no-store, must-revalidate', // Mencegah caching
        'Pragma' => 'no-cache', // Tidak cache
        'Expires' => '0', // Waktu kadaluarsa
    ]);
}
    public function updateProfile(Request $request)
{
    // Ambil data pengguna yang sedang login
    $user = Auth::user();

    // Validasi input
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:akun_pengguna,email,' . $user->kode_auth . ',kode_auth',
        'password' => 'nullable|min:8|confirmed',
        'nomor_telp' => 'nullable|string|max:15',
        'spesialis' => 'nullable|string|max:255', // Relevan untuk ahli pakar
        'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi untuk dokumen pendukung (khusus ahli pakar)
    ]);

    // Hash password jika diisi
    $hashedPassword = $user->password;
    if ($request->filled('password')) {
        $hashedPassword = Hash::make($validatedData['password']);
    }

    // Update data di tabel `akun_pengguna`
    AkunPengguna::where('kode_auth', $user->kode_auth)->update([
        'nama' => $validatedData['nama'],
        'email' => $validatedData['email'],
        'password' => $hashedPassword,
    ]);

    // Update data di tabel spesifik berdasarkan role
    switch ($user->role) {
        case 'ahli pakar':
            $ahliPakar = AhliPakar::where('kode_ahliPakar', $user->kode_ahliPakar)->first();
            if ($ahliPakar) {
                // Proses upload dokumen pendukung jika ada
                if ($request->hasFile('dokumen_pendukung')) {
                    // Jika file lama ada, hapus file lama
                    if ($ahliPakar->dokumen_pendukung && file_exists(storage_path('app/public/' . $ahliPakar->dokumen_pendukung))) {
                        unlink(storage_path('app/public/' . $ahliPakar->dokumen_pendukung));
                    }
                    
                    // Simpan file baru
                    $file = $request->file('dokumen_pendukung');
                    $path = $file->store('dokumen_pendukung', 'public');
                    $validatedData['dokumen_pendukung'] = $path;
                } else {
                    // Jika tidak ada file yang diupload, biarkan file tetap null (atau file lama tetap digunakan)
                    $validatedData['dokumen_pendukung'] = $ahliPakar->dokumen_pendukung;
                }

                // Pastikan 'spesialis' ada dalam validated data
                $spesialis = $validatedData['spesialis'] ?? $ahliPakar->spesialis;

                // Update data ahli pakar
                $ahliPakar->update([
                    'nama' => $validatedData['nama'],
                    'email' => $validatedData['email'],
                    'nomor_telp' => $validatedData['nomor_telp'],
                    'spesialis' => $spesialis,
                    'password' => $hashedPassword,
                    'dokumen_pendukung' => $validatedData['dokumen_pendukung'],
                ]);
            }
            break;

        case 'user':
            $pengguna = Pengguna::where('kode_user', $user->kode_user)->first();
            if ($pengguna) {
                $pengguna->update([
                    'nama' => $validatedData['nama'],
                    'email' => $validatedData['email'],
                    'nomor_telp' => $validatedData['nomor_telp'],
                    'password' => $hashedPassword,
                ]);
            }
            break;

        case 'admin':
            $admin = Admin::where('kode_admin', $user->kode_admin)->first();
            if ($admin) {
                $admin->update([
                    'nama' => $validatedData['nama'],
                    'email' => $validatedData['email'],
                    'nomor_telp' => $validatedData['nomor_telp'],
                    'password' => $hashedPassword,
                ]);
            }
            break;

        default:
            return redirect()->route('login')->withErrors('Role pengguna tidak valid.');
    }

    return redirect()->route('profile.settings', ['kode_auth' => $user->kode_auth])
        ->with('success', 'Profil berhasil diperbarui!');
}




   public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Cari user di tabel akun_pengguna berdasarkan email
    $user = AkunPengguna::where('email', $credentials['email'])->first();

    if (!$user) {
        return back()->withErrors(['login' => 'Email tidak ditemukan.'])->onlyInput('email');
    }

    // Jika role adalah "ahli pakar", cek status di tabel user_pakar
    if ($user->role === 'ahli pakar') {
        // Cari data ahli pakar berdasarkan kode_ahliPakar
        $ahliPakar = DB::table('user_pakar')->where('kode_ahliPakar', $user->kode_ahliPakar)->first();

        if (!$ahliPakar || $ahliPakar->status !== 'active') {
            return back()->withErrors(['login' => 'Akun Anda belum disetujui oleh admin.'])->onlyInput('email');
        }
    }

    // Proses login biasa
    if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();
        // Simpan pesan sukses ke dalam session flash
        session()->flash('success', 'Login berhasil! Selamat datang, ' . $user->nama);

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'ahli pakar':
                return redirect()->intended('/ahli_pakar/Dashboard');
            case 'user':
                return redirect()->intended('/User/Dashboard');
            case 'admin':
                return redirect()->intended('/Admin/Dashboard');
            default:
                return redirect()->route('login')->withErrors(['login' => 'Role tidak dikenali.']);
        }
    }

    return back()->withErrors(['login' => 'Email atau password salah.']);
    // ->onlyInput('email') opsional
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
