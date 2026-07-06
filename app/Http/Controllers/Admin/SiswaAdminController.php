<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaAdminController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['siswaKelas.kelasTahunAjaran.kelas', 'waliSiswa']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas')) {
            $kelasId = $request->kelas;
            $query->whereHas('siswaKelas.kelasTahunAjaran', function($q) use ($kelasId) {
                $q->where('id_kelas', $kelasId);
            });
        }

        $siswa = $query->latest()->paginate(20)->withQueryString();
        $listKelas = \App\Models\Kelas::orderBy('nama_kelas')->get();

        return view('admin.siswa.index', compact('siswa', 'listKelas'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nisn' => 'required|unique:siswa,nisn',
            'nama_siswa' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
        ]);

        Siswa::create($validatedData);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validatedData = $request->validate([
            'nisn' => 'required|unique:siswa,nisn,'.$id,
            'nama_siswa' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
        ]);

        $siswa->update($validatedData);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diupdate');
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }

    /**
     * Export data siswa ke file CSV (dapat dibuka di Excel)
     */
    public function export()
    {
        $siswa = Siswa::latest()->get();
        $filename = "data_siswa_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['NO', 'NISN', 'NAMA SISWA', 'TEMPAT LAHIR', 'TANGGAL LAHIR', 'JENIS KELAMIN', 'AGAMA', 'STATUS KELUARGA', 'ANAK KE', 'ALAMAT', 'NO TELP', 'SEKOLAH ASAL', 'TANGGAL DITERIMA'];

        $callback = function() use($siswa, $columns) {
            $file = fopen('php://output', 'w');
            // Tambahkan BOM untuk dukungan UTF-8 di Microsoft Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($siswa as $idx => $row) {
                fputcsv($file, [
                    $idx + 1,
                    $row->nisn,
                    $row->nama_siswa,
                    $row->tempat_lahir,
                    $row->tanggal_lahir ? $row->tanggal_lahir->format('Y-m-d') : '',
                    ($row->jenis_kelamin == 'L' || $row->jenis_kelamin == 'Laki-laki') ? 'Laki-laki' : 'Perempuan',
                    $row->agama,
                    $row->status_keluarga,
                    $row->anak_ke,
                    $row->alamat_siswa,
                    $row->telp_siswa,
                    $row->sekolah_asal,
                    $row->tanggal_diterima ? $row->tanggal_diterima->format('Y-m-d') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * View Transkrip Nilai Siswa untuk Admin
     */
    public function transkrip($id)
    {
        $siswa = Siswa::findOrFail($id);
        $nilaisSiswa = \App\Models\Nilai::with(['mapel', 'kelasTahunAjaran.tahunAjaran', 'kelasTahunAjaran.kelas'])
            ->where('siswa_id', $id)
            ->get();

        return view('admin.siswa.transkrip', compact('siswa', 'nilaisSiswa'));
    }
}
