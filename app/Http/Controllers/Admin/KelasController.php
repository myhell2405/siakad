<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruKelas;
use App\Models\GuruMapel;
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

    /*
    |--------------------------------------------------------------------------
    | GURU — Tampilkan halaman atur guru di kelas
    |--------------------------------------------------------------------------
    */
    public function guruIndex($id)
    {
        $kelas = Kelas::findOrFail($id);

        // Ambil id_guru_mapel yang sudah terdaftar di kelas ini (via semua kelas_tahun_ajaran)
        $kelasTaIds = $kelas->kelasTahunAjaran()->pluck('id');
        $guruKelas  = GuruKelas::with(['guruMapel.guru', 'guruMapel.mapel'])
            ->whereIn('id_kelas_tahun_ajaran', $kelasTaIds)
            ->get()
            ->unique('id_guru_mapel'); // hanya tampil unik per guru-mapel

        // Guru mapel yang belum ada di kelas ini sama sekali
        $assignedGuruMapelIds = $guruKelas->pluck('id_guru_mapel');
        $availableGuru = GuruMapel::with(['guru', 'mapel'])
            ->whereNotIn('id', $assignedGuruMapelIds)
            ->get()
            ->sortBy(fn ($g) => $g->guru->nama_lengkap ?? '');

        return view('admin.kelas.guru', [
            'title'         => 'Atur Guru Kelas — ' . $kelas->nama_kelas,
            'kelas'         => $kelas,
            'guruKelas'     => $guruKelas,
            'availableGuru' => $availableGuru,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GURU — Tambah guru mapel ke semua rombel pada kelas ini
    |--------------------------------------------------------------------------
    */
    public function guruStore(Request $request, $id)
    {
        $request->validate([
            'id_guru_mapel' => 'required|exists:guru_mapel,id',
        ]);

        $kelas     = Kelas::findOrFail($id);
        $kelasTaIds = $kelas->kelasTahunAjaran()->pluck('id');

        if ($kelasTaIds->isEmpty()) {
            return back()->with('error', 'Kelas ini belum memiliki Tahun Ajaran. Buat dulu di Pembagian Kelas.');
        }

        $added = 0;
        foreach ($kelasTaIds as $kelasTaId) {
            $exists = GuruKelas::where('id_kelas_tahun_ajaran', $kelasTaId)
                ->where('id_guru_mapel', $request->id_guru_mapel)
                ->exists();

            if (! $exists) {
                GuruKelas::create([
                    'id_kelas_tahun_ajaran' => $kelasTaId,
                    'id_guru_mapel'         => $request->id_guru_mapel,
                ]);
                $added++;
            }
        }

        $msg = $added > 0
            ? 'Guru berhasil ditambahkan ke kelas ini.'
            : 'Guru sudah terdaftar di seluruh rombel kelas ini.';

        return back()->with('success', $msg);
    }

    /*
    |--------------------------------------------------------------------------
    | GURU — Hapus guru mapel dari semua rombel pada kelas ini
    |--------------------------------------------------------------------------
    */
    public function guruDestroy(Request $request, $id)
    {
        $request->validate([
            'id_guru_mapel' => 'required|exists:guru_mapel,id',
        ]);

        $kelas      = Kelas::findOrFail($id);
        $kelasTaIds = $kelas->kelasTahunAjaran()->pluck('id');

        GuruKelas::whereIn('id_kelas_tahun_ajaran', $kelasTaIds)
            ->where('id_guru_mapel', $request->id_guru_mapel)
            ->delete();

        return back()->with('success', 'Guru berhasil dihapus dari kelas ini.');
    }
}
