<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TbUser;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function profil()
    {
        $user = TbUser::with(['role', 'guru', 'siswa'])->find(session('id_user'));
        return view('admin.profil', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:4|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 4 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = TbUser::find(session('id_user'));

        if (!$user) {
            return back()->with('error', 'Akun pengguna tidak ditemukan.');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini yang Anda masukkan salah.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password Anda berhasil diperbarui!');
    }
}
