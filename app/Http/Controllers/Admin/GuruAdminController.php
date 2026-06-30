<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruAdminController extends Controller
{
    /* =========================
     | INDEX
     ========================= */
    public function index(Request $request)
    {
        $query = Guru::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%");
            });
        }

        $guru = $query->orderBy('nama_lengkap', 'asc')->paginate(10)->withQueryString();

        return view('admin.guru.index', [
            'title' => 'Data Guru',
            'guru' => $guru,
        ]);
    }

    /* =========================
     | CREATE
     ========================= */
    public function create()
    {
        return view('admin.guru.create', [
            'title' => 'Tambah Data Pendidik Baru',
        ]);
    }

    /* =========================
     | STORE
     ========================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:tb_guru,nip',
            'nuptk' => 'nullable|string|max:20',
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'jabatan_guru' => 'nullable|string|max:50',
            'pangkat_gol' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',

            'provinsi' => 'nullable|string|max:100',
            'kab_kota' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kenagarian' => 'nullable|string|max:100',

            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Guru::create($validated);

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan');
    }

    /* =========================
     | EDIT
     ========================= */
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);

        return view('admin.guru.edit', [
            'title' => 'Edit Data Pendidik: ' . ($guru->nama_lengkap ?? ''),
            'guru' => $guru,
        ]);
    }

    /* =========================
     | UPDATE
     ========================= */
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:tb_guru,nip,'.$id,
            'nuptk' => 'nullable|string|max:20',
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'jabatan_guru' => 'nullable|string|max:50',
            'pangkat_gol' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',

            'provinsi' => 'nullable|string|max:100',
            'kab_kota' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kenagarian' => 'nullable|string|max:100',

            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $guru->update($validated);

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui');
    }

    /* =========================
     | DELETE
     ========================= */
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus');
    }
}
