<?php

namespace App\Http\Controllers;

use App\Models\AkunPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function editProfile()
{
    // Ambil data pengguna yang sedang login
    $user = Auth::user();

    // Kirim data pengguna ke halaman edit profil
    return view('pages.UserPages.settings', compact('user'));
}

public function updateProfile(Request $request)
{
    // Ambil data pengguna yang sedang login
    $user = Auth::user();

    // Validasi data yang dimasukkan
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:akun_pengguna,email,' . $user->id, // Validasi email dengan pengecualian untuk pengguna yang sama
        'password' => 'nullable|min:8|confirmed', // Validasi password jika diubah
        'spesialis' => 'nullable|string|max:255',
    ]);

    // Update data pengguna
    $user->nama = $request->input('nama');
    $user->email = $request->input('email');
    $user->spesialis = $request->input('spesialis');

    // Jika password diubah, hash password baru
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    // Simpan perubahan ke database
    $user->save();

    // Redirect ke halaman pengaturan profil dengan pesan sukses
    return redirect()->route('profile.settings')
                     ->with('success', 'Profil berhasil diperbarui!');
}




    public function register(Request $request)
    {
        // Validasi data registrasi
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:akun_pengguna,email',
            'password' => 'required|min:8|confirmed',
            'role' => ['required', Rule::in(['ahli pakar', 'user'])],
            'spesialis' => 'nullable|string|max:255',
        ]);

        // Hash password sebelum disimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Buat akun pengguna baru
        AkunPengguna::create($validatedData);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
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