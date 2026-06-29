<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TbRole;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Tampilkan matriks role dan hak akses.
     */
    public function index()
    {
        $roles = TbRole::withCount('users')->orderBy('id_role')->get();

        return view('admin.role.index', compact('roles'));
    }

    /**
     * Update hak akses (permissions) role.
     */
    public function update(Request $request, $id)
    {
        $role = TbRole::findOrFail($id);
        
        $role->update([
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.role.index')->with('success', 'Hak akses untuk role ' . strtoupper($role->nama_role) . ' berhasil diperbarui!');
    }
}
