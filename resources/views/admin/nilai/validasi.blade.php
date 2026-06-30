@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-500/30 text-emerald-900 rounded-2xl shadow-xs flex items-center justify-between font-mono text-xs font-bold uppercase">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">✕</button>
        </div>
    @endif

    {{-- HERO HEADER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-check2-all text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>VERIFIKASI AKADEMIK</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">VALIDASI NILAI SISWA</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">PERIKSA DAN SETUJUI NILAI YANG TELAH DISUBMIT OLEH GURU MATA PELAJARAN</p>
            </div>
        </div>

        @if($nilais->where('status_validasi', '!=', 'validated')->count() > 0)
            <form action="{{ route('admin.nilai.validasi.submit') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memvalidasi semua nilai yang menunggu di seluruh kelas?');">
                @csrf
                <input type="hidden" name="id_nilai" value="all">
                <button type="submit" class="inline-flex items-center gap-3 px-6 py-3.5 bg-void hover:bg-black text-white font-mono font-bold text-xs rounded-xl shadow-md transition uppercase">
                    <i class="bi bi-check2-all text-signal text-base"></i>
                    <span>VALIDASI SEMUA NILAI (GLOBAL)</span>
                </button>
            </form>
        @endif
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-3xl border border-black/10 p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.nilai.validasi') }}" method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-mono font-bold uppercase text-void mb-2">KELAS</label>
                <select name="kelas_id" onchange="document.getElementById('filterForm').submit()" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                    <option value="">-- SEMUA KELAS --</option>
                    @foreach($kelasList as $kta)
                        <option value="{{ $kta->id }}" {{ request('kelas_id') == $kta->id ? 'selected' : '' }}>
                            {{ strtoupper($kta->kelas->nama_kelas ?? '-') }} ({{ $kta->tahunAjaran->tahun_ajaran ?? '' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-mono font-bold uppercase text-void mb-2">STATUS VALIDASI</label>
                <select name="status_validasi" onchange="document.getElementById('filterForm').submit()" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                    <option value="">-- SEMUA STATUS --</option>
                    <option value="pending" {{ request('status_validasi') == 'pending' ? 'selected' : '' }}>MENUNGGU VALIDASI</option>
                    <option value="validated" {{ request('status_validasi') == 'validated' ? 'selected' : '' }}>SUDAH VALID</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-mono font-bold uppercase text-void mb-2">CARI SISWA</label>
                <div class="relative">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Ketik nama atau NISN..." class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl pl-10 pr-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all">
                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="w-full bg-void hover:bg-black text-white font-mono font-bold py-3 px-4 rounded-xl text-xs transition flex items-center justify-center gap-2 shadow-xs uppercase">
                    <i class="bi bi-funnel-fill text-signal"></i> FILTER
                </button>
                @if(request()->hasAny(['kelas_id', 'status_validasi', 'search']))
                    <a href="{{ route('admin.nilai.validasi') }}" class="bg-gray-200 hover:bg-signal hover:text-white text-void font-mono font-bold py-3 px-4 rounded-xl text-xs transition flex items-center justify-center uppercase">
                        RESET
                    </a>
                @endif
            </div>
        </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let searchTimeout = null;
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            if (searchInput.value.length > 0 && document.activeElement === searchInput) {
                const len = searchInput.value.length;
                searchInput.setSelectionRange(len, len);
            }

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });
        }
    });
