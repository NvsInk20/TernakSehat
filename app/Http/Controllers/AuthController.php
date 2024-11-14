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

    public function editProfile($id)
    {
        $user = Auth::user();

        // Pastikan hanya pengguna yang sedang login yang bisa mengedit profilnya sendiri
        if (!$user || $user->id != $id) {
            return redirect()->route('profile.settings', ['id' => $user->id])
                             ->with('error', 'Anda tidak memiliki akses untuk mengedit profil ini.');
        }

        return view('pages.UserPages.settings', compact('user'));
    }

    public function updateProfile(Request $request, $id)
{
    // Cari data pengguna berdasarkan ID
    $user = AkunPengguna::findOrFail($id);

    // Validasi data yang dimasukkan
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:akun_pengguna,email,' . $id, // Pastikan email bisa diperbarui jika sama
        'password' => 'nullable|min:8|confirmed', // Validasi password jika diubah
        'role' => 'required|string', // Anda bisa menambahkan role validasi lebih lanjut
        'spesialis' => 'nullable|string|max:255',
    ]);

    // Update data pengguna
    $user->nama = $request->input('nama');
    $user->email = $request->input('email');
    $user->role = $request->input('role');
    $user->spesialis = $request->input('spesialis');

    // Jika password diubah, hash password baru
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    // Simpan perubahan ke database
    $user->save();

    // Redirect ke halaman pengaturan profil dengan pesan sukses
    return redirect()->route('profile.settings', ['id' => $user->id])
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}