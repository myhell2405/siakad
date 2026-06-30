@extends('admin.layout')

@section('content')
<div class="space-y-10 font-sans text-slate-800 pb-16">

    {{-- ================================================
         HERO HEADER SECTION
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03]">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0">
                <i class="bi bi-file-earmark-text-fill text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50 text-blue-700 ring-1 ring-blue-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>Laporan & Evaluasi</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Laporan Rapor Siswa</h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span>Kelola data kehadiran, catatan wali kelas, status kenaikan, serta cetak rapor resmi</span>
                </p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 ring-1 ring-emerald-500/20 text-emerald-900 p-4 rounded-2xl shadow-sm flex items-center justify-between text-xs font-bold animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/20">
                    <i class="bi bi-check-lg text-sm font-black"></i>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">
                <i class="bi bi-x-lg text-xs font-bold"></i>
            </button>
        </div>
    @endif

    {{-- ================================================
         FILTER FORM CARD
         ================================================ --}}
    <div class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.laporan.rapor') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
            <div class="space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Tahun Ajaran</label>
                <select name="id_ta" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ ucfirst($ta->semester) }}) {{ $ta->status == 'Aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Kelas Target</label>
                <select name="id_kelas" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner disabled:opacity-50 disabled:cursor-not-allowed" onchange="this.form.submit()" {{ !$id_ta ? 'disabled' : '' }}>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $id_kelas == $k->id ? 'selected' : '' }}>
                            {{ $k->kelas->nama_kelas ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 text-xs active:scale-[0.98]">
                    <i class="bi bi-funnel-fill"></i> Filter Data Siswa
                </button>
            </div>
        </form>
    </div>

    {{-- ================================================
         DATA CONTENT SECTION
         ================================================ --}}
    @if ($id_kelas)
        <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black shadow-md shadow-blue-500/20">
                        <i class="bi bi-journal-check"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider">Daftar Siswa & Pelengkap Rapor</h3>
                        <p class="text-xs text-slate-400 font-semibold">Total Terdaftar: <strong class="text-slate-700">{{ $siswaList->count() }}</strong> Siswa</p>
                    </div>
                </div>
                <div class="w-full sm:w-72 relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="bi bi-search text-xs"></i>
                    </div>
                    <input type="text" id="searchSiswaRapor" placeholder="Cari nama atau NISN..."
                           class="w-full bg-white border border-slate-200/80 rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 transition shadow-2xs">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                            <th class="py-4 px-4 text-center w-12">No</th>
                            <th class="py-4 px-4">NISN</th>
                            <th class="py-4 px-4">Nama Siswa</th>
                            <th class="py-4 px-4 text-center">Peringkat</th>
                            <th class="py-4 px-4">Ekskul</th>
                            <th class="py-4 px-4 text-center">Kehadiran (S/I/A)</th>
                            <th class="py-4 px-4">Catatan Walas</th>
                            <th class="py-4 px-4 text-center">Status</th>
                            <th class="py-4 px-6 text-center w-56">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="raporTableBody" class="divide-y divide-slate-100 text-xs font-semibold">
                        @forelse ($siswaList as $index => $sk)
                            @php
                                $r = $raporData->get($sk->id_siswa);
                                $myEks = $nilaiEkskulData->get($sk->id_siswa) ?? collect();
                                $myRank = $rankings->get($sk->id_siswa, '-');
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="py-4 px-4 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 font-mono text-slate-500 font-bold">{{ $sk->siswa->nisn ?? '-' }}</td>
                                <td class="py-4 px-4 font-extrabold text-slate-900">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                <td class="py-4 px-4 text-center font-black text-blue-600 text-sm">
                                    {{ $myRank !== '-' ? '#' . $myRank : '-' }}
                                </td>
                                <td class="py-4 px-4 text-xs">
                                    @forelse ($myEks as $e)
                                        <span class="inline-block bg-purple-50 text-purple-700 ring-1 ring-purple-500/20 px-2 py-0.5 rounded-lg mr-1 mb-1 font-bold">{{ $e->ekskul?->nama_ekskul ?? '-' }} <span class="text-purple-500">({{ $e->predikat }})</span></span>
                                    @empty
                                        <span class="text-slate-400 italic">-</span>
                                    @endforelse
                                </td>
                                <td class="py-4 px-4 text-center font-mono font-bold">
                                    <span class="px-2 py-0.5 bg-amber-50 text-amber-700 ring-1 ring-amber-500/20 rounded-md">{{ $r->sakit ?? 0 }}</span> /
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 ring-1 ring-blue-500/20 rounded-md">{{ $r->izin ?? 0 }}</span> /
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-700 ring-1 ring-rose-500/20 rounded-md">{{ $r->alpa ?? 0 }}</span>
                                </td>
                                <td class="py-4 px-4 text-xs text-slate-600 max-w-xs truncate italic">"{{ $r->catatan_wali_kelas ?? '-' }}"</td>
                                <td class="py-4 px-4 text-center font-bold">
                                    @if ($r && $r->status_kenaikan == 'Naik Kelas')
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/20 rounded-full text-[10px] uppercase tracking-wider font-black">Naik Kelas</span>
                                    @elseif ($r && $r->status_kenaikan == 'Tidak Naik Kelas')
                                        <span class="px-3 py-1 bg-rose-50 text-rose-700 ring-1 ring-rose-500/20 rounded-full text-[10px] uppercase tracking-wider font-black">Tidak Naik</span>
                                    @else
                                        <span class="text-slate-400 font-medium">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center space-x-1.5 flex items-center justify-center">
                                    @if(in_array(strtolower(session('role')), ['admin', 'wali_kelas']))
                                        <button onclick="openModalRapor({{ $sk->id_siswa }}, '{{ addslashes($sk->siswa->nama_siswa ?? '') }}', {{ $r->sakit ?? 0 }}, {{ $r->izin ?? 0 }}, {{ $r->alpa ?? 0 }}, '{{ addslashes($r->catatan_wali_kelas ?? '') }}', '{{ $r->status_kenaikan ?? '' }}')" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white ring-1 ring-amber-500/30 rounded-xl text-xs font-bold transition-all shadow-2xs inline-flex items-center gap-1">
                                            <i class="bi bi-pencil-square"></i> Isi
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.laporan.rapor', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'id_siswa' => $sk->id_siswa, 'print' => 1]) }}" target="_blank" class="px-3 py-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-500/20 active:scale-95 inline-flex items-center gap-1">
                                        <i class="bi bi-printer-fill"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-16 text-center text-slate-400 font-medium">
                                    <i class="bi bi-inbox text-3xl block mb-2 text-slate-300"></i>
                                    Belum ada siswa yang terdaftar di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl ring-1 ring-slate-900/[0.03] shadow-[0_10px_35px_-10px_rgba(0,0,0,0.04)]">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 font-black shadow-inner">
                <i class="bi bi-book text-2xl"></i>
            </div>
            <h3 class="text-base font-black text-slate-800">Menunggu Pilihan Filter</h3>
            <p class="text-xs text-slate-400 font-semibold mt-1">Silakan pilih Tahun Ajaran dan Kelas di atas untuk mengelola dan mencetak rapor siswa.</p>
        </div>
    @endif

    @if(in_array(strtolower(session('role')), ['admin', 'wali_kelas']))
    <!-- Modal Form Isi Pelengkap Rapor -->
    <div id="modalRapor" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 animate-fade-in">
        <div class="bg-white rounded-[2rem] max-w-lg w-full p-6 sm:p-8 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] ring-1 ring-slate-900/[0.05] max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-black shadow-inner">
                        <i class="bi bi-pencil-square text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base">Isi Data Pelengkap Rapor</h3>
                        <p class="text-[11px] text-slate-400 font-bold">Lengkapi ketidakhadiran, ekskul, dan catatan</p>
                    </div>
                </div>
                <button onclick="closeModalRapor()" class="w-8 h-8 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center transition">&times;</button>
            </div>
            <form action="{{ route('admin.laporan.rapor.simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="siswa_id" id="modal_siswa_id">
                <input type="hidden" name="kelas_tahun_ajaran_id" value="{{ $id_kelas }}">

                <div class="mb-4">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-1.5">Nama Siswa</label>
                    <input type="text" id="modal_nama_siswa" class="w-full bg-slate-100 border border-slate-200/80 rounded-xl px-4 py-2.5 text-xs font-extrabold text-slate-700 cursor-not-allowed" disabled>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-5">
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-500 mb-1">Sakit (Hari)</label>
                        <input type="number" name="sakit" id="modal_sakit" min="0" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-2 text-center text-xs font-bold focus:bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-500 mb-1">Izin (Hari)</label>
                        <input type="number" name="izin" id="modal_izin" min="0" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-2 text-center text-xs font-bold focus:bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-500 mb-1">Tanpa Ket.</label>
                        <input type="number" name="alpa" id="modal_alpa" min="0" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-2 text-center text-xs font-bold focus:bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Ekstrakurikuler yang Diikuti</label>
                    <input type="hidden" name="has_ekskul_form" value="1">
                    <div class="border border-slate-200/80 rounded-2xl p-3 bg-slate-50/50 max-h-48 overflow-y-auto space-y-2.5">
                        @forelse ($masterEkskul as $mek)
                            <div class="p-3 bg-white rounded-xl border border-slate-100 shadow-2xs flex flex-col gap-2.5">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" name="ekskul[{{ $mek->id_ekskul }}][selected]" value="1" id="ekskul_cb_{{ $mek->id_ekskul }}" class="w-4 h-4 text-blue-600 rounded-md border-slate-300 focus:ring-blue-500 ekskul-checkbox" data-id="{{ $mek->id_ekskul }}" onchange="toggleEkskulInputs({{ $mek->id_ekskul }})">
                                    <label for="ekskul_cb_{{ $mek->id_ekskul }}" class="font-extrabold text-xs text-slate-800 cursor-pointer">{{ $mek->nama_ekskul }}</label>
                                </div>
                                <div id="ekskul_inputs_{{ $mek->id_ekskul }}" class="hidden grid grid-cols-3 gap-2 pl-6 pt-1">
                                    <div>
                                        <select name="ekskul[{{ $mek->id_ekskul }}][predikat]" id="ekskul_pred_{{ $mek->id_ekskul }}" class="w-full text-[11px] font-bold bg-slate-50 border border-slate-200 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            <option value="Sangat Baik">Sangat Baik</option>
                                            <option value="Baik" selected>Baik</option>
                                            <option value="Cukup">Cukup</option>
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="text" name="ekskul[{{ $mek->id_ekskul }}][keterangan]" id="ekskul_ket_{{ $mek->id_ekskul }}" placeholder="Keterangan..." class="w-full text-[11px] font-medium bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500" value="Mengikuti kegiatan dengan aktif dan baik.">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2 text-center">Belum ada data master ekskul.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-1.5">Catatan Wali Kelas</label>
                    <textarea name="catatan_wali_kelas" id="modal_catatan" rows="3" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-3.5 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none placeholder:text-slate-400 text-xs font-medium transition" placeholder="Tulis motivasi atau saran pengembangan untuk siswa..."></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-1.5">Status Kenaikan Kelas</label>
                    <select name="status_kenaikan" id="modal_status" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-3.5 py-2.5 text-xs font-bold focus:bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                        <option value="">-- Pilih Status --</option>
                        <option value="Naik Kelas">Naik Kelas</option>
                        <option value="Tidak Naik Kelas">Tidak Naik Kelas</option>
                        <option value="Lulus">Lulus (Untuk Kelas VI)</option>
                        <option value="Tidak Lulus">Tidak Lulus</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                    <button type="button" onclick="closeModalRapor()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-xs font-bold text-slate-600 transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-500/25 transition active:scale-95">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const ekskulDataSiswa = {
            @foreach ($siswaList as $sk)
                @php
                    $myEks = $nilaiEkskulData->get($sk->id_siswa) ?? collect();
                @endphp
                "{{ $sk->id_siswa }}": [
                    @foreach ($myEks as $e)
                        { id_ekskul: {{ $e->id_ekskul }}, predikat: "{{ addslashes($e->predikat ?? '') }}", keterangan: "{{ addslashes($e->keterangan ?? '') }}" },
                    @endforeach
                ] @if(!$loop->last),@endif
            @endforeach
        };

        function toggleEkskulInputs(id) {
            const cb = document.getElementById('ekskul_cb_' + id);
            const inputs = document.getElementById('ekskul_inputs_' + id);
            if (cb && inputs) {
                if (cb.checked) {
                    inputs.classList.remove('hidden');
                } else {
                    inputs.classList.add('hidden');
                }
            }
        }

        function openModalRapor(id, nama, sakit, izin, alpa, catatan, status) {
            document.getElementById('modal_siswa_id').value = id;
            document.getElementById('modal_nama_siswa').value = nama;
            document.getElementById('modal_sakit').value = sakit;
            document.getElementById('modal_izin').value = izin;
            document.getElementById('modal_alpa').value = alpa;
            document.getElementById('modal_catatan').value = catatan;
            document.getElementById('modal_status').value = status;

            // Reset all ekskul checkboxes
            document.querySelectorAll('.ekskul-checkbox').forEach(cb => {
                cb.checked = false;
                toggleEkskulInputs(cb.dataset.id);
            });

            // Populate ekskul if exists
            if (ekskulDataSiswa[id]) {
                ekskulDataSiswa[id].forEach(item => {
                    const cb = document.getElementById('ekskul_cb_' + item.id_ekskul);
                    if (cb) {
                        cb.checked = true;
                        if (item.predikat) document.getElementById('ekskul_pred_' + item.id_ekskul).value = item.predikat;
                        if (item.keterangan) document.getElementById('ekskul_ket_' + item.id_ekskul).value = item.keterangan;
                        toggleEkskulInputs(item.id_ekskul);
                    }
                });
            }

            document.getElementById('modalRapor').classList.remove('hidden');
        }

        function closeModalRapor() {
            document.getElementById('modalRapor').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchSiswaRapor');
            const tbody = document.getElementById('raporTableBody');
            if (searchInput && tbody) {
                searchInput.addEventListener('input', function () {
                    const keyword = this.value.toLowerCase().trim();
                    const rows = tbody.querySelectorAll('tr');
                    rows.forEach(row => {
                        if (row.querySelectorAll('td').length === 1) return;
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(keyword) ? '' : 'none';
                    });
                });
            }
        });
    </script>
    @endif
</div>
@endsection