</script>

    {{-- CARDS PER SISWA --}}
    <div class="space-y-6">
        @forelse($groupedNilais as $groupKey => $studentNilais)
            @php
                $first = $studentNilais->first();
                $siswa = $first->siswa;
                $kelasNama = $first->kelasTahunAjaran->kelas->nama_kelas ?? '-';
                $pendingCount = $studentNilais->where('status_validasi', '!=', 'validated')->count();
                $validCount = $studentNilais->where('status_validasi', 'validated')->count();
            @endphp
            <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
                {{-- Card Header Siswa --}}
                <div class="p-6 bg-gray-50 border-b border-black/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-void text-white font-mono font-bold flex items-center justify-center text-lg shadow-xs shrink-0">
                            {{ substr($siswa->nama_siswa ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-base font-black text-void uppercase">{{ $siswa->nama_siswa ?? '-' }} <span class="text-xs font-mono font-bold text-gray-500">({{ $siswa->nisn ?? '-' }})</span></h2>
                            <div class="flex items-center gap-2 mt-1 font-mono text-[10px] font-bold uppercase">
                                <span class="bg-gray-200 text-void px-2.5 py-0.5 rounded border border-black/5">{{ $kelasNama }}</span>
                                @if($pendingCount > 0)
                                    <span class="bg-void text-signal px-2.5 py-0.5 rounded border border-black">{{ $pendingCount }} MENUNGGU VALIDASI</span>
                                @else
                                    <span class="bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded border border-emerald-300">SEMUA VALID</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($pendingCount > 0)
                        <form action="{{ route('admin.nilai.validasi.submit') }}" method="POST" onsubmit="return confirm('Validasi semua nilai untuk {{ $siswa->nama_siswa }}?');">
                            @csrf
                            <input type="hidden" name="id_nilai" value="all_siswa">
                            <input type="hidden" name="siswa_id" value="{{ $siswa->id_siswa ?? $siswa->id }}">
                            <input type="hidden" name="kelas_tahun_ajaran_id" value="{{ $first->kelas_tahun_ajaran_id }}">
                            <button type="submit" class="px-5 py-2.5 bg-void hover:bg-black text-white font-mono font-bold rounded-xl text-xs shadow-xs transition inline-flex items-center gap-2 uppercase">
                                <i class="bi bi-check-all text-signal text-sm"></i> VALIDASI SISWA INI
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Card Table Nilai --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-surface text-void font-mono text-[10px] uppercase tracking-wider border-b border-black/10">
                                <th class="py-3.5 pl-6">MATA PELAJARAN</th>
                                <th class="py-3.5 text-center">TUGAS</th>
                                <th class="py-3.5 text-center">UTS</th>
                                <th class="py-3.5 text-center">UAS</th>
                                <th class="py-3.5 text-center">AKHIR</th>
                                <th class="py-3.5 text-center">STATUS</th>
                                <th class="py-3.5 pr-6 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/5 font-medium text-gray-700">
                            @foreach($studentNilais as $n)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="py-3.5 pl-6 font-bold text-void uppercase">
                                        {{ $n->mapel->nama_mapel ?? '-' }}
                                    </td>
                                    <td class="py-3.5 text-center font-mono text-gray-600">{{ $n->nilai_tugas ?? '-' }}</td>
                                    <td class="py-3.5 text-center font-mono text-gray-600">{{ $n->nilai_uts ?? '-' }}</td>
                                    <td class="py-3.5 text-center font-mono text-gray-600">{{ $n->nilai_uas ?? '-' }}</td>
                                    <td class="py-3.5 text-center font-mono font-black text-cobalt">{{ $n->nilai_akhir ?? '-' }}</td>
                                    <td class="py-3.5 text-center">
                                        @if($n->status_validasi === 'validated')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded font-mono text-[10px] font-bold uppercase bg-gray-100 text-cobalt border border-black/5">
                                                <i class="bi bi-check2 mr-1"></i> VALID
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded font-mono text-[10px] font-bold uppercase bg-void text-signal border border-black">
                                                MENUNGGU
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 pr-6 text-center">
                                        @if($n->status_validasi !== 'validated')
                                            <form action="{{ route('admin.nilai.validasi.submit') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="id_nilai" value="{{ $n->id }}">
                                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-void text-void hover:text-white font-mono font-bold text-[11px] shadow-2xs transition uppercase inline-flex items-center gap-1">
                                                    <i class="bi bi-check-lg text-signal"></i> VALIDASI
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[11px] text-gray-400 font-mono font-bold uppercase"><i class="bi bi-lock-fill"></i> SELESAI</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-black/10 p-16 text-center text-gray-400 font-mono">
                <i class="bi bi-inbox text-4xl block mb-2 text-gray-300"></i>
                <p class="font-bold text-void uppercase">BELUM ADA ENTRI NILAI YANG DITEMUKAN.</p>
                @if(request()->hasAny(['kelas_id', 'status_validasi', 'search']))
                    <p class="text-xs text-gray-500 mt-1 uppercase">Silakan coba reset filter Anda.</p>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection
