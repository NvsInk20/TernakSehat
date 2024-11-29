<?php

namespace App\Http\Controllers;

use App\Models\AkunPengguna;
use App\Models\AhliPakar;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function indexLogin()
    {
        return view('pages.LandingPages.login', [
            'title' => 'Login',
            'active' => 'login',
        ]);
    }

    public function indexRegister()
    {
        return view('pages.LandingPages.register', [
            'title' => 'Register',
            'active' => 'register',
        ]);
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
    ]);

    // Ambil nomor urut terakhir dari database
    $lastNo = AkunPengguna::max('No'); // Ambil nilai tertinggi dari kolom No
    $nextNo = $lastNo ? $lastNo + 1 : 1; // Jika ada data, tambahkan 1, jika tidak mulai dari 1

    // Tambahkan No ke data validasi
    $validatedData['No'] = $nextNo;
    $validatedData['password'] = Hash::make($validatedData['password']); // Enkripsi password

    // Simpan ke tabel relasi berdasarkan role
    if ($validatedData['role'] === 'ahli pakar') {
        // Buat data ahli pakar
        $ahliPakar = AhliPakar::create([
            'No' => $validatedData['No'],
            'kode_ahliPakar' => 'AP-' . strtoupper(uniqid()), // Generate kode_ahliPakar
            'nama' => $validatedData['nama'],
            'nomor_telp' => $validatedData['nomor_telp'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'spesialis' => $validatedData['spesialis'],
        ]);

        // Tambahkan kode_ahliPakar ke data akun_pengguna
        $validatedData['kode_ahliPakar'] = $ahliPakar->kode_ahliPakar;
        $validatedData['kode_user'] = null; // Karena bukan user biasa
    } else {
        // Buat data user
        $pengguna = Pengguna::create([
            'No' => $validatedData['No'],
            'kode_user' => 'USR-' . strtoupper(uniqid()), // Generate kode_user
            'nama' => $validatedData['nama'],
            'nomor_telp' => $validatedData['nomor_telp'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);

        // Tambahkan kode_user ke data akun_pengguna
        $validatedData['kode_user'] = $pengguna->kode_user;
        $validatedData['kode_ahliPakar'] = null; // Karena bukan ahli pakar
    }

    // Simpan data ke tabel akun_Pengguna
    AkunPengguna::create($validatedData);

    // Redirect ke halaman login dengan pesan sukses
    return redirect()->route('login')->with('success', 'Registrasi berhasil!');
}


    public function editProfile()
{
    // Ambil data pengguna yang sedang login
    $user = Auth::user();

    // Jika pengguna memiliki role 'user', ambil data nomor telepon dari tabel relasi
    if ($user->role === 'user') {
        $userDetails = Pengguna::where('kode_user', $user->kode_user)->first();
    } elseif ($user->role === 'ahli pakar') {
        $userDetails = AhliPakar::where('kode_ahliPakar', $user->kode_ahliPakar)->first();
    } else {
        $userDetails = null;
    }

    // Kirim data ke view
    return view('pages.UserPages.settings', [
        'user' => $user,
        'userDetails' => $userDetails, // Relasi detail user
    ]);
}


    public function updateProfile(Request $request)
{
    // Ambil pengguna yang sedang login
    $user = Auth::user();

    // Validasi input
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255', // Hapus validasi unique di sini
        'password' => 'nullable|min:8|confirmed',
        'nomor_telp' => 'nullable|string|max:255',
        'spesialis' => 'nullable|string|max:255',
    ]);

    // Update data pengguna utama
    $user->nama = $validatedData['nama'];
    $user->email = $validatedData['email'];

    // Jika password diisi, lakukan hashing
    if ($request->filled('password')) {
        $user->password = Hash::make($validatedData['password']);
    }

    $user->save();

    // Update tabel relasi berdasarkan role
    if ($user->role === 'ahli pakar') {
        // Update data di tabel ahli pakar
        $ahliPakar = AhliPakar::where('kode_ahliPakar', $user->kode_ahliPakar)->first();
        if ($ahliPakar) {
            $ahliPakar->update([
                'nama' => $validatedData['nama'],
                'email' => $validatedData['email'],
                'nomor_telp' => $validatedData['nomor_telp'], // Update nomor telepon
                'spesialis' => $validatedData['spesialis'],
            ]);
        }
    } elseif ($user->role === 'user') {
        // Update data di tabel pengguna
        $pengguna = Pengguna::where('kode_user', $user->kode_user)->first();
        if ($pengguna) {
            $pengguna->update([
                'nama' => $validatedData['nama'],
                'email' => $validatedData['email'],
                'nomor_telp' => $validatedData['nomor_telp'], // Update nomor telepon
            ]);
        }
    }

    return redirect()->route('profile.settings')->with('success', 'Profil berhasil diperbarui!');
}


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userRole = Auth::user()->role;
            if ($userRole === 'ahli pakar') {
                return redirect()->intended('/LandingPage');
            } elseif ($userRole === 'user') {
                return redirect()->intended('/User/Dashboard');
            } elseif ($userRole === 'admin') {
                return redirect()->intended('/Admin/Dashboard');
            } else {
                return redirect()->intended('/Register');
            }
        }

        return back()->withErrors([
            'login' => 'Email atau Password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
