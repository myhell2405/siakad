<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\GuruKelas;
use App\Models\Kelas;
use App\Models\KelasTahunAjaran;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use Illuminate\Http\Request;

class KelasTahunAjaranController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STORE KELAS TAHUN AJARAN
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, $id_kelas)
    {
        $request->validate([
            'id_tahun_ajaran' => 'required',
            'id_wali_kelas' => 'required',
        ]);

        KelasTahunAjaran::create([
            'id_kelas' => $id_kelas,
            'id_tahun_ajaran' => $request->id_tahun_ajaran,
            'id_wali_kelas' => $request->id_wali_kelas,
        ]);

        return back()->with('success', 'Kelas tahun ajaran berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $data = KelasTahunAjaran::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL KELAS TAHUN AJARAN
    |--------------------------------------------------------------------------
    */
    public function detail($id)
    {
        $kelasTa = KelasTahunAjaran::with([
            'kelas',
            'tahunAjaran',
            'waliKelas',
        ])->findOrFail($id);

        $siswaKelas = SiswaKelas::with('siswa')
            ->where('id_kelas_tahun_ajaran', $id)
            ->get();

        $guruKelas = GuruKelas::with('guru')
            ->where('id_kelas_tahun_ajaran', $id)
            ->get();

        // Cari siswa yang belum masuk kelas di Tahun Ajaran yang sama
        $enrolledSiswaIds = SiswaKelas::whereHas('kelasTahunAjaran', function ($q) use ($kelasTa) {
            $q->where('id_tahun_ajaran', $kelasTa->id_tahun_ajaran);
        })->pluck('id_siswa');

        $unassignedSiswa = Siswa::whereNotIn('id', $enrolledSiswaIds)
            ->orderBy('nama_siswa')
            ->get();

        // Cari guru yang belum terdaftar di kelas ini
        $enrolledGuruIds = $guruKelas->pluck('id_guru');
        $availableGuru = Guru::whereNotIn('id', $enrolledGuruIds)
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.kelas.gurukelas', [
            'title' => 'Detail Kelas',
            'kelasTa' => $kelasTa,
            'siswaKelas' => $siswaKelas,
            'guruKelas' => $guruKelas,
            'unassignedSiswa' => $unassignedSiswa,
            'availableGuru' => $availableGuru,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH SISWA
    |--------------------------------------------------------------------------
    */
    public function storeSiswa(Request $request, $id)
    {
        $request->validate([
            'id_siswa' => 'required',
        ]);

        SiswaKelas::create([
            'id_kelas_tahun_ajaran' => $id,
            'id_siswa' => $request->id_siswa,
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS SISWA
    |--------------------------------------------------------------------------
    */
    public function destroySiswa($id)
    {
        SiswaKelas::findOrFail($id)->delete();

        return back()->with('success', 'Siswa berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH GURU
    |--------------------------------------------------------------------------
    */
    public function storeGuru(Request $request, $id)
    {
        $request->validate([
            'id_guru' => 'required',
        ]);

        GuruKelas::create([
            'id_kelas_tahun_ajaran' => $id,
            'id_guru' => $request->id_guru,
        ]);

        return back()->with('success', 'Guru berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS GURU
    |--------------------------------------------------------------------------
    */
    public function destroyGuru($id)
    {
        GuruKelas::findOrFail($id)->delete();

        return back()->with('success', 'Guru berhasil dihapus');
    }
}
