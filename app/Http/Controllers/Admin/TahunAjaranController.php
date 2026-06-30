<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Tahun Ajaran';
        $query = TahunAjaran::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('tahun_mulai', 'like', "%{$search}%")
                  ->orWhere('tahun_selesai', 'like', "%{$search}%")
                  ->orWhere('semester', 'like', "%{$search}%");
        }

        $tahunAjaran = $query->latest()->paginate(10)->withQueryString();

        return view('admin.tahun_ajaran.index', compact('title', 'tahunAjaran'));
    }

    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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

        TahunAjaran::create($validated);

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

        $validated = $request->validate([
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

        $tahunAjaran->update($validated);

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
