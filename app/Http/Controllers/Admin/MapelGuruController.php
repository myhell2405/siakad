<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelGuruController extends Controller
{
    public function index($id_mapel)
    {
        $mapel = Mapel::findOrFail($id_mapel);

        $guruMapel = $mapel->guru;

        $enrolledGuruIds = $guruMapel->pluck('id');
        $availableGuru = Guru::whereNotIn('id', $enrolledGuruIds)
            ->where('status', 'Aktif')
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.mapel.gurumapel', compact('mapel', 'guruMapel', 'availableGuru'));
    }

    public function store(Request $request, $id_mapel)
    {
        $request->validate([
            'id_guru' => 'required|exists:tb_guru,id',
        ]);

        $exists = GuruMapel::where('id_guru', $request->id_guru)
            ->where('id_mapel', $id_mapel)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Guru sudah terdaftar di mapel ini');
        }

        GuruMapel::create([
            'id_guru' => $request->id_guru,
            'id_mapel' => $id_mapel,
        ]);

        return back()->with('success', 'Guru berhasil ditambahkan');
    }

    public function destroy($id_mapel, $id_guru)
    {
        GuruMapel::where('id_mapel', $id_mapel)
            ->where('id_guru', $id_guru)
            ->delete();

        return back()->with('success', 'Guru berhasil dihapus');
    }
}
