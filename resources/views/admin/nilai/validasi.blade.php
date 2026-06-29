@extends('admin.layout')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Validasi Nilai Siswa</h1>
            <p class="text-sm text-slate-500 mt-1">Periksa dan setujui nilai yang telah disubmit oleh guru mata pelajaran per siswa.</p>
        </div>
        @if($nilais->where('status_validasi', '!=', 'validated')->count() > 0)
            <form action="{{ route('admin.nilai.validasi.submit') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memvalidasi semua nilai yang menunggu di seluruh kelas?');">
                @csrf
                <input type="hidden" name="id_nilai" value="all">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow transition">
                    <i class="bi bi-check2-all"></i>
                    <span>Validasi Semua Nilai (Global)</span>
                </button>
            </form>
        @endif
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
        <form action="{{ route('admin.nilai.validasi') }}" method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Kelas</label>
                <select name="kelas_id" onchange="document.getElementById('filterForm').submit()" class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 bg-slate-50 border-slate-300">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $kta)
                        <option value="{{ $kta->id }}" {{ request('kelas_id') == $kta->id ? 'selected' : '' }}>
                            {{ $kta->kelas->nama_kelas ?? '-' }} ({{ $kta->tahunAjaran->tahun_ajaran ?? '' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Status Validasi</label>
                <select name="status_validasi" onchange="document.getElementById('filterForm').submit()" class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 bg-slate-50 border-slate-300">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status_validasi') == 'pending' ? 'selected' : '' }}>Menunggu Validasi</option>
                    <option value="validated" {{ request('status_validasi') == 'validated' ? 'selected' : '' }}>Sudah Valid</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Cari Siswa</label>
                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Ketik nama atau NISN..." class="w-full border rounded-xl pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 bg-slate-50 border-slate-300">
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl text-sm transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                @if(request()->hasAny(['kelas_id', 'status_validasi', 'search']))
                    <a href="{{ route('admin.nilai.validasi') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-2 px-4 rounded-xl text-sm transition flex items-center justify-center">
                        Reset
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
            // Jika ada teks pencarian saat reload, kembalikan fokus ke ujung teks agar user bisa langsung melanjutkan ketikan
            if (searchInput.value.length > 0 && document.activeElement === searchInput) {
                const len = searchInput.value.length;
                searchInput.setSelectionRange(len, len);
            }

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500); // Tunggu 500ms setelah user berhenti mengetik
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
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                {{-- Card Header Siswa --}}
                <div class="p-5 bg-slate-50/80 border-b border-slate-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-lg shadow-inner">
                            {{ substr($siswa->nama_siswa ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-800">{{ $siswa->nama_siswa ?? '-' }} <span class="text-xs font-mono font-normal text-slate-500">({{ $siswa->nisn ?? '-' }})</span></h2>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs bg-slate-200/80 text-slate-700 px-2.5 py-0.5 rounded-md font-semibold">{{ $kelasNama }}</span>
                                @if($pendingCount > 0)
                                    <span class="text-xs bg-amber-100 text-amber-800 px-2.5 py-0.5 rounded-md font-semibold">{{ $pendingCount }} Menunggu Validasi</span>
                                @else
                                    <span class="text-xs bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-md font-semibold">Semua Valid</span>
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
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-sm transition inline-flex items-center gap-1.5">
                                <i class="bi bi-check-all text-sm"></i> Validasi Siswa Ini
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Card Table Nilai --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-semibold border-b border-slate-100">
                                <th class="py-3 px-6">Mata Pelajaran</th>
                                <th class="py-3 px-6 text-center">Tugas</th>
                                <th class="py-3 px-6 text-center">UTS</th>
                                <th class="py-3 px-6 text-center">UAS</th>
                                <th class="py-3 px-6 text-center">Akhir</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($studentNilais as $n)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-6 font-semibold text-slate-800">
                                        {{ $n->mapel->nama_mapel ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-6 text-center text-slate-600">{{ $n->nilai_tugas ?? '-' }}</td>
                                    <td class="py-3.5 px-6 text-center text-slate-600">{{ $n->nilai_uts ?? '-' }}</td>
                                    <td class="py-3.5 px-6 text-center text-slate-600">{{ $n->nilai_uas ?? '-' }}</td>
                                    <td class="py-3.5 px-6 text-center font-extrabold text-indigo-600">{{ $n->nilai_akhir ?? '-' }}</td>
                                    <td class="py-3.5 px-6 text-center">
                                        @if($n->status_validasi === 'validated')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="bi bi-check2 mr-1"></i> Valid
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        @if($n->status_validasi !== 'validated')
                                            <form action="{{ route('admin.nilai.validasi.submit') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="id_nilai" value="{{ $n->id }}">
                                                <button type="submit" class="px-3 py-1 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-xs font-semibold shadow-sm transition">
                                                    <i class="bi bi-check-lg mr-1"></i> Validasi
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400 font-medium"><i class="bi bi-lock-fill"></i> Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-400">
                <i class="bi bi-inbox text-4xl block mb-2"></i>
                <p class="font-medium text-slate-600">Belum ada entri nilai yang ditemukan.</p>
                @if(request()->hasAny(['kelas_id', 'status_validasi', 'search']))
                    <p class="text-xs text-slate-400 mt-1">Silakan coba reset filter Anda.</p>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection
