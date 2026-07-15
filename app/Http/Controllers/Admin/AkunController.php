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
            $roleId = $request->role_id;
            $role = TbRole::find($roleId);
            $guruRoleId = TbRole::where('nama_role', 'guru')->value('id_role') ?? 2;

            if ($role && $role->nama_role === 'wali_kelas') {
                $query->where(function ($q) use ($roleId, $guruRoleId) {
                    $q->where('role_id', $roleId)
                      ->orWhere(function ($subq) use ($guruRoleId) {
                          $subq->where('role_id', $guruRoleId)
                               ->whereHas('guru', function ($g) {
                                   $g->whereIn('id', \App\Models\KelasTahunAjaran::select('id_wali_kelas')->whereNotNull('id_wali_kelas'));
                               });
                      });
                });
            } elseif ($role && $role->nama_role === 'guru') {
                $query->where('role_id', $roleId)
                      ->whereDoesntHave('guru', function ($g) {
                          $g->whereIn('id', \App\Models\KelasTahunAjaran::select('id_wali_kelas')->whereNotNull('id_wali_kelas'));
                      });
            } else {
                $query->where('role_id', $roleId);
            }
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

        $gurus = Guru::whereRaw('LOWER(status) = ?', ['aktif'])->get();
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

    /**
     * Login menggunakan akun pengguna lain (Impersonate).
     */
    public function impersonate($id)
    {
        // Simpan id_user admin asli jika belum ada dalam sesi impersonasi
        if (!session()->has('impersonator_id')) {
            session(['impersonator_id' => session('id_user')]);
        }

        $user = TbUser::with('role')->findOrFail($id);

        if ($user->status !== 'aktif') {
            return back()->with('error', 'Akun yang dipilih sedang nonaktif!');
        }

        $roleName = $user->role->nama_role;
        $permissions = is_string($user->role->permissions) ? json_decode($user->role->permissions, true) : ($user->role->permissions ?? []);

        if (in_array($roleName, ['guru', 'wali_kelas']) && $user->ref_id) {
            $isWaliKelas = \App\Models\KelasTahunAjaran::where('id_wali_kelas', $user->ref_id)->exists();
            if ($isWaliKelas) {
                $roleName = 'wali_kelas';
                $walasRole = \App\Models\TbRole::where('nama_role', 'wali_kelas')->first();
                if ($walasRole) {
                    $walasPerms = is_string($walasRole->permissions) ? json_decode($walasRole->permissions, true) : ($walasRole->permissions ?? []);
                    $permissions = array_values(array_unique(array_merge($permissions, $walasPerms)));
                }
            } else {
                $roleName = 'guru';
                $guruRole = \App\Models\TbRole::where('nama_role', 'guru')->first();
                if ($guruRole) {
                    $permissions = is_string($guruRole->permissions) ? json_decode($guruRole->permissions, true) : ($guruRole->permissions ?? []);
                }
            }
        }

        session([
            'id_user' => $user->id_user,
            'username' => $user->username,
            'role' => $roleName,
            'ref_id' => $user->ref_id,
            'permissions' => $permissions,
        ]);

        return redirect('/admin/dashboard')->with('success', "Berhasil login sebagai akun: {$user->username} ({$roleName})");
    }

    /**
     * Kembali ke akun asli admin (Unimpersonate).
     */
    public function unimpersonate()
    {
        if (!session()->has('impersonator_id')) {
            return redirect('/admin/dashboard');
        }

        $originalId = session('impersonator_id');
        $admin = TbUser::with('role')->findOrFail($originalId);

        $roleName = $admin->role->nama_role;
        $permissions = is_string($admin->role->permissions) ? json_decode($admin->role->permissions, true) : ($admin->role->permissions ?? []);

        session([
            'id_user' => $admin->id_user,
            'username' => $admin->username,
            'role' => $roleName,
            'ref_id' => $admin->ref_id,
            'permissions' => $permissions,
        ]);

        session()->forget('impersonator_id');

        return redirect('/admin/akun')->with('success', "Berhasil kembali ke akun asli administrator: {$admin->username}");
    }
}
