<?php

namespace App\Http\Controllers;

use App\Models\AkunPengguna;
use App\Models\AhliPakar;
use App\Models\admin;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{

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

    return view('pages.AdminPages.CRUD.crud_user.editUser', [
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
        'username' => 'required|username|max:255|unique:' . ($role === 'user' ? 'user_pengguna' : 'user_ahli') . ',username,' . $kode . ',' . ($role === 'user' ? 'kode_user' : 'kode_ahliPakar'),
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
        'username' => $validatedData['username'],
        'password' => $hashedPassword, // Pastikan hash password yang sama
    ]);

    // Update tabel sesuai role dengan hash password yang sama
    if ($role === 'user') {
        // Update data di tabel `user_pengguna`
        $userDetails->update([
            'nama' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'nomor_telp' => $validatedData['nomor_telp'],
            'password' => $hashedPassword, // Gunakan password yang sama di tabel user_pengguna
        ]);
    } elseif ($role === 'ahli pakar') {
        // Update data di tabel `user_ahli`
        $userDetails->update([
            'nama' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'nomor_telp' => $validatedData['nomor_telp'],
            'spesialis' => $validatedData['spesialis'],
            'password' => $hashedPassword, // Gunakan password yang sama di tabel user_ahli
        ]);
    }

    // Redirect ke halaman daftar pengguna dengan pesan sukses
    return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui.');
}
}
