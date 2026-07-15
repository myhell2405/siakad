<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasTahunAjaran;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\SiswaKelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Tampilkan halaman pilih kelas & mapel serta tabel input nilai.
     */
    public function index(Request $request)
    {
        $taList = TahunAjaran::orderBy('tahun_mulai', 'desc')->orderBy('semester', 'desc')->get();
        $taAktif = TahunAjaran::where('status', 'aktif')->first() ?? $taList->first();

        $selectedTaId = $request->get('id_tahun_ajaran', $taAktif ? $taAktif->id_tahun_ajaran : null);

        $queryKelasTa = KelasTahunAjaran::with(['kelas', 'waliKelas'])->where('id_tahun_ajaran', $selectedTaId);
        $queryMapel = Mapel::orderBy('nama_mapel');

        $userRole = strtolower(session('role'));
        $refId = session('ref_id');

        if (in_array($userRole, ['guru', 'wali_kelas']) && $refId) {
            $kelasIds = \App\Models\GuruKelas::whereHas('guruMapel', function ($q) use ($refId) {
                $q->where('id_guru', $refId);
            })->pluck('id_kelas_tahun_ajaran')->toArray();
            $queryKelasTa->where(function ($q) use ($kelasIds, $refId) {
                $q->whereIn('id', $kelasIds)->orWhere('id_wali_kelas', $refId);
            });

            $mapelIds = \App\Models\GuruMapel::where('id_guru', $refId)->pluck('id_mapel');
            if ($mapelIds->isNotEmpty()) {
                $queryMapel->whereIn('id_mapel', $mapelIds);
            }
        }

        $kelasTaList = $queryKelasTa->get()->sortBy(function ($item) {
            return $item->kelas ? $item->kelas->tingkat_kelas.$item->kelas->nama_kelas : '';
        });

        $mapelList = $queryMapel->get();

        $selectedKelasTaId = $request->get('id_kelas_ta');
        $selectedMapelId = $request->get('id_mapel');

        $siswaKelasList = collect();
        $existingNilai = collect();
        $selectedKelasTa = null;
        $selectedMapel = null;
        $activeMapels = collect();
        $allExistingNilai = collect();

        if ($selectedKelasTaId) {
            $selectedKelasTa = KelasTahunAjaran::with('kelas')->find($selectedKelasTaId);
            if ($selectedMapelId) {
                $selectedMapel = Mapel::find($selectedMapelId);
            }

            if ($selectedKelasTa) {
                $siswaKelasList = SiswaKelas::with('siswa')
                    ->where('id_kelas_tahun_ajaran', $selectedKelasTaId)
                    ->get()
                    ->sortBy(function ($item) {
                        return $item->siswa ? $item->siswa->nama_siswa : '';
                    });

                if ($selectedMapel) {
                    $activeMapels = collect([$selectedMapel]);
                    $existingNilai = Nilai::where('kelas_tahun_ajaran_id', $selectedKelasTaId)
                        ->where('id_mapel', $selectedMapelId)
                        ->get()
                        ->keyBy('siswa_id');
                } else {
                    $activeMapels = $mapelList;
                }

                $allExistingNilai = Nilai::where('kelas_tahun_ajaran_id', $selectedKelasTaId)->get();
            }
        }

        $nilaisSiswa = collect();
        if (strtolower(session('role')) === 'siswa' && session('ref_id')) {
            $nilaisSiswa = Nilai::with(['mapel', 'kelasTahunAjaran.tahunAjaran', 'kelasTahunAjaran.kelas'])
                ->where('siswa_id', session('ref_id'))
                ->get();
        }

        return view('admin.nilai.index', compact(
            'taList',
            'selectedTaId',
            'kelasTaList',
            'mapelList',
            'selectedKelasTaId',
            'selectedMapelId',
            'selectedKelasTa',
            'selectedMapel',
            'siswaKelasList',
            'existingNilai',
            'nilaisSiswa',
            'activeMapels',
            'allExistingNilai'
        ));
    }

    /**
     * Simpan atau perbarui nilai siswa secara massal.
     */
    public function store(Request $request)
    {
        if (strtolower(session('role')) === 'siswa') {
            abort(403, 'Akses ditolak. Siswa tidak dapat mengubah nilai.');
        }

        $request->validate([
            'id_kelas_ta' => 'required|exists:kelas_tahun_ajaran,id',
            'id_mapel' => 'required|exists:mapel,id_mapel',
            'nilais' => 'required|array',
        ]);

        if (in_array(strtolower(session('role')), ['guru', 'wali_kelas']) && session('ref_id')) {
            $refId = session('ref_id');
            $kta = KelasTahunAjaran::find($request->id_kelas_ta);

            // Wali kelas boleh input semua mapel di kelasnya
            $isWaliKelasOfClass = $kta && $kta->id_wali_kelas == $refId;

            if (!$isWaliKelasOfClass) {
                // Guru biasa — cek apakah dia mengampu mapel ini di kelas ini
                $mapelIds = \App\Models\GuruMapel::where('id_guru', $refId)->pluck('id_mapel')->toArray();
                if (empty($mapelIds) || !in_array($request->id_mapel, $mapelIds)) {
                    abort(403, 'Akses ditolak. Anda tidak mengampu mata pelajaran ini.');
                }

                $kelasIds = \App\Models\GuruKelas::whereHas('guruMapel', function ($q) use ($refId) {
                    $q->where('id_guru', $refId);
                })->pluck('id_kelas_tahun_ajaran')->toArray();

                if (!in_array($request->id_kelas_ta, $kelasIds)) {
                    abort(403, 'Akses ditolak. Anda tidak mengampu kelas ini.');
                }
            }
        }

        $kelasTaId = $request->id_kelas_ta;
        $mapelId = $request->id_mapel;

        foreach ($request->nilais as $siswaId => $data) {
            $tugas = isset($data['tugas']) && is_numeric($data['tugas']) ? (float) $data['tugas'] : null;
            $uts = isset($data['uts']) && is_numeric($data['uts']) ? (float) $data['uts'] : null;
            $uas = isset($data['uas']) && is_numeric($data['uas']) ? (float) $data['uas'] : null;
            $catatan = $data['catatan'] ?? null;

            // Hitung rata-rata komponen yang diisi
            $components = [];
            if ($tugas !== null) {
                $components[] = $tugas;
            }
            if ($uts !== null) {
                $components[] = $uts;
            }
            if ($uas !== null) {
                $components[] = $uas;
            }

            $nilaiAkhir = count($components) > 0 ? round(array_sum($components) / count($components), 2) : null;

            // Jangan simpan jika semua kosong
            if ($tugas === null && $uts === null && $uas === null && empty($catatan)) {
                continue;
            }

            $existingNilai = Nilai::where('siswa_id', $siswaId)
                ->where('id_mapel', $mapelId)
                ->where('kelas_tahun_ajaran_id', $kelasTaId)
                ->first();

            if ($existingNilai) {
                $oldTugas = $existingNilai->nilai_tugas !== null ? (float)$existingNilai->nilai_tugas : null;
                $oldUts = $existingNilai->nilai_uts !== null ? (float)$existingNilai->nilai_uts : null;
                $oldUas = $existingNilai->nilai_uas !== null ? (float)$existingNilai->nilai_uas : null;
                $oldCatatan = trim((string)$existingNilai->catatan_guru);

                $newTugas = $tugas !== null ? (float)$tugas : null;
                $newUts = $uts !== null ? (float)$uts : null;
                $newUas = $uas !== null ? (float)$uas : null;
                $newCatatan = trim((string)$catatan);

                if ($oldTugas === $newTugas && $oldUts === $newUts && $oldUas === $newUas && $oldCatatan === $newCatatan) {
                    continue;
                }
            }

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'id_mapel' => $mapelId,
                    'kelas_tahun_ajaran_id' => $kelasTaId,
                ],
                [
                    'nilai_tugas' => $tugas,
                    'nilai_uts' => $uts,
                    'nilai_uas' => $uas,
                    'nilai_akhir' => $nilaiAkhir,
                    'catatan_guru' => $catatan,
                    'status_validasi' => 'submitted',
                ]
            );
        }

        return redirect()->back()->with('success', 'Nilai siswa berhasil disimpan!');
    }

    /**
     * Halaman validasi nilai untuk Wali Kelas / Admin.
     */
    public function validasi(Request $request)
    {
        $queryKelas = KelasTahunAjaran::with(['kelas', 'tahunAjaran'])->orderBy('id', 'desc');
        if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
            $queryKelas->where('id_wali_kelas', session('ref_id'));
        }
        $kelasList = $queryKelas->get();

        $query = Nilai::with(['siswa', 'mapel', 'kelasTahunAjaran.kelas'])->orderBy('id', 'desc');

        if (strtolower(session('role')) === 'wali_kelas') {
            $kelasIds = $kelasList->pluck('id');
            $query->whereIn('kelas_tahun_ajaran_id', $kelasIds);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_tahun_ajaran_id', $request->kelas_id);
        }

        if ($request->filled('status_validasi')) {
            if ($request->status_validasi === 'pending') {
                $query->where('status_validasi', '!=', 'validated');
            } elseif ($request->status_validasi === 'validated') {
                $query->where('status_validasi', 'validated');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $nilais = $query->get();

        $groupedNilais = $nilais->groupBy(function ($item) {
            return $item->siswa_id . '_' . $item->kelas_tahun_ajaran_id;
        });

        $listEkskul = \App\Models\Ekskul::orderBy('nama_ekskul')->get();
        $existingRapors = \App\Models\Rapor::all()->keyBy(function ($item) {
            return $item->siswa_id . '_' . $item->kelas_tahun_ajaran_id;
        });

        return view('admin.nilai.validasi', compact('nilais', 'groupedNilais', 'kelasList', 'listEkskul', 'existingRapors'));
    }

    /**
     * Submit validasi nilai.
     */
    public function submitValidasi(Request $request)
    {
        if ($request->input('id_nilai') === 'all') {
            $query = Nilai::where('status_validasi', '!=', 'validated');
            if (strtolower(session('role')) === 'wali_kelas') {
                $kelasIds = session('ref_id') ? KelasTahunAjaran::where('id_wali_kelas', session('ref_id'))->pluck('id') : collect();
                $query->whereIn('kelas_tahun_ajaran_id', $kelasIds);
            }
            $query->update(['status_validasi' => 'validated']);
            return redirect()->back()->with('success', 'Semua nilai berhasil divalidasi!');
        }

        if ($request->input('id_nilai') === 'all_siswa') {
            $request->validate([
                'siswa_id' => 'required',
                'kelas_tahun_ajaran_id' => 'required',
            ]);
            if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
                $kta = KelasTahunAjaran::find($request->kelas_tahun_ajaran_id);
                if ($kta && $kta->id_wali_kelas != session('ref_id')) {
                    abort(403, 'Anda bukan wali kelas dari kelas ini.');
                }
            }
            Nilai::where('siswa_id', $request->siswa_id)
                ->where('kelas_tahun_ajaran_id', $request->kelas_tahun_ajaran_id)
                ->where('status_validasi', '!=', 'validated')
                ->update(['status_validasi' => 'validated']);

            \App\Models\Rapor::updateOrCreate(
                [
                    'siswa_id' => $request->siswa_id,
                    'kelas_tahun_ajaran_id' => $request->kelas_tahun_ajaran_id,
                ],
                [
                    'sakit' => $request->input('sakit', 0),
                    'izin' => $request->input('izin', 0),
                    'alpa' => $request->input('alpa', 0),
                    'catatan_wali_kelas' => $request->input('catatan_wali_kelas', 'Tingkatkan terus prestasi belajarmu dan pertahankan semangat belajar yang tinggi.'),
                    'status_kenaikan' => $request->input('status_kenaikan', 'Naik ke kelas berikutnya'),
                ]
            );

            if ($request->has('has_ekskul_form')) {
                \App\Models\NilaiEkskul::where('siswa_id', $request->siswa_id)
                    ->where('kelas_tahun_ajaran_id', $request->kelas_tahun_ajaran_id)
                    ->delete();

                if ($request->has('ekskul') && is_array($request->ekskul)) {
                    foreach ($request->ekskul as $idEkskul => $dataEkskul) {
                        if (!empty($dataEkskul['selected'])) {
                            \App\Models\NilaiEkskul::create([
                                'siswa_id' => $request->siswa_id,
                                'kelas_tahun_ajaran_id' => $request->kelas_tahun_ajaran_id,
                                'id_ekskul' => $idEkskul,
                                'predikat' => !empty($dataEkskul['predikat']) ? $dataEkskul['predikat'] : 'Baik',
                                'keterangan' => !empty($dataEkskul['keterangan']) ? $dataEkskul['keterangan'] : 'Mengikuti kegiatan ekstrakurikuler dengan baik',
                            ]);
                        }
                    }
                }
            }

            return redirect()->back()->with('success', 'Semua nilai berhasil divalidasi & Rapor siswa resmi diterbitkan (Auto-Generate)!');
        }

        $request->validate([
            'id_nilai' => 'required|exists:nilai,id',
        ]);

        $nilai = Nilai::findOrFail($request->id_nilai);
        if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
            $kta = KelasTahunAjaran::find($nilai->kelas_tahun_ajaran_id);
            if ($kta && $kta->id_wali_kelas != session('ref_id')) {
                abort(403, 'Anda bukan wali kelas dari kelas ini.');
            }
        }
        $nilai->status_validasi = 'validated';
        $nilai->save();

        return redirect()->back()->with('success', 'Nilai berhasil divalidasi!');
    }
}
