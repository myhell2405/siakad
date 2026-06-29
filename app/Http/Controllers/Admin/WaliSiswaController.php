<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\WaliSiswa;
use Illuminate\Http\Request;

class WaliSiswaController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        $title = 'Data Wali Siswa';

        $query = WaliSiswa::with('siswa');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_wali', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($qs) use ($search) {
                      $qs->where('nama_siswa', 'like', "%{$search}%");
                  });
            });
        }

        $waliSiswa = $query->latest()->paginate(20)->withQueryString();

        return view('admin.wali_siswa.index', compact(
            'title',
            'waliSiswa'
        ));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $title = 'Tambah Wali Siswa';

        return view('admin.wali_siswa.create', compact('title'));
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|exists:siswa,nisn',
            'nama_wali' => 'required|string|max:255',
            'hubungan' => 'required|in:AYAH,IBU,WALI',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:100',
        ]);

        WaliSiswa::create([
            'nisn' => $request->nisn,
            'nama_wali' => $request->nama_wali,
            'hubungan' => $request->hubungan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'pekerjaan' => $request->pekerjaan,
        ]);

        return redirect()
            ->route('admin.wali-siswa.index')
            ->with('success', 'Data wali siswa berhasil ditambahkan');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $title = 'Edit Wali Siswa';

        $waliSiswa = WaliSiswa::with('siswa')
            ->findOrFail($id);

        return view('admin.wali_siswa.edit', compact(
            'title',
            'waliSiswa'
        ));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $waliSiswa = WaliSiswa::findOrFail($id);

        $request->validate([
            'nisn' => 'required|exists:siswa,nisn',
            'nama_wali' => 'required|string|max:255',
            'hubungan' => 'required|in:AYAH,IBU,WALI',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:100',
        ]);

        $waliSiswa->update([
            'nisn' => $request->nisn,
            'nama_wali' => $request->nama_wali,
            'hubungan' => $request->hubungan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'pekerjaan' => $request->pekerjaan,
        ]);

        return redirect()
            ->route('admin.wali-siswa.index')
            ->with('success', 'Data wali siswa berhasil diperbarui');
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $waliSiswa = WaliSiswa::findOrFail($id);

        $waliSiswa->delete();

        return redirect()
            ->route('admin.wali-siswa.index')
            ->with('success', 'Data wali siswa berhasil dihapus');
    }

    /**
     * AJAX Cari Siswa Berdasarkan NISN
     */
    public function cariSiswa($nisn)
    {
        $siswa = Siswa::where('nisn', $nisn)->first();

        if (! $siswa) {
            return response()->json([
                'success' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'nama_siswa' => $siswa->nama_siswa,
        ]);
    }
}
