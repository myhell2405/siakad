<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\TbRole;
use App\Models\TbUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    /**
     * Tampilkan daftar akun pengguna.
     */
    public function index(Request $request)
    {
        $query = TbUser::with(['role', 'guru', 'siswa'])->orderBy('id_user', 'desc');

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhereHas('guru', function ($g) use ($search) {
                      $g->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('siswa', function ($s) use ($search) {
                      $s->where('nama_siswa', 'like', "%{$search}%");
                  });
            });
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = TbRole::all();

        return view('admin.akun.index', compact('users', 'roles'));
    }

    /**
     * Tambah akun manual.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:tb_user,username',
            'password' => 'required|string|min:4',
            'role_id'  => 'required|exists:tb_role,id_role',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        TbUser::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
            'ref_id'   => $request->ref_id ?: null,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.akun.index')->with('success', 'Akun pengguna berhasil dibuat!');
    }

    /**
     * Edit akun manual.
     */
    public function update(Request $request, $id)
    {
        $user = TbUser::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:50|unique:tb_user,username,' . $id . ',id_user',
            'role_id'  => 'required|exists:tb_role,id_role',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        $data = [
            'username' => $request->username,
            'role_id'  => $request->role_id,
            'ref_id'   => $request->ref_id ?: null,
            'status'   => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.akun.index')->with('success', 'Data akun berhasil diperbarui!');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy($id)
    {
        if (session('id_user') == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
        }

        $user = TbUser::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.akun.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }

    /**
     * Reset password ke default (1234).
     */
    public function resetPassword($id)
    {
        $user = TbUser::findOrFail($id);
        $user->update([
            'password' => Hash::make('1234'),
        ]);

        return redirect()->back()->with('success', "Password untuk akun {$user->username} berhasil direset menjadi '1234'!");
    }

    /**
     * Generate otomatis akun Guru dari tb_guru.
     */
    public function generateGuru()
    {
        $guruRole = TbRole::where('nama_role', 'guru')->first();
        $waliKelasRole = TbRole::where('nama_role', 'wali_kelas')->first();

        if (!$guruRole) {
            return redirect()->route('admin.akun.index')->with('error', 'Role guru tidak ditemukan di database.');
        }

        $gurus = Guru::where('status', 'Aktif')->get();
        $created = 0;

        foreach ($gurus as $guru) {
            if (!$guru->nip) continue;

            $exists = TbUser::where('username', $guru->nip)->exists();
            if (!$exists) {
                $isWaliKelas = $waliKelasRole && \App\Models\KelasTahunAjaran::where('id_wali_kelas', $guru->id)->exists();
                $roleId = $isWaliKelas ? $waliKelasRole->id_role : $guruRole->id_role;

                TbUser::create([
                    'username' => $guru->nip,
                    'password' => Hash::make('1234'),
                    'role_id'  => $roleId,
                    'ref_id'   => $guru->id,
                    'status'   => 'aktif',
                ]);
                $created++;
            }
        }

        return redirect()->route('admin.akun.index')->with('success', "Berhasil me-generate {$created} akun login untuk Guru (Password default: 1234)!");
    }

    /**
     * Generate otomatis akun Siswa dari tb_siswa.
     */
    public function generateSiswa()
    {
        $siswaRole = TbRole::where('nama_role', 'siswa')->first();

        if (!$siswaRole) {
            return redirect()->route('admin.akun.index')->with('error', 'Role siswa tidak ditemukan di database.');
        }

        $siswas = Siswa::all();
        $created = 0;

        foreach ($siswas as $siswa) {
            if (!$siswa->nisn) continue;

            $exists = TbUser::where('username', $siswa->nisn)->exists();
            if (!$exists) {
                TbUser::create([
                    'username' => $siswa->nisn,
                    'password' => Hash::make('1234'),
                    'role_id'  => $siswaRole->id_role,
                    'ref_id'   => $siswa->id,
                    'status'   => 'aktif',
                ]);
                $created++;
            }
        }

        return redirect()->route('admin.akun.index')->with('success', "Berhasil me-generate {$created} akun login untuk Siswa (Password default: 1234)!");
    }
}
