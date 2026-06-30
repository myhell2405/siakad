<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi {{ isset($kelas) ? 'bi-door-open-fill' : 'bi-plus-square-dotted' }} text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>{{ isset($kelas) ? 'PEMBARUAN ROMBEL' : 'INPUT ROMBEL BARU' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? (isset($kelas) ? 'EDIT DATA KELAS' : 'TAMBAH KELAS BARU')) }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>FORMULIR ROMBONGAN BELAJAR</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.kelas.index') }}"
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white hover:bg-gray-50 text-void border border-black/10 font-mono font-bold text-xs transition shadow-2xs uppercase">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>KEMBALI KE DAFTAR</span>
        </a>
    </div>

    {{-- ALERT ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-900 p-6 rounded-3xl shadow-xs space-y-3 font-mono">
            <div class="flex items-center gap-3 font-bold text-sm text-red-800">
                <div class="w-8 h-8 rounded-xl bg-signal text-white flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle-fill text-xs"></i>
                </div>
                <span class="uppercase">PERIKSA KEMBALI BEBERAPA ISIAN YANG BELUM VALID:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-bold space-y-1.5 ml-11 text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM UTAMA --}}
    <form action="{{ isset($kelas) ? route('admin.kelas.update', $kelas->id_kelas ?? $kelas->id) : route('admin.kelas.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($kelas))
            @method('PUT')
        @endif

        {{-- SECTION 1: Rincian Kelas --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="bi bi-grid-1x2-fill text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">RINCIAN ROMBONGAN BELAJAR</h3>
                    <p class="text-xs text-gray-400 font-mono">Tentukan tingkat jenjang pendidikan dan penamaan kelas</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-mono text-xs">
                {{-- TINGKAT KELAS --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">TINGKAT KELAS <span class="text-signal">*</span></label>
                    <select name="tingkat_kelas" required
                            class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void focus:bg-white focus:outline-none focus:border-void transition-all">
                        <option value="">-- PILIH TINGKAT KELAS --</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ old('tingkat_kelas', $kelas->tingkat_kelas ?? '') == $i ? 'selected' : '' }}>
                                KELAS {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- NAMA KELAS --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">NAMA KELAS <span class="text-signal">*</span></label>
                    <input type="text" name="nama_kelas" required
                           value="{{ old('nama_kelas', $kelas->nama_kelas ?? '') }}"
                           placeholder="Contoh: Kelas 1 A / Kelas 6 Unggulan"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4 font-mono text-xs">
            <span class="text-gray-400 font-bold flex items-center gap-2">
                <i class="bi bi-info-circle text-cobalt"></i>
                PASTIKAN SELURUH DATA BERTANDA BINTANG (*) WAJIB DIISI DENGAN BENAR.
            </span>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.kelas.index') }}"
                   class="px-6 py-3.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-void font-bold transition text-center w-full sm:w-auto uppercase">
                    BATAL
                </a>
                <button type="submit"
                        class="px-8 py-3.5 rounded-xl bg-void hover:bg-black text-white font-bold shadow-md transition text-center w-full sm:w-auto inline-flex items-center justify-center gap-2 uppercase">
                    <span>SIMPAN DATA KELAS</span>
                    <i class="bi bi-check-lg text-signal"></i>
                </button>
            </div>
        </div>

    </form>
</div>