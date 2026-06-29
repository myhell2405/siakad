<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KelasTahunAjaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class PembagianKelasController extends Controller
{
    /**
     * Tampilkan halaman utama Pembagian Kelas pada TA Aktif.
     */
    public function index()
    {
        $title = 'Pembagian Kelas Aktif';
        $taAktif = TahunAjaran::where('status', 'aktif')->first();

        if (! $taAktif) {
            return view('admin.pembagian_kelas.index', [
                'title' => $title,
                'taAktif' => null,
                'kelasTaList' => collect([]),
                'masterKelasCount' => Kelas::count(),
                'guruList' => collect([]),
            ]);
        }

        // Ambil daftar kelas tahun ajaran untuk TA aktif beserta relasinya
        $kelasTaList = KelasTahunAjaran::with(['kelas', 'waliKelas'])
            ->where('id_tahun_ajaran', $taAktif->id_tahun_ajaran)
            ->get()
            ->sortBy(function ($item) {
                return $item->kelas ? $item->kelas->tingkat_kelas.$item->kelas->nama_kelas : '';
            });

        $masterKelasCount = Kelas::count();
        $guruList = Guru::orderBy('nama_lengkap')->get();

        return view('admin.pembagian_kelas.index', [
            'title' => $title,
            'taAktif' => $taAktif,
            'kelasTaList' => $kelasTaList,
            'masterKelasCount' => $masterKelasCount,
            'guruList' => $guruList,
        ]);
    }

    /**
     * Generate massal pembagian kelas untuk TA Aktif.
     */
    public function generate(Request $request)
    {
        $taAktif = TahunAjaran::where('status', 'aktif')->first();
        if (! $taAktif) {
            return back()->with('error', 'Tidak ada Tahun Ajaran yang sedang aktif.');
        }

        $masterKelas = Kelas::all();
        if ($masterKelas->isEmpty()) {
            return back()->with('error', 'Data Master Kelas masih kosong.');
        }

        $defaultGuru = Guru::first();
        if (! $defaultGuru) {
            return back()->with('error', 'Data Guru masih kosong. Harap tambahkan minimal 1 guru terlebih dahulu.');
        }

        $generatedCount = 0;

        foreach ($masterKelas as $k) {
            // Cek apakah kelas ini sudah ada di TA aktif
            $exists = KelasTahunAjaran::where('id_kelas', $k->id_kelas)
                ->where('id_tahun_ajaran', $taAktif->id_tahun_ajaran)
                ->exists();

            if (! $exists) {
                // Cari riwayat wali kelas dari TA sebelumnya jika ada
                $previousTa = KelasTahunAjaran::where('id_kelas', $k->id_kelas)
                    ->where('id_tahun_ajaran', '!=', $taAktif->id_tahun_ajaran)
                    ->latest('id')
                    ->first();

                $waliKelasId = $previousTa ? $previousTa->id_wali_kelas : $defaultGuru->id;

                KelasTahunAjaran::create([
                    'id_kelas' => $k->id_kelas,
                    'id_tahun_ajaran' => $taAktif->id_tahun_ajaran,
                    'id_wali_kelas' => $waliKelasId,
                ]);

                $generatedCount++;
            }
        }

        if ($generatedCount > 0) {
            return back()->with('success', "Berhasil membuat $generatedCount pembagian kelas baru untuk TA Aktif.");
        }

        return back()->with('info', 'Semua master kelas sudah terdaftar di Tahun Ajaran Aktif.');
    }

    /**
     * Update cepat Wali Kelas dari tabel inline.
     */
    public function updateWaliKelas(Request $request, $id)
    {
        $request->validate([
            'id_wali_kelas' => 'required|exists:tb_guru,id',
        ]);

        $kelasTa = KelasTahunAjaran::findOrFail($id);
        $kelasTa->update([
            'id_wali_kelas' => $request->id_wali_kelas,
        ]);

        return back()->with('success', 'Wali kelas berhasil diperbarui.');
    }
}
