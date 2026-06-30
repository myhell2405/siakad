<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        $title = 'Data Mapel';
        $query = Mapel::with('guru');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_mapel', 'like', "%{$search}%");
        }

        $mapel = $query->latest()->paginate(10)->withQueryString();

        return view('admin.mapel.index', compact('title', 'mapel'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.mapel.create');
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
            'kkm' => 'required|integer|min:0|max:100',
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
            'kkm' => $request->kkm,
        ]);

        return redirect()
            ->route('admin.mapel.index')
            ->with('success', 'Data mapel berhasil ditambahkan');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);

        return view('admin.mapel.edit', compact('mapel'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $request->validate([
            'nama_mapel' => 'required|string|max:100',
            'kkm' => 'required|integer|min:0|max:100',
        ]);

        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
            'kkm' => $request->kkm,
        ]);

        return redirect()
            ->route('admin.mapel.index')
            ->with('success', 'Data mapel berhasil diperbarui');
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()
            ->route('admin.mapel.index')
            ->with('success', 'Data mapel berhasil dihapus');
    }
}
