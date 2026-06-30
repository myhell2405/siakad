<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi {{ isset($tahunAjaran) ? 'bi-calendar-check-fill' : 'bi-calendar-plus-fill' }} text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>{{ isset($tahunAjaran) ? 'PEMBARUAN KALENDER' : 'INPUT TAHUN BARU' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? (isset($tahunAjaran) ? 'EDIT TAHUN AJARAN' : 'TAMBAH TAHUN AJARAN BARU')) }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>PENGATURAN PERIODE AKADEMIK</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.tahun-ajaran.index') }}"
           class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-gray-100 hover:bg-void hover:text-white text-void font-mono font-bold text-xs transition border border-black/10 uppercase">
            <i class="bi bi-arrow-left"></i> KEMBALI
        </a>
    </div>

    {{-- ALERT ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-500/30 text-red-900 p-6 rounded-2xl shadow-xs space-y-3 font-mono">
            <div class="flex items-center gap-3 font-bold text-sm text-red-800">
                <i class="bi bi-exclamation-triangle-fill text-red-600 text-lg"></i>
                <span>PERIKSA KEMBALI ISIAN YANG KURANG TEPAT:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-semibold space-y-1 ml-7 text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM UTAMA --}}
    <form action="{{ isset($tahunAjaran) ? route('admin.tahun-ajaran.update', $tahunAjaran->id_tahun_ajaran ?? $tahunAjaran->id) : route('admin.tahun-ajaran.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($tahunAjaran))
            @method('PUT')
        @endif

        {{-- SECTION 1: Periode & Status --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-black/10">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold">
                    <i class="bi bi-calendar-range text-lg text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void tracking-tight uppercase">RINCIAN PERIODE AKADEMIK</h3>
                    <p class="text-xs text-gray-500 font-mono uppercase">Tentukan rentang tahun pelajaran, semester, dan status keaktifan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">TAHUN MULAI <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun_mulai" required min="2000" max="2100"
                           value="{{ old('tahun_mulai', $tahunAjaran->tahun_mulai ?? date('Y')) }}"
                           placeholder="Contoh: 2024"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">TAHUN SELESAI <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun_selesai" required min="2000" max="2100"
                           value="{{ old('tahun_selesai', $tahunAjaran->tahun_selesai ?? (date('Y') + 1)) }}"
                           placeholder="Contoh: 2025"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">SEMESTER <span class="text-red-500">*</span></label>
                    <select name="semester" required
                            class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                        <option value="">-- PILIH SEMESTER --</option>
                        <option value="ganjil" {{ old('semester', $tahunAjaran->semester ?? '') == 'ganjil' ? 'selected' : '' }}>GANJIL (SEMESTER 1)</option>
                        <option value="genap" {{ old('semester', $tahunAjaran->semester ?? '') == 'genap' ? 'selected' : '' }}>GENAP (SEMESTER 2)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">STATUS TAHUN AJARAN <span class="text-red-500">*</span></label>
                    <select name="status" required
                            class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                        <option value="aktif" {{ old('status', $tahunAjaran->status ?? '') == 'aktif' ? 'selected' : '' }}>AKTIF</option>
                        <option value="tidak_aktif" {{ old('status', $tahunAjaran->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>TIDAK AKTIF</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-gray-500 font-mono font-bold flex items-center gap-2 uppercase">
                <i class="bi bi-info-circle text-cobalt text-base"></i> Catatan: Jika mengaktifkan periode ini, periode aktif lain akan otomatis dinonaktifkan.
            </span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.tahun-ajaran.index') }}"
                   class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-void font-mono font-bold text-xs transition uppercase text-center w-full sm:w-auto">
                    BATAL
                </a>
                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase text-center w-full sm:w-auto inline-flex items-center justify-center gap-2">
                    <i class="bi bi-check2 text-signal"></i> SIMPAN TAHUN AJARAN
                </button>
            </div>
        </div>

    </form>
</div>
