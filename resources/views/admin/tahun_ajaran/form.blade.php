<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-amber-500/10 via-orange-500/10 to-yellow-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center shadow-lg shadow-amber-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi {{ isset($tahunAjaran) ? 'bi-calendar-check-fill' : 'bi-calendar-plus-fill' }} text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-amber-50/80 text-amber-700 ring-1 ring-amber-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-600"></span>
                    </span>
                    <span>{{ isset($tahunAjaran) ? 'Pembaruan Kalender' : 'Input Tahun Baru' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? (isset($tahunAjaran) ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran Baru') }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-amber-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Pengaturan Periode Akademik</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.tahun-ajaran.index') }}"
           class="group relative z-10 inline-flex items-center gap-3 pl-5 pr-2 py-2 bg-slate-100 hover:bg-slate-900 text-slate-700 hover:text-white font-bold text-xs rounded-full transition-all duration-300 active:scale-[0.98] w-full sm:w-auto justify-between sm:justify-start shadow-2xs">
            <span>Kembali ke Daftar</span>
            <div class="w-7 h-7 rounded-full bg-white group-hover:bg-white/20 flex items-center justify-center text-slate-800 group-hover:text-white transition-transform group-hover:-translate-x-0.5 shadow-2xs">
                <i class="bi bi-arrow-left text-xs font-black"></i>
            </div>
        </a>
    </div>

    {{-- ================================================
         ALERT ERROR VALIDASI
         ================================================ --}}
    @if ($errors->any())
        <div class="bg-gradient-to-r from-rose-50 to-red-50 ring-1 ring-rose-500/20 text-rose-900 p-6 rounded-[2rem] shadow-sm animate-fade-in space-y-3">
            <div class="flex items-center gap-3 font-black text-sm text-rose-800">
                <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-md shadow-rose-500/20">
                    <i class="bi bi-exclamation-triangle-fill text-sm font-black"></i>
                </div>
                <span>Periksa kembali beberapa isian yang belum memenuhi syarat:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-bold space-y-1.5 ml-11 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================================================
         FORM UTAMA
         ================================================ --}}
    <form action="{{ isset($tahunAjaran) ? route('admin.tahun-ajaran.update', $tahunAjaran->id_tahun_ajaran ?? $tahunAjaran->id) : route('admin.tahun-ajaran.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($tahunAjaran))
            @method('PUT')
        @endif

        {{-- SECTION 1: Periode & Status (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center font-bold shadow-md shadow-amber-500/20">
                    <i class="bi bi-calendar-range text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Rincian Periode Akademik</h3>
                    <p class="text-xs text-slate-400 font-semibold">Tentukan rentang tahun pelajaran, semester, dan status keaktifan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- TAHUN MULAI --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Tahun Mulai <span class="text-rose-500">*</span></label>
                    <input type="number" name="tahun_mulai" required min="2000" max="2100"
                           value="{{ old('tahun_mulai', $tahunAjaran->tahun_mulai ?? date('Y')) }}"
                           placeholder="Contoh: 2024"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition-all shadow-inner">
                </div>

                {{-- TAHUN SELESAI --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Tahun Selesai <span class="text-rose-500">*</span></label>
                    <input type="number" name="tahun_selesai" required min="2000" max="2100"
                           value="{{ old('tahun_selesai', $tahunAjaran->tahun_selesai ?? (date('Y') + 1)) }}"
                           placeholder="Contoh: 2025"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition-all shadow-inner">
                </div>

                {{-- SEMESTER --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Semester <span class="text-rose-500">*</span></label>
                    <select name="semester" required
                            class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition-all shadow-inner">
                        <option value="">-- Pilih Semester --</option>
                        <option value="ganjil" {{ old('semester', $tahunAjaran->semester ?? '') == 'ganjil' ? 'selected' : '' }}>Ganjil (Semester 1)</option>
                        <option value="genap" {{ old('semester', $tahunAjaran->semester ?? '') == 'genap' ? 'selected' : '' }}>Genap (Semester 2)</option>
                    </select>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Status Tahun Ajaran <span class="text-rose-500">*</span></label>
                    <select name="status" required
                            class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition-all shadow-inner">
                        <option value="aktif" {{ old('status', $tahunAjaran->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $tahunAjaran->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI (Floating Elevation Card) --}}
        <div class="bg-white rounded-[2.2rem] p-6 sm:p-8 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-slate-400 font-bold flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-black">
                    <i class="bi bi-info-circle text-xs"></i>
                </div>
                Catatan: Jika mengaktifkan tahun ajaran ini, tahun ajaran aktif lainnya akan otomatis dinonaktifkan.
            </span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.tahun-ajaran.index') }}"
                   class="px-6 py-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition active:scale-95 text-center w-full sm:w-auto">
                    Batal
                </a>
                <button type="submit"
                        class="group px-8 py-3.5 rounded-full bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold text-xs shadow-lg shadow-amber-500/25 transition-all duration-300 active:scale-[0.98] text-center w-full sm:w-auto inline-flex items-center justify-center gap-3">
                    <span>Simpan Tahun Ajaran</span>
                    <div class="w-7 h-7 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform group-hover:translate-x-0.5">
                        <i class="bi bi-check2 text-sm font-black"></i>
                    </div>
                </button>
            </div>
        </div>

    </form>
</div>
