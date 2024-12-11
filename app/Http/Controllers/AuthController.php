<?php

namespace App\Http\Controllers;

use App\Models\AkunPengguna;
use App\Models\AhliPakar;
use App\Models\admin;
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

    // **Periksa dan urutkan ulang data di tabel akun_pengguna**
    $validatedData['No'] = AkunPengguna::max('No') + 1; // Nomor urut berikutnya
    AkunPengguna::create($validatedData);

    // **Urutkan ulang data setelah menambahkan yang baru**
    $akunPengguna = AkunPengguna::orderBy('No', 'asc')->get(); // Urutkan berdasarkan created_at
    foreach ($akunPengguna as $index => $data) {
        $data->update(['No' => $index + 1]); // Update kolom No agar urut
    }

    // Redirect ke halaman login
    return redirect()->route('login')->with('success', 'Registrasi berhasil!');
}

    public function showUsers(Request $request)
{
    // Periksa apakah pengguna memiliki role "admin"
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.'); // Tampilkan error jika bukan admin
    }

    // Mulai query dari model Pengguna
    $query = Pengguna::query();

    // Menambahkan logika pencarian
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->where('kode_user', 'like', "%{$search}%")
            ->orWhere('nama', 'like', "%{$search}%");
    }

    // Lakukan paginasi untuk hasil query
    $users = $query->orderBy('No', 'asc')->paginate(10);

    // Kirim data ke view
    return view('pages.AdminPages.tabelUser', [
        'title' => 'Kelola Pengguna',
        'users' => $users,
    ]);
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
                    $ahliPakar->update([
                        'nama' => $validatedData['nama'],
                        'email' => $validatedData['email'],
                        'nomor_telp' => $validatedData['nomor_telp'],
                        'spesialis' => $validatedData['spesialis'],
                        'password' => $hashedPassword,
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

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $userRole = Auth::user()->role;
            switch ($userRole) {
                case 'ahli pakar':
                    return redirect()->intended('/ahli_pakar/Dashboard');
                case 'user':
                    return redirect()->intended('/User/Dashboard');
                case 'admin':
                    return redirect()->intended('/Admin/Dashboard');
                default:
                    return redirect()->route('login')->withErrors('Role tidak dikenali.');
            }
        }

        return back()->withErrors(['login' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function deleteUser($kode_user)
{
    // Periksa apakah pengguna memiliki role "admin"
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    // Cari data pengguna berdasarkan kode_user
    $user = Pengguna::where('kode_user', $kode_user)->first();

    if (!$user) {
        return redirect()->route('admin.users')->withErrors('Pengguna tidak ditemukan.');
    }

    // Hapus data pengguna
    $user->delete();

    // Hapus juga data relasinya di tabel akun_pengguna (opsional, jika ada)
    AkunPengguna::where('kode_user', $kode_user)->delete();

    return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
}


    public function editUser($role, $kode)
{
    $userDetails = null;

    if ($role === 'user') {
        $userDetails = Pengguna::where('kode_user', $kode)->first();
    } elseif ($role === 'ahli pakar') {
        $userDetails = AhliPakar::where('kode_ahliPakar', $kode)->first();
    }

    if (!$userDetails) {
        return redirect()->route('admin.users')->withErrors('Data pengguna tidak ditemukan.');
    }

    if (url()->previous() !== url()->current()) {
        session(['previous_url' => url()->previous()]);
    }

    return view('pages.AdminPages.editUser', [
        'user' => $userDetails,
        'role' => $role,
        'nomorTelepon' => $userDetails->nomor_telp ?? null,
    ]);
}
    public function updateUser(Request $request, $role, $kode)
{
    // Memastikan pengguna adalah admin
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    // Validasi data
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:' . ($role === 'user' ? 'user_pengguna' : 'user_ahli') . ',email,' . $kode . ',' . ($role === 'user' ? 'kode_user' : 'kode_ahliPakar'),
        'password' => 'nullable|min:8|confirmed',
        'nomor_telp' => 'nullable|string|max:15',
        'spesialis' => 'nullable|string|max:255', // Khusus untuk ahli pakar
    ]);

    // Cari data berdasarkan role
    $userDetails = null;
    if ($role === 'user') {
        $userDetails = Pengguna::where('kode_user', $kode)->first();
    } elseif ($role === 'ahli pakar') {
        $userDetails = AhliPakar::where('kode_ahliPakar', $kode)->first();
    }

    // Jika data tidak ditemukan
    if (!$userDetails) {
        return redirect()->route('admin.users')->withErrors('Data pengguna tidak ditemukan.');
    }

    // Hash password jika diisi, gunakan password lama jika tidak diisi
    $hashedPassword = $userDetails->password;
    if ($request->filled('password')) {
        $hashedPassword = Hash::make($validatedData['password']);
    }

    // Update data di tabel `akun_pengguna` dengan hash password yang sama
    AkunPengguna::where('kode_user', $userDetails->kode_user ?? $userDetails->kode_ahliPakar)->update([
        'nama' => $validatedData['nama'],
        'email' => $validatedData['email'],
        'password' => $hashedPassword, // Pastikan hash password yang sama
    ]);

    // Update tabel sesuai role dengan hash password yang sama
    if ($role === 'user') {
        // Update data di tabel `user_pengguna`
        $userDetails->update([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'nomor_telp' => $validatedData['nomor_telp'],
            'password' => $hashedPassword, // Gunakan password yang sama di tabel user_pengguna
        ]);
    } elseif ($role === 'ahli pakar') {
        // Update data di tabel `user_ahli`
        $userDetails->update([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'nomor_telp' => $validatedData['nomor_telp'],
            'spesialis' => $validatedData['spesialis'],
            'password' => $hashedPassword, // Gunakan password yang sama di tabel user_ahli
        ]);
    }

    // Redirect ke halaman daftar pengguna dengan pesan sukses
    return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui.');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
