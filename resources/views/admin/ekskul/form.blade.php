<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi {{ isset($ekskul) ? 'bi-trophy-fill' : 'bi-award-fill' }} text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>{{ isset($ekskul) ? 'PEMBARUAN KEGIATAN' : 'INPUT EKSKUL BARU' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? (isset($ekskul) ? 'EDIT EKSTRAKURIKULER' : 'TAMBAH EKSTRAKURIKULER BARU')) }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>FORMULIR RESMI KEGIATAN SISWA</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.ekskul.index') }}"
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
    <form action="{{ isset($ekskul) ? route('admin.ekskul.update', $ekskul->id_ekskul ?? $ekskul->id) : route('admin.ekskul.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($ekskul))
            @method('PUT')
        @endif

        {{-- SECTION 1: Detail Ekstrakurikuler --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-black/10">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold">
                    <i class="bi bi-dribbble text-lg text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void tracking-tight uppercase">RINCIAN EKSTRAKURIKULER</h3>
                    <p class="text-xs text-gray-500 font-mono uppercase">Tentukan penamaan kegiatan ekstrakurikuler dan guru pembinanya</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">NAMA EKSTRAKURIKULER <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ekskul" required
                           value="{{ old('nama_ekskul', $ekskul->nama_ekskul ?? '') }}"
                           placeholder="Contoh: PRAMUKA / FUTSAL / SENI TARI"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">GURU PEMBINA</label>
                    <select name="id_guru"
                            class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                        <option value="">-- PILIH GURU PEMBINA --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id }}" {{ old('id_guru', $ekskul->id_guru ?? '') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_lengkap }} ({{ $g->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">KETERANGAN / JADWAL KEGIATAN</label>
                    <textarea name="keterangan" rows="3"
                              placeholder="Contoh: DILAKSANAKAN SETIAP HARI SABTU PUKUL 14.00 DI LAPANGAN SEKOLAH..."
                              class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl p-4 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all leading-relaxed uppercase">{{ old('keterangan', $ekskul->keterangan ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-gray-500 font-mono font-bold flex items-center gap-2 uppercase">
                <i class="bi bi-info-circle text-cobalt text-base"></i> Pastikan seluruh data bertanda bintang (*) wajib diisi dengan benar.
            </span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.ekskul.index') }}"
                   class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-void font-mono font-bold text-xs transition uppercase text-center w-full sm:w-auto">
                    BATAL
                </a>
                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase text-center w-full sm:w-auto inline-flex items-center justify-center gap-2">
                    <i class="bi bi-check2 text-signal"></i> SIMPAN KEGIATAN EKSKUL
                </button>
            </div>
        </div>

    </form>
</div>
