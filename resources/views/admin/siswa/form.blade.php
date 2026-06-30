<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi {{ isset($siswa) ? 'bi-person-gear' : 'bi-person-plus-fill' }} text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>{{ isset($siswa) ? 'PEMBARUAN DATA PESERTA DIDIK' : 'INPUT PESERTA DIDIK BARU' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? (isset($siswa) ? 'EDIT DATA SISWA' : 'TAMBAH SISWA BARU')) }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>FORMULIR RESMI KESISWAAN</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.siswa.index') }}"
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
    <form action="{{ isset($siswa) ? route('admin.siswa.update', $siswa->id) : route('admin.siswa.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($siswa))
            @method('PUT')
        @endif

        {{-- SECTION 1: Identitas Pribadi --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="bi bi-person-vcard text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">IDENTITAS PRIBADI</h3>
                    <p class="text-xs text-gray-400 font-mono">Informasi NISN, nama lengkap, dan data dasar siswa</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-mono text-xs">
                {{-- NISN --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">NISN <span class="text-signal">*</span></label>
                    <input type="text" name="nisn" required
                           value="{{ old('nisn', $siswa->nisn ?? '') }}"
                           placeholder="Contoh: 0091234567"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- NAMA SISWA --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">NAMA LENGKAP SISWA <span class="text-signal">*</span></label>
                    <input type="text" name="nama_siswa" required
                           value="{{ old('nama_siswa', $siswa->nama_siswa ?? $siswa->nama_lengkap ?? '') }}"
                           placeholder="Contoh: Ahmad Fauzi"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- JENIS KELAMIN --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">JENIS KELAMIN <span class="text-signal">*</span></label>
                    <select name="jenis_kelamin" required
                            class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void focus:bg-white focus:outline-none focus:border-void transition-all">
                        <option value="">-- PILIH JENIS KELAMIN --</option>
                        <option value="L" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L') ? 'selected' : '' }}>LAKI-LAKI</option>
                        <option value="P" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P') ? 'selected' : '' }}>PEREMPUAN</option>
                    </select>
                </div>

                {{-- AGAMA --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">AGAMA <span class="text-signal">*</span></label>
                    <input type="text" name="agama" required
                           value="{{ old('agama', $siswa->agama ?? 'Islam') }}"
                           placeholder="Contoh: Islam"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>
            </div>
        </div>

        {{-- SECTION 2: Kelahiran & Keluarga --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="bi bi-calendar-heart text-cobalt"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">KELAHIRAN & KELUARGA</h3>
                    <p class="text-xs text-gray-400 font-mono">Tempat tanggal lahir dan posisi dalam keluarga</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-mono text-xs">
                {{-- TEMPAT LAHIR --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">TEMPAT LAHIR <span class="text-signal">*</span></label>
                    <input type="text" name="tempat_lahir" required
                           value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                           placeholder="Contoh: Padang"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- TANGGAL LAHIR --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">TANGGAL LAHIR <span class="text-signal">*</span></label>
                    <input type="date" name="tanggal_lahir" required
                           value="{{ old('tanggal_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- STATUS KELUARGA --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">STATUS DALAM KELUARGA</label>
                    <input type="text" name="status_keluarga"
                           value="{{ old('status_keluarga', $siswa->status_keluarga ?? 'Anak Kandung') }}"
                           placeholder="Contoh: Anak Kandung"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- ANAK KE --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">ANAK KE-</label>
                    <input type="number" name="anak_ke"
                           value="{{ old('anak_ke', $siswa->anak_ke ?? '1') }}"
                           placeholder="Contoh: 1"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>
            </div>
        </div>

        {{-- SECTION 3: Kontak & Akademik --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="bi bi-mortarboard text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">KONTAK & AKADEMIK</h3>
                    <p class="text-xs text-gray-400 font-mono">Nomor telepon serta riwayat penerimaan di sekolah</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-mono text-xs">
                {{-- NO HP --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">NOMOR TELEPON / HP</label>
                    <input type="text" name="telp_siswa"
                           value="{{ old('telp_siswa', $siswa->telp_siswa ?? '') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- SEKOLAH ASAL --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">SEKOLAH ASAL</label>
                    <input type="text" name="sekolah_asal"
                           value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? 'SDN 01 Durian Gadang') }}"
                           placeholder="Contoh: TK / SDN 01 Durian Gadang"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- TANGGAL DITERIMA --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">TANGGAL DITERIMA</label>
                    <input type="date" name="tanggal_diterima"
                           value="{{ old('tanggal_diterima', isset($siswa->tanggal_diterima) ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('Y-m-d') : date('Y-m-d')) }}"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>
            </div>
        </div>

        {{-- SECTION 4: Alamat Domisili --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="bi bi-geo-alt text-cobalt"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">ALAMAT DOMISILI</h3>
                    <p class="text-xs text-gray-400 font-mono">Alamat lengkap tempat tinggal siswa saat ini</p>
                </div>
            </div>

            <div class="font-mono text-xs">
                <label class="block font-bold text-void uppercase tracking-wider mb-2">ALAMAT LENGKAP</label>
                <textarea name="alamat_siswa" rows="3"
                          placeholder="Contoh: Jl. Raya Durian Gadang No. 12, Kec. Akabiluru"
                          class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl p-4 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all leading-relaxed">{{ old('alamat_siswa', $siswa->alamat_siswa ?? $siswa->alamat ?? '') }}</textarea>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4 font-mono text-xs">
            <span class="text-gray-400 font-bold flex items-center gap-2">
                <i class="bi bi-info-circle text-cobalt"></i>
                PASTIKAN SELURUH DATA BERTANDA BINTANG (*) WAJIB DIISI DENGAN BENAR.
            </span>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.siswa.index') }}"
                   class="px-6 py-3.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-void font-bold transition text-center w-full sm:w-auto uppercase">
                    BATAL
                </a>
                <button type="submit"
                        class="px-8 py-3.5 rounded-xl bg-void hover:bg-black text-white font-bold shadow-md transition text-center w-full sm:w-auto inline-flex items-center justify-center gap-2 uppercase">
                    <span>SIMPAN DATA SISWA</span>
                    <i class="bi bi-check-lg text-signal"></i>
                </button>
            </div>
        </div>

    </form>
</div>