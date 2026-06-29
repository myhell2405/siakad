<?php

namespace App\Http\Controllers;

use App\Models\TbUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('id_user')) {
            return $this->redirectByRole(session('role'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = TbUser::with('role')
            ->where('username', $request->username)
            ->first();

        if (! $user) {
            return back()->with('error', 'Username tidak ditemukan');
        }

        if ($user->status !== 'aktif') {
            return back()->with('error', 'Akun nonaktif');
        }

        if (! Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
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
                    if ($user->role_id != $walasRole->id_role) {
                        $user->update(['role_id' => $walasRole->id_role]);
                    }
                }
            } else {
                $roleName = 'guru';
                $guruRole = \App\Models\TbRole::where('nama_role', 'guru')->first();
                if ($guruRole) {
                    $permissions = is_string($guruRole->permissions) ? json_decode($guruRole->permissions, true) : ($guruRole->permissions ?? []);
                    if ($user->role_id != $guruRole->id_role) {
                        $user->update(['role_id' => $guruRole->id_role]);
                    }
                }
            }
        }

        session()->regenerate();

        session([
            'id_user' => $user->id_user,
            'username' => $user->username,
            'role' => $roleName,
            'ref_id' => $user->ref_id,
            'permissions' => $permissions,
        ]);

        return $this->redirectByRole($roleName);
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }

    private function redirectByRole($role)
    {
        if (in_array($role, ['admin', 'guru', 'wali_kelas', 'kepala_sekolah', 'siswa'])) {
            return redirect('/admin/dashboard');
        }

        return redirect('/login')->with('error', 'Role tidak dikenali');
    }
}
