<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi {{ isset($siswa) ? 'bi-person-gear' : 'bi-person-plus-fill' }} text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50/80 text-blue-700 ring-1 ring-blue-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>{{ isset($siswa) ? 'Pembaruan Data Peserta Didik' : 'Input Peserta Didik Baru' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? (isset($siswa) ? 'Edit Data Siswa' : 'Tambah Siswa Baru') }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-blue-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Formulir Resmi Kesiswaan Sekolah</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.siswa.index') }}"
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
    <form action="{{ isset($siswa) ? route('admin.siswa.update', $siswa->id) : route('admin.siswa.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($siswa))
            @method('PUT')
        @endif

        {{-- SECTION 1: Identitas Pribadi (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-blue-500/20">
                    <i class="bi bi-person-vcard text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Identitas Pribadi</h3>
                    <p class="text-xs text-slate-400 font-semibold">Informasi NISN, nama lengkap, dan data dasar siswa</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- NISN --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">NISN <span class="text-rose-500">*</span></label>
                    <input type="text" name="nisn" required
                           value="{{ old('nisn', $siswa->nisn ?? '') }}"
                           placeholder="Contoh: 0091234567"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- NAMA SISWA --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_siswa" required
                           value="{{ old('nama_siswa', $siswa->nama_siswa ?? '') }}"
                           placeholder="Contoh: Ahmad Fauzi"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- JENIS KELAMIN --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jenis_kelamin" required
                            class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- AGAMA --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Agama <span class="text-rose-500">*</span></label>
                    <input type="text" name="agama" required
                           value="{{ old('agama', $siswa->agama ?? 'Islam') }}"
                           placeholder="Contoh: Islam"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>
            </div>
        </div>

        {{-- SECTION 2: Kelahiran & Keluarga (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-500/20">
                    <i class="bi bi-calendar-heart text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Kelahiran & Keluarga</h3>
                    <p class="text-xs text-slate-400 font-semibold">Tempat tanggal lahir dan posisi dalam keluarga</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- TEMPAT LAHIR --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Tempat Lahir <span class="text-rose-500">*</span></label>
                    <input type="text" name="tempat_lahir" required
                           value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                           placeholder="Contoh: Padang"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- TANGGAL LAHIR --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Tanggal Lahir <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_lahir" required
                           value="{{ old('tanggal_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- STATUS KELUARGA --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Status dalam Keluarga</label>
                    <input type="text" name="status_keluarga"
                           value="{{ old('status_keluarga', $siswa->status_keluarga ?? 'Anak Kandung') }}"
                           placeholder="Contoh: Anak Kandung"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- ANAK KE --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Anak Ke-</label>
                    <input type="number" name="anak_ke"
                           value="{{ old('anak_ke', $siswa->anak_ke ?? '1') }}"
                           placeholder="Contoh: 1"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>
            </div>
        </div>

        {{-- SECTION 3: Kontak & Akademik (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 text-white flex items-center justify-center font-bold shadow-md shadow-teal-500/20">
                    <i class="bi bi-mortarboard text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Kontak & Akademik</h3>
                    <p class="text-xs text-slate-400 font-semibold">Nomor telepon serta riwayat penerimaan di sekolah</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- NO HP --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nomor Telepon / HP</label>
                    <input type="text" name="telp_siswa"
                           value="{{ old('telp_siswa', $siswa->telp_siswa ?? '') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- SEKOLAH ASAL --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Sekolah Asal</label>
                    <input type="text" name="sekolah_asal"
                           value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? 'SDN 01 Durian Gadang') }}"
                           placeholder="Contoh: TK / SDN 01 Durian Gadang"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- TANGGAL DITERIMA --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Tanggal Diterima</label>
                    <input type="date" name="tanggal_diterima"
                           value="{{ old('tanggal_diterima', $siswa->tanggal_diterima ?? date('Y-m-d')) }}"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>
            </div>
        </div>

        {{-- SECTION 4: Alamat Domisili (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center font-bold shadow-md shadow-rose-500/20">
                    <i class="bi bi-geo-alt text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Alamat Domisili</h3>
                    <p class="text-xs text-slate-400 font-semibold">Alamat lengkap tempat tinggal siswa saat ini</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                <textarea name="alamat_siswa" rows="3"
                          placeholder="Contoh: Jl. Raya Durian Gadang No. 12, Kec. Akabiluru"
                          class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl p-4 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner leading-relaxed">{{ old('alamat_siswa', $siswa->alamat_siswa ?? '') }}</textarea>
            </div>
        </div>

        {{-- TOMBOL AKSI (Floating Elevation Card) --}}
        <div class="bg-white rounded-[2.2rem] p-6 sm:p-8 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-slate-400 font-bold flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-black">
                    <i class="bi bi-info-circle text-xs"></i>
                </div>
                Pastikan seluruh data bertanda bintang (*) wajib diisi dengan benar.
            </span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.siswa.index') }}"
                   class="px-6 py-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition active:scale-95 text-center w-full sm:w-auto">
                    Batal
                </a>
                <button type="submit"
                        class="group px-8 py-3.5 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 transition-all duration-300 active:scale-[0.98] text-center w-full sm:w-auto inline-flex items-center justify-center gap-3">
                    <span>Simpan Data Siswa</span>
                    <div class="w-7 h-7 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform group-hover:translate-x-0.5">
                        <i class="bi bi-check2 text-sm font-black"></i>
                    </div>
                </button>
            </div>
        </div>

    </form>
</div>