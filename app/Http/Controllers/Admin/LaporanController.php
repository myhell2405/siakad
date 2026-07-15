<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Models\KelasTahunAjaran;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\NilaiEkskul;
use App\Models\Rapor;
use App\Models\SiswaKelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function identitasSiswa(Request $request)
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $taAktif = TahunAjaran::where('status', 'aktif')->first();
        $id_ta = $request->input('id_ta', $taAktif ? $taAktif->id_tahun_ajaran : null);
        $id_kelas = $request->input('id_kelas');

        $kelasList = collect();
        if ($id_ta) {
            $queryKelas = KelasTahunAjaran::with('kelas')->where('id_tahun_ajaran', $id_ta);
            if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
                $queryKelas->where('id_wali_kelas', session('ref_id'));
            }
            $kelasList = $queryKelas->get();
            if (!$id_kelas && strtolower(session('role')) === 'wali_kelas' && $kelasList->isNotEmpty()) {
                $id_kelas = $kelasList->first()->id;
            }
        }

        $siswaList = collect();
        if ($id_kelas) {
            if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
                $kta = KelasTahunAjaran::find($id_kelas);
                if ($kta && $kta->id_wali_kelas != session('ref_id')) {
                    abort(403, 'Akses ditolak. Anda bukan wali kelas dari kelas ini.');
                }
            }
            $siswaList = SiswaKelas::with(['siswa.waliSiswa', 'kelasTahunAjaran.kelas', 'kelasTahunAjaran.tahunAjaran'])
                ->where('id_kelas_tahun_ajaran', $id_kelas)
                ->get();
        }

        if ($request->has('print') && $request->input('id_siswa')) {
            $query = SiswaKelas::with(['siswa.waliSiswa', 'kelasTahunAjaran.kelas', 'kelasTahunAjaran.tahunAjaran'])
                ->where('id_siswa', $request->input('id_siswa'));
            if ($id_kelas) {
                $query->where('id_kelas_tahun_ajaran', $id_kelas);
            }
            $data = $query->latest('id')->first();

            if (!$data) {
                $siswa = \App\Models\Siswa::with('waliSiswa')->findOrFail($request->input('id_siswa'));
                $data = new SiswaKelas();
                $data->setRelation('siswa', $siswa);
            }

            return view('admin.laporan.print_identitas_siswa', compact('data'));
        }

        return view('admin.laporan.identitas_siswa', compact('tahunAjaranList', 'id_ta', 'kelasList', 'id_kelas', 'siswaList'));
    }

    public function identitasGuru(Request $request)
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $taAktif = TahunAjaran::where('status', 'aktif')->first();
        $id_ta = $request->input('id_ta', $taAktif ? $taAktif->id_tahun_ajaran : null);
        $id_kelas = $request->input('id_kelas');

        $kelasList = collect();
        if ($id_ta) {
            $queryKelas = KelasTahunAjaran::with(['kelas', 'waliKelas', 'tahunAjaran'])->where('id_tahun_ajaran', $id_ta);
            if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
                $queryKelas->where('id_wali_kelas', session('ref_id'));
            }
            $kelasList = $queryKelas->get();
            if (!$id_kelas && strtolower(session('role')) === 'wali_kelas' && $kelasList->isNotEmpty()) {
                $id_kelas = $kelasList->first()->id;
            }
        }

        $selectedKelas = null;
        if ($id_kelas) {
            if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
                $kta = KelasTahunAjaran::find($id_kelas);
                if ($kta && $kta->id_wali_kelas != session('ref_id')) {
                    abort(403, 'Akses ditolak. Anda bukan wali kelas dari kelas ini.');
                }
            }
            $selectedKelas = KelasTahunAjaran::with(['kelas', 'waliKelas', 'tahunAjaran'])->find($id_kelas);
        }

        if ($request->has('print')) {
            if ($request->input('id_guru')) {
                $guru = \App\Models\Guru::findOrFail($request->input('id_guru'));
                $selectedKelas = KelasTahunAjaran::with(['kelas', 'waliKelas', 'tahunAjaran'])->where('id_wali_kelas', $guru->id)->latest('id')->first();
                if (!$selectedKelas) {
                    $selectedKelas = new KelasTahunAjaran();
                    $selectedKelas->setRelation('waliKelas', $guru);
                }
                return view('admin.laporan.print_identitas_guru', compact('selectedKelas'));
            } elseif ($selectedKelas) {
                return view('admin.laporan.print_identitas_guru', compact('selectedKelas'));
            }
        }

        return view('admin.laporan.identitas_guru', compact('tahunAjaranList', 'id_ta', 'kelasList', 'id_kelas', 'selectedKelas'));
    }

    public function rapor(Request $request)
    {
        $userRole = strtolower(session('role'));
        $refId = session('ref_id');

        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $taAktif = TahunAjaran::where('status', 'aktif')->first();
        $id_ta = $request->input('id_ta', $taAktif ? $taAktif->id_tahun_ajaran : null);
        $id_kelas = $request->input('id_kelas');

        if ($userRole === 'siswa' && $refId && !$id_kelas) {
            $myKelas = SiswaKelas::with('kelasTahunAjaran')->where('id_siswa', $refId)->latest('id')->first();
            if ($myKelas && $myKelas->kelasTahunAjaran) {
                $id_kelas = $myKelas->id_kelas_tahun_ajaran;
                $id_ta = $myKelas->kelasTahunAjaran->id_tahun_ajaran;
            }
        }

        $kelasList = collect();
        if ($id_ta) {
            $queryKelas = KelasTahunAjaran::with('kelas')->where('id_tahun_ajaran', $id_ta);
            if ($userRole === 'siswa' && $refId) {
                $myKelasIds = SiswaKelas::where('id_siswa', $refId)->pluck('id_kelas_tahun_ajaran');
                $queryKelas->whereIn('id', $myKelasIds);
            } elseif ($userRole === 'wali_kelas' && $refId) {
                $queryKelas->where('id_wali_kelas', $refId);
            }
            $kelasList = $queryKelas->get();
            if (!$id_kelas && in_array($userRole, ['wali_kelas', 'siswa']) && $kelasList->isNotEmpty()) {
                $id_kelas = $kelasList->first()->id;
            }
        }

        $siswaList = collect();
        if ($id_kelas) {
            if ($userRole === 'wali_kelas' && $refId) {
                $kta = KelasTahunAjaran::find($id_kelas);
                if ($kta && $kta->id_wali_kelas != $refId) {
                    abort(403, 'Akses ditolak. Anda bukan wali kelas dari kelas ini.');
                }
            }
            $querySiswa = SiswaKelas::with(['siswa', 'kelasTahunAjaran.kelas', 'kelasTahunAjaran.tahunAjaran', 'kelasTahunAjaran.waliKelas'])
                ->where('id_kelas_tahun_ajaran', $id_kelas);

            if ($userRole === 'siswa' && $refId) {
                $querySiswa->where('id_siswa', $refId);
            }

            $siswaList = $querySiswa->get();
        }

        if ($request->has('print') && $request->input('id_siswa')) {
            if ($userRole === 'siswa' && (int) $request->input('id_siswa') !== (int) $refId) {
                abort(403, 'Akses ditolak. Anda hanya dapat mencetak rapor Anda sendiri.');
            }

            $siswaKelas = SiswaKelas::with(['siswa', 'kelasTahunAjaran.kelas', 'kelasTahunAjaran.tahunAjaran', 'kelasTahunAjaran.waliKelas'])
                ->where('id_kelas_tahun_ajaran', $id_kelas)
                ->where('id_siswa', $request->input('id_siswa'))
                ->firstOrFail();

            $mapelList = Mapel::orderBy('nama_mapel')->get();
            $nilaiList = Nilai::where('siswa_id', $request->input('id_siswa'))
                ->where('kelas_tahun_ajaran_id', $id_kelas)
                ->get()
                ->keyBy('id_mapel');

            $rapor = Rapor::firstOrNew([
                'siswa_id' => $request->input('id_siswa'),
                'kelas_tahun_ajaran_id' => $id_kelas,
            ]);

            $ekskulList = NilaiEkskul::with('ekskul')
                ->where('siswa_id', $request->input('id_siswa'))
                ->where('kelas_tahun_ajaran_id', $id_kelas)
                ->get();

            $rankData = $this->calculateClassRankings($id_kelas);
            $rangking = $rankData['rankings']->get($request->input('id_siswa'), '-');
            $totalSiswaKelas = $rankData['totalSiswa'];

            return view('admin.laporan.print_rapor', compact('siswaKelas', 'mapelList', 'nilaiList', 'rapor', 'ekskulList', 'rangking', 'totalSiswaKelas'));
        }

        // Fetch existing rapor records for quick view
        $raporData = Rapor::where('kelas_tahun_ajaran_id', $id_kelas)->get()->keyBy('siswa_id');
        $masterEkskul = Ekskul::orderBy('nama_ekskul')->get();
        $nilaiEkskulData = NilaiEkskul::where('kelas_tahun_ajaran_id', $id_kelas)->get()->groupBy('siswa_id');

        $rankData = $this->calculateClassRankings($id_kelas);
        $rankings = $rankData['rankings'];

        return view('admin.laporan.rapor', compact('tahunAjaranList', 'id_ta', 'kelasList', 'id_kelas', 'siswaList', 'raporData', 'masterEkskul', 'nilaiEkskulData', 'rankings'));
    }

    private function calculateClassRankings($id_kelas)
    {
        if (!$id_kelas) {
            return ['rankings' => collect(), 'totalRanked' => 0, 'totalSiswa' => 0];
        }

        $allSiswaKelas = SiswaKelas::where('id_kelas_tahun_ajaran', $id_kelas)->get();
        $allNilaiKelas = Nilai::where('kelas_tahun_ajaran_id', $id_kelas)->get();

        $studentScores = collect();
        foreach ($allSiswaKelas as $sk) {
            $nils = $allNilaiKelas->where('siswa_id', $sk->id_siswa)->whereNotNull('nilai_akhir');
            $avg = $nils->count() > 0 ? $nils->avg('nilai_akhir') : 0;
            $studentScores->push([
                'siswa_id' => $sk->id_siswa,
                'avg' => round($avg, 2),
            ]);
        }

        $sortedScores = $studentScores->sortByDesc('avg')->values();
        $rankings = collect();
        $currentRank = 1;
        $prevAvg = null;
        $totalRanked = 0;

        foreach ($sortedScores as $idx => $item) {
            if ($item['avg'] <= 0) {
                $rankings[$item['siswa_id']] = '-';
                continue;
            }
            if ($prevAvg !== null && $item['avg'] < $prevAvg) {
                $currentRank = $idx + 1;
            }
            $rankings[$item['siswa_id']] = $currentRank;
            $prevAvg = $item['avg'];
            $totalRanked++;
        }

        return ['rankings' => $rankings, 'totalRanked' => $totalRanked, 'totalSiswa' => $allSiswaKelas->count()];
    }

    public function transkrip(Request $request)
    {
        $id_siswa = $request->input('id_siswa');
        
        // If student is logged in, ensure they can only print their own transcript
        if (strtolower(session('role')) === 'siswa') {
            $id_siswa = session('ref_id');
        }

        if (!$id_siswa) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
        }

        $siswa = \App\Models\Siswa::findOrFail($id_siswa);
        $nilaisSiswa = \App\Models\Nilai::with(['mapel', 'kelasTahunAjaran.tahunAjaran', 'kelasTahunAjaran.kelas'])
            ->where('siswa_id', $id_siswa)
            ->get();

        $groupedNilai = $nilaisSiswa->groupBy(function($n) {
            $ta = $n->kelasTahunAjaran->tahunAjaran ?? null;
            $kelas = $n->kelasTahunAjaran->kelas ?? null;
            $taName = $ta ? $ta->tahun_ajaran . ' - ' . strtoupper($ta->semester) : 'SEMESTER TIDAK DIKETAHUI';
            $kelasName = $kelas ? strtoupper($kelas->nama_kelas) : 'KELAS TIDAK DIKETAHUI';
            return $taName . ' (' . $kelasName . ')';
        })->sortKeysDesc();

        return view('admin.laporan.print_transkrip', compact('siswa', 'groupedNilai'));
    }

    public function simpanRapor(Request $request)
    {
        if (! in_array(strtolower(session('role')), ['admin', 'wali_kelas'])) {
            abort(403, 'Akses ditolak. Hanya Admin dan Wali Kelas yang dapat mengubah data rapor.');
        }
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_tahun_ajaran_id' => 'required|exists:kelas_tahun_ajaran,id',
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'alpa' => 'nullable|integer|min:0',
            'catatan_wali_kelas' => 'nullable|string',
            'status_kenaikan' => 'nullable|string',
        ]);

        if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
            $kta = KelasTahunAjaran::find($request->kelas_tahun_ajaran_id);
            if ($kta && $kta->id_wali_kelas != session('ref_id')) {
                abort(403, 'Akses ditolak. Anda bukan wali kelas dari kelas ini.');
            }
        }

        Rapor::updateOrCreate(
            [
                'siswa_id' => $request->siswa_id,
                'kelas_tahun_ajaran_id' => $request->kelas_tahun_ajaran_id,
            ],
            [
                'sakit' => $request->sakit ?? 0,
                'izin' => $request->izin ?? 0,
                'alpa' => $request->alpa ?? 0,
                'catatan_wali_kelas' => $request->catatan_wali_kelas,
                'status_kenaikan' => $request->status_kenaikan,
            ]
        );

        if ($request->has('has_ekskul_form')) {
            NilaiEkskul::where('siswa_id', $request->siswa_id)
                ->where('kelas_tahun_ajaran_id', $request->kelas_tahun_ajaran_id)
                ->delete();

            if ($request->has('ekskul') && is_array($request->ekskul)) {
                foreach ($request->ekskul as $idEkskul => $dataEkskul) {
                    if (!empty($dataEkskul['selected'])) {
                        NilaiEkskul::create([
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

        return redirect()->back()->with('success', 'Data pelengkap rapor berhasil disimpan!');
    }

    public function monitoring(Request $request)
    {
        $tahunAjaranList = TahunAjaran::orderBy('id_tahun_ajaran', 'desc')->get();
        $taAktif = TahunAjaran::where('status', 'aktif')->first();
        $id_ta = $request->input('id_ta', $taAktif ? $taAktif->id_tahun_ajaran : null);

        $kelasList = collect();
        $rekapKelas = collect();
        $topSiswa = collect();

        if ($id_ta) {
            $selectedTa = TahunAjaran::find($id_ta);
            $queryKelas = KelasTahunAjaran::with(['kelas', 'waliKelas'])->where('id_tahun_ajaran', $id_ta);
            if (strtolower(session('role')) === 'wali_kelas' && session('ref_id')) {
                $queryKelas->where('id_wali_kelas', session('ref_id'));
            }
            $kelasList = $queryKelas->get();

            // All students in this active TA
            $allSiswaKelas = SiswaKelas::with(['siswa', 'kelasTahunAjaran.kelas'])
                ->whereIn('id_kelas_tahun_ajaran', $kelasList->pluck('id'))
                ->get();

            // All grades in this TA
            $allNilai = Nilai::whereIn('kelas_tahun_ajaran_id', $kelasList->pluck('id'))->get();

            // Calculate per student average
            $siswaAverages = collect();
            foreach ($allSiswaKelas as $sk) {
                $studentNilais = $allNilai->where('siswa_id', $sk->id_siswa)->where('kelas_tahun_ajaran_id', $sk->id_kelas_tahun_ajaran);
                $avg = $studentNilais->count() > 0 ? $studentNilais->avg('nilai_akhir') : 0;
                $siswaAverages->push([
                    'siswa' => $sk->siswa,
                    'kelas_nama' => $sk->kelasTahunAjaran->kelas->nama_kelas ?? '-',
                    'kelas_id' => $sk->id_kelas_tahun_ajaran,
                    'rata_rata' => round($avg, 2),
                ]);
            }

            // Top 5 students across school
            $topSiswa = $siswaAverages->sortByDesc('rata_rata')->take(5)->values();

            // All rapor data in this TA
            $allRapor = Rapor::whereIn('kelas_tahun_ajaran_id', $kelasList->pluck('id'))->get();

            foreach ($kelasList as $kta) {
                $classStudents = $siswaAverages->where('kelas_id', $kta->id);
                $jmlSiswa = $classStudents->count();
                $avgKelas = $jmlSiswa > 0 ? $classStudents->avg('rata_rata') : 0;
                $maxKelas = $jmlSiswa > 0 ? $classStudents->max('rata_rata') : 0;
                $minKelas = $jmlSiswa > 0 ? $classStudents->min('rata_rata') : 0;

                $classRapors = $allRapor->where('kelas_tahun_ajaran_id', $kta->id);
                $naikCount = $classRapors->whereIn('status_kenaikan', ['Naik Kelas', 'Lulus'])->count();
                $tidakNaikCount = $classRapors->whereIn('status_kenaikan', ['Tidak Naik Kelas', 'Tidak Lulus'])->count();

                $rekapKelas->push([
                    'id' => $kta->id,
                    'nama_kelas' => $kta->kelas->nama_kelas ?? '-',
                    'wali_kelas' => $kta->waliKelas->nama_lengkap ?? '-',
                    'jumlah_siswa' => $jmlSiswa,
                    'rata_rata' => round($avgKelas, 2),
                    'tertinggi' => round($maxKelas, 2),
                    'terendah' => round($minKelas, 2),
                    'naik_kelas' => $naikCount,
                    'tidak_naik' => $tidakNaikCount,
                ]);
            }
        }

        if ($request->has('print')) {
            $selectedTa = TahunAjaran::find($id_ta);

            return view('admin.laporan.print_monitoring', compact('selectedTa', 'rekapKelas', 'topSiswa'));
        }

        return view('admin.laporan.monitoring', compact('tahunAjaranList', 'id_ta', 'rekapKelas', 'topSiswa'));
    }
}
