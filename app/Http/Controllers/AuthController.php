<?php

namespace App\Http\Controllers;

use App\Models\AkunPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function indexLogin()
    {
        return view('pages.LandingPages.login', [
            'title' => 'Login',
            'active' => 'login',
        ]);
    }

    /**
     * Menampilkan halaman registrasi.
     */
    public function indexRegister()
    {
        return view('pages.LandingPages.register', [
            'title' => 'Register',
            'active' => 'register',
        ]);
    }

    /**
     * Menampilkan halaman untuk mengedit profil pengguna.
     */
    public function editProfile($id)
    {
        $user = AkunPengguna::findOrFail($id);   // Mengambil data pengguna yang sedang login
        return view('pages.UserPages.settings', compact('user')); // Mengirimkan data pengguna ke halaman settings
    }

    /**
     * Proses memperbarui data profil pengguna.
     */
    public function updateProfile(Request $request, $id)
    {
    // Mendapatkan data pengguna yang sedang login
    $user = AkunPengguna::findOrFail($id);  // Mengambil user berdasarkan ID yang sedang login

    // Validasi data input
     $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:akun_Pengguna,email',
        'password' => 'required|min:8|confirmed',
        'role' => ['required', Rule::in(['ahli pakar', 'user'])],
        'spesialis' => 'nullable|string|max:255',
    ]);

    // Mengupdate data nama dan email pengguna
    $user->nama = $request->input('nama');
    $user->email = $request->input('email');
    $user->password = $request->input('password');
    $user->role = $request->input('role');
    $user->spesialis = $request->input('spesialis');

    // Jika password diisi, update password setelah enkripsi
    if (!empty($validatedData['password'])) {
        $user->password = Hash::make($validatedData['password']);
    }

    // Simpan perubahan ke dalam database
    $user->save();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('pages.UserPages.settings')->with('success', 'Profil berhasil diperbarui.');
}

    /**
     * Proses registrasi pengguna baru.
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:akun_Pengguna,email',
            'password' => 'required|min:8|confirmed',
            'role' => ['required', Rule::in(['ahli pakar', 'user'])],
            'spesialis' => 'nullable|string|max:255',
        ]);

        // Enkripsi password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan data ke dalam tabel akun_Pengguna
        AkunPengguna::create([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'role' => $validatedData['role'],
            'spesialis' => $validatedData['spesialis'] ?? null,
        ]);
        return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    /**
     * Proses autentikasi pengguna.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan peran
            $userRole = Auth::user()->role;
            if ($userRole === 'ahli pakar') {
                return redirect()->intended('/LandingPage');
            } elseif ($userRole === 'user') {
                return redirect()->intended('/User/Dashboard');
            } else {
                return redirect()->intended('/Register');
            }
        }

        return back()->withErrors([
            'login' => 'Email atau Password tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}