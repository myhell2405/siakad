@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-file-earmark-text-fill text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>LAPORAN & EVALUASI</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">LAPORAN RAPOR SISWA</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">
                    KELOLA DATA KEHADIRAN, CATATAN WALI KELAS, STATUS KENAIKAN, SERTA CETAK RAPOR RESMI
                </p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-500/30 text-emerald-900 p-4 rounded-2xl shadow-xs flex items-center justify-between text-xs font-mono font-bold uppercase">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">✕</button>
        </div>
    @endif

    {{-- FILTER FORM CARD --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs">
        <form action="{{ route('admin.laporan.rapor') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
            <div class="space-y-2">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">TAHUN AJARAN</label>
                <select name="id_ta" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase" onchange="this.form.submit()">
                    <option value="">-- PILIH TAHUN AJARAN --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ strtoupper($ta->semester) }}) {{ strtolower($ta->status) == 'aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">KELAS TARGET</label>
                <select name="id_kelas" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all disabled:opacity-50 uppercase" onchange="this.form.submit()" {{ !$id_ta ? 'disabled' : '' }}>
                    <option value="">-- PILIH KELAS --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $id_kelas == $k->id ? 'selected' : '' }}>
                            {{ strtoupper($k->kelas->nama_kelas ?? '-') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-void hover:bg-black text-white font-mono font-bold py-3 px-6 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase">
                    <i class="bi bi-funnel-fill text-signal"></i> FILTER DATA SISWA
                </button>
            </div>
        </form>
    </div>

    {{-- DATA CONTENT SECTION --}}
    @if ($id_kelas)
        <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-black/10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                        <i class="bi bi-journal-check text-signal"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-void text-sm uppercase">DAFTAR SISWA & PELENGKAP RAPOR</h3>
                        <p class="text-xs text-gray-500 font-mono uppercase">TOTAL TERDAFTAR: <strong class="text-void">{{ $siswaList->count() }}</strong> SISWA</p>
                    </div>
                </div>
                <div class="w-full sm:w-72 relative">
                    <input type="text" id="searchSiswaRapor" placeholder="Cari nama atau NISN..."
                           class="w-full bg-white border border-black/10 rounded-xl pl-10 pr-4 py-2.5 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-void transition shadow-2xs">
                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface text-void font-mono text-[10px] uppercase tracking-wider border-b border-black/10">
                            <th class="py-4 pl-6 text-center w-14">NO</th>
                            <th class="py-4 px-4">NISN</th>
                            <th class="py-4 px-4">NAMA SISWA</th>
                            <th class="py-4 px-4 text-center">PERINGKAT</th>
                            <th class="py-4 px-4">EKSKUL</th>
                            <th class="py-4 px-4 text-center">KEHADIRAN (S/I/A)</th>
                            <th class="py-4 px-4">CATATAN WALAS</th>
                            <th class="py-4 px-4 text-center">STATUS</th>
                            <th class="py-4 pr-6 text-center w-52">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="raporTableBody" class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                        @forelse ($siswaList as $index => $sk)
                            @php
                                $r = $raporData->get($sk->id_siswa);
                                $myEks = $nilaiEkskulData->get($sk->id_siswa) ?? collect();
                                $myRank = $rankings->get($sk->id_siswa, '-');
                            @endphp
                            <tr class="hover:bg-gray-50/80 transition duration-150">
                                <td class="py-4 pl-6 text-center font-mono font-bold text-gray-400 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 font-mono font-bold text-gray-600 whitespace-nowrap">{{ $sk->siswa->nisn ?? '-' }}</td>
                                <td class="py-4 px-4 font-bold text-void uppercase">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                <td class="py-4 px-4 text-center font-mono font-black text-cobalt text-sm whitespace-nowrap">
                                    {{ $myRank !== '-' ? '#' . $myRank : '-' }}
                                </td>
                                <td class="py-4 px-4 text-xs font-mono">
                                    @forelse ($myEks as $e)
                                        <span class="inline-block bg-gray-100 text-void border border-black/10 px-2 py-0.5 rounded mr-1 mb-1 font-bold uppercase">{{ $e->ekskul?->nama_ekskul ?? '-' }} <span class="text-cobalt">({{ strtoupper($e->predikat) }})</span></span>
                                    @empty
                                        <span class="text-gray-400 italic">-</span>
                                    @endforelse
                                </td>
                                <td class="py-4 px-4 text-center font-mono font-bold whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 bg-gray-50 border border-black/10 px-2.5 py-1 rounded-lg text-xs">
                                        <span title="Sakit" class="inline-flex items-center gap-1 text-gray-700"><span class="text-gray-400 font-normal">S:</span>{{ $r->sakit ?? 0 }}</span>
                                        <span class="text-gray-300">/</span>
                                        <span title="Izin" class="inline-flex items-center gap-1 text-cobalt"><span class="text-gray-400 font-normal">I:</span>{{ $r->izin ?? 0 }}</span>
                                        <span class="text-gray-300">/</span>
                                        <span title="Alpa" class="inline-flex items-center gap-1 {{ ($r->alpa ?? 0) > 0 ? 'text-rose-600 font-extrabold' : 'text-gray-700' }}"><span class="text-gray-400 font-normal">A:</span>{{ $r->alpa ?? 0 }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-xs text-gray-600 max-w-xs truncate italic font-mono uppercase">"{{ $r->catatan_wali_kelas ?? '-' }}"</td>
                                <td class="py-4 px-4 text-center font-bold whitespace-nowrap">
                                    @if ($r && $r->status_kenaikan == 'Naik Kelas')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded font-mono text-[10px] uppercase font-bold">NAIK KELAS</span>
                                    @elseif ($r && $r->status_kenaikan == 'Tidak Naik Kelas')
                                        <span class="px-3 py-1 bg-void text-signal border border-black rounded font-mono text-[10px] uppercase font-bold">TIDAK NAIK</span>
                                    @else
                                        <span class="text-gray-400 font-mono">-</span>
                                    @endif
                                </td>
                                <td class="py-4 pr-6 text-center space-x-1.5 whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        @if(in_array(strtolower(session('role')), ['admin', 'wali_kelas']))
                                            <button onclick="openModalRapor({{ $sk->id_siswa }}, '{{ addslashes($sk->siswa->nama_siswa ?? '') }}', {{ $r->sakit ?? 0 }}, {{ $r->izin ?? 0 }}, {{ $r->alpa ?? 0 }}, '{{ addslashes($r->catatan_wali_kelas ?? '') }}', '{{ $r->status_kenaikan ?? '' }}')" class="px-3 py-1.5 bg-gray-100 hover:bg-void text-void hover:text-white border border-black/10 rounded-lg text-xs font-mono font-bold transition-all uppercase inline-flex items-center gap-1">
                                                <i class="bi bi-pencil-square text-signal"></i> ISI
                                            </button>
                                        @endif
                                        <a href="{{ route('admin.laporan.rapor', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'id_siswa' => $sk->id_siswa, 'print' => 1]) }}" target="_blank" class="px-3 py-1.5 bg-void hover:bg-black text-white rounded-lg text-xs font-mono font-bold transition-all shadow-md active:scale-95 uppercase inline-flex items-center gap-1">
                                            <i class="bi bi-printer-fill text-signal"></i> CETAK
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-16 text-center text-gray-400 font-mono uppercase">
                                    <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                                    BELUM ADA SISWA YANG TERDAFTAR DI KELAS INI.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-black/10 shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-void text-signal flex items-center justify-center mx-auto mb-4 font-black shadow-md border border-black">
                <i class="bi bi-book text-2xl"></i>
            </div>
            <h3 class="text-base font-black text-void uppercase">MENUNGGU PILIHAN FILTER</h3>
            <p class="text-xs text-gray-500 font-mono uppercase mt-1">Silakan pilih Tahun Ajaran dan Kelas di atas untuk mengelola dan mencetak rapor siswa.</p>
        </div>
    @endif

    @if(in_array(strtolower(session('role')), ['admin', 'wali_kelas']))
    <!-- Modal Form Isi Pelengkap Rapor -->
    <div id="modalRapor" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 border border-black shadow-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b border-black/10 pb-4 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                        <i class="bi bi-pencil-square text-signal text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-void text-base uppercase">ISI DATA PELENGKAP RAPOR</h3>
                        <p class="text-[10px] font-mono text-gray-500 uppercase">Lengkapi ketidakhadiran, ekskul, dan catatan</p>
                    </div>
                </div>
                <button onclick="closeModalRapor()" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-void hover:text-white text-void font-bold flex items-center justify-center transition">&times;</button>
            </div>
            <form action="{{ route('admin.laporan.rapor.simpan') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="siswa_id" id="modal_siswa_id">
                <input type="hidden" name="kelas_tahun_ajaran_id" value="{{ $id_kelas }}">

                <div>
                    <label class="block text-xs font-mono font-bold uppercase text-void mb-1">NAMA SISWA</label>
                    <input type="text" id="modal_nama_siswa" class="w-full bg-gray-100 border border-black/10 rounded-xl px-4 py-2.5 text-xs font-mono font-bold text-void cursor-not-allowed uppercase" disabled>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[10px] font-mono font-bold uppercase text-void mb-1">SAKIT (HARI)</label>
                        <input type="number" name="sakit" id="modal_sakit" min="0" class="w-full bg-gray-50 border border-black/10 rounded-xl px-3 py-2 text-center text-xs font-mono font-bold focus:bg-white focus:ring-2 focus:ring-void focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-mono font-bold uppercase text-void mb-1">IZIN (HARI)</label>
                        <input type="number" name="izin" id="modal_izin" min="0" class="w-full bg-gray-50 border border-black/10 rounded-xl px-3 py-2 text-center text-xs font-mono font-bold focus:bg-white focus:ring-2 focus:ring-void focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-mono font-bold uppercase text-void mb-1">TANPA KET.</label>
                        <input type="number" name="alpa" id="modal_alpa" min="0" class="w-full bg-gray-50 border border-black/10 rounded-xl px-3 py-2 text-center text-xs font-mono font-bold focus:bg-white focus:ring-2 focus:ring-void focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase text-void mb-2">EKSTRAKURIKULER YANG DIIKUTI</label>
                    <input type="hidden" name="has_ekskul_form" value="1">
                    <div class="border border-black/10 rounded-2xl p-3 bg-gray-50/50 max-h-48 overflow-y-auto space-y-2.5">
                        @forelse ($masterEkskul as $mek)
                            <div class="p-3 bg-white rounded-xl border border-black/10 shadow-2xs flex flex-col gap-2.5">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" name="ekskul[{{ $mek->id_ekskul }}][selected]" value="1" id="ekskul_cb_{{ $mek->id_ekskul }}" class="w-4 h-4 text-void rounded border-black/20 focus:ring-void ekskul-checkbox" data-id="{{ $mek->id_ekskul }}" onchange="toggleEkskulInputs({{ $mek->id_ekskul }})">
                                    <label for="ekskul_cb_{{ $mek->id_ekskul }}" class="font-bold text-xs text-void uppercase cursor-pointer">{{ $mek->nama_ekskul }}</label>
                                </div>
                                <div id="ekskul_inputs_{{ $mek->id_ekskul }}" class="hidden grid grid-cols-3 gap-2 pl-6 pt-1">
                                    <div>
                                        <select name="ekskul[{{ $mek->id_ekskul }}][predikat]" id="ekskul_pred_{{ $mek->id_ekskul }}" class="w-full text-[10px] font-mono font-bold uppercase bg-gray-50 border border-black/10 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-void">
                                            <option value="Sangat Baik">SANGAT BAIK</option>
                                            <option value="Baik" selected>BAIK</option>
                                            <option value="Cukup">CUKUP</option>
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="text" name="ekskul[{{ $mek->id_ekskul }}][keterangan]" id="ekskul_ket_{{ $mek->id_ekskul }}" placeholder="Keterangan..." class="w-full text-[11px] font-mono font-medium bg-gray-50 border border-black/10 rounded-lg px-2.5 py-1.5 focus:outline-none focus:ring-1 focus:ring-void uppercase" value="Mengikuti kegiatan dengan aktif dan baik.">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-2 text-center font-mono">BELUM ADA DATA MASTER EKSKUL.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase text-void mb-1.5">CATATAN WALI KELAS</label>
                    <textarea name="catatan_wali_kelas" id="modal_catatan" rows="3" class="w-full bg-gray-50 border border-black/10 rounded-xl px-3.5 py-2.5 focus:bg-white focus:ring-2 focus:ring-void focus:outline-none placeholder:text-gray-400 font-mono text-xs font-medium transition uppercase" placeholder="Tulis motivasi atau saran pengembangan untuk siswa..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase text-void mb-1.5">STATUS KENAIKAN KELAS</label>
                    <select name="status_kenaikan" id="modal_status" class="w-full bg-gray-50 border border-black/10 rounded-xl px-3.5 py-2.5 text-xs font-mono font-bold uppercase focus:bg-white focus:ring-2 focus:ring-void focus:outline-none transition">
                        <option value="">-- PILIH STATUS --</option>
                        <option value="Naik Kelas">NAIK KELAS</option>
                        <option value="Tidak Naik Kelas">TIDAK NAIK KELAS</option>
                        <option value="Lulus">LULUS (UNTUK KELAS VI)</option>
                        <option value="Tidak Lulus">TIDAK LULUS</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-black/10">
                    <button type="button" onclick="closeModalRapor()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-xs font-mono font-bold text-void transition uppercase">BATAL</button>
                    <button type="submit" class="px-6 py-2.5 bg-void hover:bg-black text-white rounded-xl text-xs font-mono font-bold shadow-md transition uppercase inline-flex items-center gap-2">
                        <i class="bi bi-save2 text-signal"></i> SIMPAN DATA
                    </button>
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

            document.querySelectorAll('.ekskul-checkbox').forEach(cb => {
                cb.checked = false;
                toggleEkskulInputs(cb.dataset.id);
            });

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
