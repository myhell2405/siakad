<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $title = 'Data Tahun Ajaran';
        $tahunAjaran = TahunAjaran::latest()->paginate(10);

        return view('admin.tahun_ajaran.index', compact('title', 'tahunAjaran'));
    }

    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_mulai' => 'required',
            'tahun_selesai' => 'required',
            'semester' => 'required',
            'status' => 'required',
        ]);

        if ($request->status == 'aktif') {
            TahunAjaran::where('status', 'aktif')->update([
                'status' => 'tidak_aktif',
            ]);
        }

        TahunAjaran::create($request->validated());

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        return view('admin.tahun_ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $request->validate([
            'tahun_mulai' => 'required',
            'tahun_selesai' => 'required',
            'semester' => 'required',
            'status' => 'required',
        ]);

        if ($request->status == 'aktif') {
            TahunAjaran::where('status', 'aktif')->update([
                'status' => 'tidak_aktif',
            ]);
        }

        $tahunAjaran->update($request->validated());

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete();

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus');
    }
}
