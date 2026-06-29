<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $kelas = Kelas::all();

        return view('admin.kelas.index', [
            'title' => 'Data Kelas',
            'kelas' => $kelas,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.kelas.create', [
            'title' => 'Tambah Kelas',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|max:50',
            'tingkat_kelas' => 'required',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat_kelas' => $request->tingkat_kelas,
        ]);

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);

        return view('admin.kelas.edit', [
            'title' => 'Edit Kelas',
            'kelas' => $kelas,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|max:50',
            'tingkat_kelas' => 'required',
        ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat_kelas' => $request->tingkat_kelas,
        ]);

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil dihapus');
    }
}
