<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi {{ isset($guru) ? 'bi-person-gear' : 'bi-person-plus-fill' }} text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50/80 text-blue-700 ring-1 ring-blue-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>{{ isset($guru) ? 'Pembaruan Data Resmi' : 'Input Data Baru' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? (isset($guru) ? 'Edit Data Pendidik' : 'Tambah Pendidik Baru') }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-blue-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Formulir Resmi Kepegawaian Sekolah</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.guru.index') }}"
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
    <form action="{{ isset($guru) ? route('admin.guru.update', $guru->id) : route('admin.guru.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($guru))
            @method('PUT')
        @endif

        {{-- SECTION 1: Identitas & Kepegawaian (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-blue-500/20">
                    <i class="bi bi-person-badge text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Identitas & Kepegawaian</h3>
                    <p class="text-xs text-slate-400 font-semibold">Informasi nomor induk, gelar akademik, dan profil pendidik</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- NIP --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" name="nip" required
                           value="{{ old('nip', $guru->nip ?? '') }}"
                           placeholder="Contoh: 198501152010011005 (Ketik '-' jika tidak ada)"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- NUPTK --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">NUPTK</label>
                    <input type="text" name="nuptk" required
                           value="{{ old('nuptk', $guru->nuptk ?? '') }}"
                           placeholder="Contoh: 1234567890123456 (Ketik '-' jika tidak ada)"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- NAMA LENGKAP --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar Akademik</label>
                    <input type="text" name="nama_lengkap" required
                           value="{{ old('nama_lengkap', $guru->nama_lengkap ?? '') }}"
                           placeholder="Contoh: Susi Susanti, S.Pd.SD"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- TEMPAT LAHIR --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" required
                           value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}"
                           placeholder="Contoh: Payakumbuh"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- TANGGAL LAHIR --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required
                           value="{{ old('tanggal_lahir', isset($guru->tanggal_lahir) ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('Y-m-d') : '') }}"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- JENIS KELAMIN --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required
                            class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                        <option value="">-- Pilih Gender --</option>
                        <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- PENDIDIKAN --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" required
                           value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir ?? '') }}"
                           placeholder="Contoh: S1 Pendidikan Guru Sekolah Dasar (PGSD)"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- JABATAN GURU --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Jabatan Guru</label>
                    <input type="text" name="jabatan_guru" required
                           value="{{ old('jabatan_guru', $guru->jabatan_guru ?? '') }}"
                           placeholder="Contoh: Guru Kelas / Guru PAI"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- PANGKAT / GOLONGAN --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Pangkat & Golongan</label>
                    <input type="text" name="pangkat_gol" required
                           value="{{ old('pangkat_gol', $guru->pangkat_gol ?? '') }}"
                           placeholder="Contoh: III.b (Ketik '-' jika Non-PNS)"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- STATUS AKTIF --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Status Kepegawaian</label>
                    <select name="status" required
                            class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif" {{ old('status', $guru->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif Mengajar</option>
                        <option value="Tidak Aktif" {{ old('status', $guru->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Non-Aktif (Cuti / Pensiun / Mutasi)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- SECTION 2: Alamat & Domisili (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-bold shadow-md shadow-emerald-500/20">
                    <i class="bi bi-geo-alt-fill text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Domisili & Alamat</h3>
                    <p class="text-xs text-slate-400 font-semibold">Tempat tinggal tenaga pendidik saat ini</p>
                </div>
            </div>

            <div class="space-y-6">
                {{-- ALAMAT LENGKAP --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Alamat Jalan / RT / RW</label>
                    <textarea name="alamat" rows="3" required
                              placeholder="Contoh: Jl. Raya Durian Gadang No. 15"
                              class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    {{-- KENAGARIAN --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nagari / Kelurahan</label>
                        <input type="text" name="kenagarian" required
                               value="{{ old('kenagarian', $guru->kenagarian ?? 'Durian Gadang') }}"
                               placeholder="Nagari"
                               class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                    </div>

                    {{-- KECAMATAN --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Kecamatan</label>
                        <input type="text" name="kecamatan" required
                               value="{{ old('kecamatan', $guru->kecamatan ?? 'Akabiluru') }}"
                               placeholder="Kecamatan"
                               class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                    </div>

                    {{-- KAB/KOTA --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Kabupaten / Kota</label>
                        <input type="text" name="kab_kota" required
                               value="{{ old('kab_kota', $guru->kab_kota ?? 'Lima Puluh Kota') }}"
                               placeholder="Kabupaten"
                               class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                    </div>

                    {{-- PROVINSI --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Provinsi</label>
                        <input type="text" name="provinsi" required
                               value="{{ old('provinsi', $guru->provinsi ?? 'Sumatera Barat') }}"
                               placeholder="Provinsi"
                               class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: Kontak & Komunikasi (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center font-bold shadow-md shadow-amber-500/20">
                    <i class="bi bi-headset text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Kontak & Komunikasi</h3>
                    <p class="text-xs text-slate-400 font-semibold">Nomor telepon dan alamat email aktif untuk notifikasi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- NO TELEPON --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp / Telepon</label>
                    <input type="text" name="no_telepon" required
                           value="{{ old('no_telepon', $guru->no_telepon ?? '') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" name="email" required
                           value="{{ old('email', $guru->email ?? '') }}"
                           placeholder="Contoh: guru@sdn01duriangadang.sch.id"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI (Floating Elevation Card) --}}
        <div class="bg-white rounded-[2.2rem] p-6 sm:p-8 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-slate-400 font-bold flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-black">
                    <i class="bi bi-info-circle text-xs"></i>
                </div>
                Pastikan seluruh data bertanda bintang wajib diisi dengan presisi.
            </span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.guru.index') }}"
                   class="px-6 py-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition active:scale-95 text-center w-full sm:w-auto">
                    Batal
                </a>
                <button type="submit"
                        class="group px-8 py-3.5 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 transition-all duration-300 active:scale-[0.98] text-center w-full sm:w-auto inline-flex items-center justify-center gap-3">
                    <span>Simpan Data Pendidik</span>
                    <div class="w-7 h-7 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform group-hover:translate-x-0.5">
                        <i class="bi bi-check2 text-sm font-black"></i>
                    </div>
                </button>
            </div>
        </div>

    </form>
</div>