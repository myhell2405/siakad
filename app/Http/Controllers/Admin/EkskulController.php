<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Models\Guru;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ekskul::with('guru');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_ekskul', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
        }

        $ekskul = $query->orderBy('nama_ekskul')->paginate(10)->withQueryString();

        return view('admin.ekskul.index', [
            'title' => 'Data Ekstrakurikuler',
            'ekskul' => $ekskul,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Guru::orderBy('nama_lengkap')->get();

        return view('admin.ekskul.create', [
            'title' => 'Tambah Ekskul',
            'guru' => $guru,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'id_guru' => 'nullable|exists:tb_guru,id',
            'keterangan' => 'nullable|string',
        ]);

        Ekskul::create([
            'nama_ekskul' => $request->nama_ekskul,
            'id_guru' => $request->id_guru,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('admin.ekskul.index')
            ->with('success', 'Data ekskul berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ekskul = Ekskul::findOrFail($id);

        $guru = Guru::orderBy('nama_lengkap')->get();

        return view('admin.ekskul.edit', [
            'title' => 'Edit Ekskul',
            'ekskul' => $ekskul,
            'guru' => $guru,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'id_guru' => 'nullable|exists:tb_guru,id',
            'keterangan' => 'nullable|string',
        ]);

        $ekskul = Ekskul::findOrFail($id);

        $ekskul->update([
            'nama_ekskul' => $request->nama_ekskul,
            'id_guru' => $request->id_guru,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('admin.ekskul.index')
            ->with('success', 'Data ekskul berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ekskul = Ekskul::findOrFail($id);

        $ekskul->delete();

        return redirect()
            ->route('admin.ekskul.index')
            ->with('success', 'Data ekskul berhasil dihapus.');
    }
}
