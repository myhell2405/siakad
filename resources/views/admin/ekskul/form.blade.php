<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-violet-500/10 via-purple-500/10 to-fuchsia-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-600 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-violet-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi {{ isset($ekskul) ? 'bi-trophy-fill' : 'bi-award-fill' }} text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-violet-50/80 text-violet-700 ring-1 ring-violet-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-600"></span>
                    </span>
                    <span>{{ isset($ekskul) ? 'Pembaruan Kegiatan' : 'Input Ekskul Baru' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? (isset($ekskul) ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler Baru') }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-violet-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Formulir Resmi Kegiatan Siswa</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.ekskul.index') }}"
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
    <form action="{{ isset($ekskul) ? route('admin.ekskul.update', $ekskul->id_ekskul ?? $ekskul->id) : route('admin.ekskul.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($ekskul))
            @method('PUT')
        @endif

        {{-- SECTION 1: Detail Ekstrakurikuler (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 text-white flex items-center justify-center font-bold shadow-md shadow-violet-500/20">
                    <i class="bi bi-dribbble text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Rincian Ekstrakurikuler</h3>
                    <p class="text-xs text-slate-400 font-semibold">Tentukan penamaan kegiatan ekstrakurikuler dan guru pembinanya</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- NAMA EKSKUL --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nama Ekstrakurikuler <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_ekskul" required
                           value="{{ old('nama_ekskul', $ekskul->nama_ekskul ?? '') }}"
                           placeholder="Contoh: Pramuka / Futsal / Seni Tari"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-violet-500/15 focus:border-violet-600 transition-all shadow-inner">
                </div>

                {{-- GURU PEMBINA --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Guru Pembina</label>
                    <select name="id_guru"
                            class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-violet-500/15 focus:border-violet-600 transition-all shadow-inner">
                        <option value="">-- Pilih Guru Pembina --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id }}" {{ old('id_guru', $ekskul->id_guru ?? '') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_lengkap }} ({{ $g->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- KETERANGAN --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Keterangan / Jadwal Kegiatan</label>
                    <textarea name="keterangan" rows="3"
                              placeholder="Contoh: Dilaksanakan setiap hari Sabtu pukul 14.00 di lapangan sekolah..."
                              class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl p-4 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-violet-500/15 focus:border-violet-600 transition-all shadow-inner leading-relaxed">{{ old('keterangan', $ekskul->keterangan ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI (Floating Elevation Card) --}}
        <div class="bg-white rounded-[2.2rem] p-6 sm:p-8 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-slate-400 font-bold flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center font-black">
                    <i class="bi bi-info-circle text-xs"></i>
                </div>
                Pastikan seluruh data bertanda bintang (*) wajib diisi dengan benar.
            </span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.ekskul.index') }}"
                   class="px-6 py-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition active:scale-95 text-center w-full sm:w-auto">
                    Batal
                </a>
                <button type="submit"
                        class="group px-8 py-3.5 rounded-full bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-bold text-xs shadow-lg shadow-violet-500/25 transition-all duration-300 active:scale-[0.98] text-center w-full sm:w-auto inline-flex items-center justify-center gap-3">
                    <span>Simpan Kegiatan Ekskul</span>
                    <div class="w-7 h-7 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform group-hover:translate-x-0.5">
                        <i class="bi bi-check2 text-sm font-black"></i>
                    </div>
                </button>
            </div>
        </div>

    </form>
</div>
