<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi {{ isset($guru) ? 'bi-person-gear' : 'bi-person-plus-fill' }} text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>{{ isset($guru) ? 'PEMBARUAN DATA RESMI' : 'INPUT DATA BARU' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? (isset($guru) ? 'EDIT DATA PENDIDIK' : 'TAMBAH PENDIDIK BARU')) }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>FORMULIR RESMI KEPEGAWAIAN</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.guru.index') }}"
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
    <form action="{{ isset($guru) ? route('admin.guru.update', $guru->id) : route('admin.guru.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($guru))
            @method('PUT')
        @endif

        {{-- SECTION 1: Identitas & Kepegawaian --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="bi bi-person-badge text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">IDENTITAS & KEPEGAWAIAN</h3>
                    <p class="text-xs text-gray-400 font-mono">Informasi nomor induk, gelar akademik, dan profil pendidik</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-mono text-xs">
                {{-- NIP --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">NOMOR INDUK PEGAWAI (NIP)</label>
                    <input type="text" name="nip" required
                           value="{{ old('nip', $guru->nip ?? '') }}"
                           placeholder="Contoh: 198501152010011005 (Ketik '-' jika tidak ada)"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- NUPTK --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">NUPTK</label>
                    <input type="text" name="nuptk" required
                           value="{{ old('nuptk', $guru->nuptk ?? '') }}"
                           placeholder="Contoh: 1234567890123456 (Ketik '-' jika tidak ada)"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- NAMA LENGKAP --}}
                <div class="md:col-span-2">
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">NAMA LENGKAP & GELAR AKADEMIK <span class="text-signal">*</span></label>
                    <input type="text" name="nama_lengkap" required
                           value="{{ old('nama_lengkap', $guru->nama_lengkap ?? '') }}"
                           placeholder="Contoh: Susi Susanti, S.Pd.SD"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- TEMPAT LAHIR --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">TEMPAT LAHIR</label>
                    <input type="text" name="tempat_lahir" required
                           value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}"
                           placeholder="Contoh: Payakumbuh"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- TANGGAL LAHIR --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">TANGGAL LAHIR</label>
                    <input type="date" name="tanggal_lahir" required
                           value="{{ old('tanggal_lahir', isset($guru->tanggal_lahir) ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('Y-m-d') : '') }}"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- JENIS KELAMIN --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">JENIS KELAMIN</label>
                    <select name="jenis_kelamin" required
                            class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void focus:bg-white focus:outline-none focus:border-void transition-all">
                        <option value="">-- PILIH GENDER --</option>
                        <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>LAKI-LAKI</option>
                        <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>PEREMPUAN</option>
                    </select>
                </div>

                {{-- PENDIDIKAN --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">PENDIDIKAN TERAKHIR</label>
                    <input type="text" name="pendidikan_terakhir" required
                           value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir ?? '') }}"
                           placeholder="Contoh: S1 Pendidikan Guru Sekolah Dasar (PGSD)"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- JABATAN GURU --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">JABATAN GURU</label>
                    <input type="text" name="jabatan_guru" required
                           value="{{ old('jabatan_guru', $guru->jabatan_guru ?? '') }}"
                           placeholder="Contoh: Guru Kelas / Guru PAI"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- PANGKAT / GOLONGAN --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">PANGKAT & GOLONGAN</label>
                    <input type="text" name="pangkat_gol" required
                           value="{{ old('pangkat_gol', $guru->pangkat_gol ?? '') }}"
                           placeholder="Contoh: III.b (Ketik '-' jika Non-PNS)"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- STATUS AKTIF --}}
                <div class="md:col-span-2">
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">STATUS KEPEGAWAIAN</label>
                    <select name="status" required
                            class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void focus:bg-white focus:outline-none focus:border-void transition-all">
                        <option value="">-- PILIH STATUS --</option>
                        <option value="Aktif" {{ old('status', $guru->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>AKTIF MENGAJAR</option>
                        <option value="Tidak Aktif" {{ old('status', $guru->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>NON-AKTIF (CUTI / PENSIUN / MUTASI)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- SECTION 2: Alamat & Domisili --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="bi bi-geo-alt-fill text-cobalt"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">DOMISILI & ALAMAT</h3>
                    <p class="text-xs text-gray-400 font-mono">Tempat tinggal tenaga pendidik saat ini</p>
                </div>
            </div>

            <div class="space-y-6 font-mono text-xs">
                {{-- ALAMAT LENGKAP --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">ALAMAT JALAN / RT / RW <span class="text-signal">*</span></label>
                    <textarea name="alamat" rows="3" required
                              placeholder="Contoh: Jl. Raya Durian Gadang No. 15"
                              class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl p-4 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all leading-relaxed">{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    {{-- KENAGARIAN --}}
                    <div>
                        <label class="block font-bold text-void uppercase tracking-wider mb-2">NAGARI / KELURAHAN</label>
                        <input type="text" name="kenagarian" required
                               value="{{ old('kenagarian', $guru->kenagarian ?? 'Durian Gadang') }}"
                               placeholder="Nagari"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                    </div>

                    {{-- KECAMATAN --}}
                    <div>
                        <label class="block font-bold text-void uppercase tracking-wider mb-2">KECAMATAN</label>
                        <input type="text" name="kecamatan" required
                               value="{{ old('kecamatan', $guru->kecamatan ?? 'Akabiluru') }}"
                               placeholder="Kecamatan"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                    </div>

                    {{-- KAB/KOTA --}}
                    <div>
                        <label class="block font-bold text-void uppercase tracking-wider mb-2">KABUPATEN / KOTA</label>
                        <input type="text" name="kab_kota" required
                               value="{{ old('kab_kota', $guru->kab_kota ?? 'Lima Puluh Kota') }}"
                               placeholder="Kabupaten"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                    </div>

                    {{-- PROVINSI --}}
                    <div>
                        <label class="block font-bold text-void uppercase tracking-wider mb-2">PROVINSI</label>
                        <input type="text" name="provinsi" required
                               value="{{ old('provinsi', $guru->provinsi ?? 'Sumatera Barat') }}"
                               placeholder="Provinsi"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: Kontak & Komunikasi --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="bi bi-headset text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">KONTAK & KOMUNIKASI</h3>
                    <p class="text-xs text-gray-400 font-mono">Nomor telepon dan alamat email aktif untuk notifikasi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-mono text-xs">
                {{-- NO TELEPON --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">NO. WHATSAPP / TELEPON</label>
                    <input type="text" name="no_telepon" required
                           value="{{ old('no_telepon', $guru->no_telepon ?? '') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block font-bold text-void uppercase tracking-wider mb-2">ALAMAT EMAIL</label>
                    <input type="email" name="email" required
                           value="{{ old('email', $guru->email ?? '') }}"
                           placeholder="Contoh: guru@sdn01duriangadang.sch.id"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3.5 font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4 font-mono text-xs">
            <span class="text-gray-400 font-bold flex items-center gap-2">
                <i class="bi bi-info-circle text-cobalt"></i>
                PASTIKAN SELURUH DATA BERTANDA BINTANG WAJIB DIISI DENGAN PRESISI.
            </span>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.guru.index') }}"
                   class="px-6 py-3.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-void font-bold transition text-center w-full sm:w-auto uppercase">
                    BATAL
                </a>
                <button type="submit"
                        class="px-8 py-3.5 rounded-xl bg-void hover:bg-black text-white font-bold shadow-md transition text-center w-full sm:w-auto inline-flex items-center justify-center gap-2 uppercase">
                    <span>SIMPAN DATA PENDIDIK</span>
                    <i class="bi bi-check-lg text-signal"></i>
                </button>
            </div>
        </div>

    </form>
</div>