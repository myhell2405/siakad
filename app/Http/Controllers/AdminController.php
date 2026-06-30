<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TbUser;

class AdminController extends Controller
{
    public function index()
    {
        $totalSiswa = \App\Models\Siswa::count();
        $totalGuru  = \App\Models\Guru::count();
        $totalKelas = \App\Models\Kelas::count();
        $totalMapel = \App\Models\Mapel::count();
        $totalEkskul = \App\Models\Ekskul::count();
        $totalWaliSiswa = \App\Models\WaliSiswa::count();
        $rasioSiswaGuru = $totalGuru > 0 ? round($totalSiswa / $totalGuru) : 0;

        $taAktif = \App\Models\TahunAjaran::where('status', 'aktif')->first() ?? \App\Models\TahunAjaran::latest('id_tahun_ajaran')->first();
        $queryKelas = \App\Models\KelasTahunAjaran::with(['kelas', 'waliKelas'])->withCount('siswaKelas');
        if ($taAktif) {
            $queryKelas->where('id_tahun_ajaran', $taAktif->id_tahun_ajaran);
        }
        $distribusiKelas = $queryKelas->take(6)->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'totalEkskul',
            'totalWaliSiswa',
            'rasioSiswaGuru',
            'distribusiKelas',
            'taAktif'
        ));
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
