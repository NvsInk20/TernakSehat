<?php

namespace App\Http\Controllers;

use App\Models\AkunPengguna;
use App\Models\AhliPakar;
use App\Models\admin;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PakarController extends Controller
{

    public function showPakars(Request $request)
{
    // Periksa apakah pengguna memiliki role "admin"
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.'); // Tampilkan error jika bukan admin
    }

    // Mulai query dari model Pengguna
    $queryPakar = AhliPakar::query();

    // Menambahkan logika pencarian
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $queryPakar->where('kode_user', 'like', "%{$search}%")
            ->orWhere('nama', 'like', "%{$search}%");
    }

    // Lakukan paginasi untuk hasil query
    $pakars = $queryPakar->orderBy('No', 'asc')->paginate(10);

    // Kirim data ke view
    return view('pages.AdminPages.tabelPakar', [
        'title' => 'Kelola Pengguna',
        'pakars' => $pakars,
    ]);
}

    
    public function editPakar($role, $kode)
{
    $userDetails = null;

    // Cek apakah role adalah 'ahli pakar' atau 'user' dan ambil data yang sesuai
    if ($role === 'ahli pakar') {
        $userDetails = AhliPakar::where('kode_ahliPakar', $kode)->first();
    } elseif ($role === 'user') {
        $userDetails = Pengguna::where('kode_user', $kode)->first();
    }

    // Jika tidak ditemukan data untuk kode yang diberikan, redirect dengan error
    if (!$userDetails) {
        return redirect()->route('admin.pakar')->withErrors('Data ahli pakar tidak ditemukan.');
    }

    // Menyimpan URL sebelumnya jika halaman sebelumnya berbeda
    if (!session()->has('previous_url') && url()->previous() !== url()->current()) {
        session(['previous_url' => url()->previous()]);
    }

    // Mengembalikan view dengan data pengguna
    return view('pages.AdminPages.CRUD.crud_pakar.editPakar', [
        'ahli pakar' => $userDetails,
        'role' => $role,
        'nomorTelepon' => $userDetails->nomor_telp ?? null,
    ]);
}

    public function update(Request $request, $role, $kode)
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
    public function deletePakar($kode_ahliPakar)
{
    // Periksa apakah pengguna memiliki role "admin"
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    // Cari data pengguna berdasarkan kode_user
    $pakar = AhliPakar::where('kode_ahliPakar', $kode_ahliPakar)->first();

    if (!$pakar) {
        return redirect()->route('admin.pakars')->withErrors('Ahli Pakar tidak ditemukan.');
    }

    // Hapus data pengguna
    $pakar->delete();

    // Hapus juga data relasinya di tabel akun_pengguna (opsional, jika ada)
    AkunPengguna::where('kode_ahliPakar', $kode_ahliPakar)->delete();

    return redirect()->route('admin.pakars')->with('success', 'Ahli Pakar berhasil dihapus.');
}


    public function approveAhliPakar($kode_ahliPakar)
{


    $ahliPakar = AhliPakar::where('kode_ahliPakar', $kode_ahliPakar)->where('role', 'ahli pakar')->first();

    if (!$ahliPakar) {
        return redirect()->back()->withErrors('Ahli pakar tidak ditemukan.');
    }

    // Berikan persetujuan dengan memberikan password default (atau gunakan cara lain)
    $ahliPakar->update([
        'password' => Hash::make('password123'), // Password default
    ]);

    return redirect()->back()->with('success', 'Ahli pakar telah disetujui.');
}



    public function toggleStatus($kode_ahliPakar)
{


    $pakar = AhliPakar::where('kode_ahliPakar', $kode_ahliPakar)->first();
    
    if (!$pakar) {
        return redirect()->back()->with('error', 'Data pakar tidak ditemukan.');
    }
    
    // Toggle status
    $pakar->status = $pakar->status === 'active' ? 'inactive' : 'active';
    $pakar->save();
    
    $message = $pakar->status === 'active' ? 'Akses login ahli pakar telah diaktifkan.' : 'Akses login ahli pakar telah dinonaktifkan.';
    return redirect()->back()->with('success', $message);
}
}
