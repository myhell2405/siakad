<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-indigo-500/10 via-purple-500/10 to-pink-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi {{ isset($waliSiswa) ? 'bi-person-heart' : 'bi-people-fill' }} text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-indigo-50/80 text-indigo-700 ring-1 ring-indigo-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span>{{ isset($waliSiswa) ? 'Pembaruan Data Wali' : 'Input Wali Siswa Baru' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? (isset($waliSiswa) ? 'Edit Data Wali Siswa' : 'Tambah Wali Siswa Baru') }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-indigo-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Formulir Resmi Hubungan Orang Tua / Wali</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.wali-siswa.index') }}"
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
    <form action="{{ isset($waliSiswa) ? route('admin.wali-siswa.update', $waliSiswa->id_wali ?? $waliSiswa->id) : route('admin.wali-siswa.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($waliSiswa))
            @method('PUT')
        @endif

        {{-- SECTION 1: Keterkaitan Siswa (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-500/20">
                    <i class="bi bi-person-check-fill text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Keterkaitan Peserta Didik</h3>
                    <p class="text-xs text-slate-400 font-semibold">Masukkan NISN untuk mencari dan menautkan data siswa secara otomatis</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- NISN SISWA --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">NISN Siswa <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="text" name="nisn" id="nisn" required
                               value="{{ old('nisn', $waliSiswa->nisn ?? '') }}"
                               placeholder="Ketik NISN Siswa..."
                               class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner pl-10">
                        <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium mt-1.5 block flex items-center gap-1">
                        <i class="bi bi-lightning-charge-fill text-amber-500"></i> Sistem akan mencarikan nama siswa secara otomatis.
                    </span>
                </div>

                {{-- NAMA SISWA (READONLY) --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nama Siswa Terverifikasi</label>
                    <input type="text" id="nama_siswa" readonly
                           value="{{ $waliSiswa->siswa->nama_siswa ?? '' }}"
                           placeholder="Nama siswa akan muncul di sini..."
                           class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-4 py-3.5 text-xs font-black text-indigo-700 cursor-not-allowed shadow-inner transition-all">
                </div>
            </div>
        </div>

        {{-- SECTION 2: Profil Wali / Orang Tua (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 text-white flex items-center justify-center font-bold shadow-md shadow-purple-500/20">
                    <i class="bi bi-person-lines-fill text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Profil Wali / Orang Tua</h3>
                    <p class="text-xs text-slate-400 font-semibold">Identitas lengkap, status hubungan, dan pekerjaan wali</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- NAMA WALI --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nama Wali / Orang Tua <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_wali" required
                           value="{{ old('nama_wali', $waliSiswa->nama_wali ?? '') }}"
                           placeholder="Contoh: H. Sudirman"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner">
                </div>

                {{-- HUBUNGAN --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Hubungan Keluarga <span class="text-rose-500">*</span></label>
                    <select name="hubungan" required
                            class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner">
                        <option value="">-- Pilih Hubungan --</option>
                        <option value="AYAH" {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'AYAH' ? 'selected' : '' }}>AYAH</option>
                        <option value="IBU" {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'IBU' ? 'selected' : '' }}>IBU</option>
                        <option value="WALI" {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'WALI' ? 'selected' : '' }}>WALI LAINNYA</option>
                    </select>
                </div>

                {{-- PEKERJAAN --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Pekerjaan</label>
                    <input type="text" name="pekerjaan"
                           value="{{ old('pekerjaan', $waliSiswa->pekerjaan ?? '') }}"
                           placeholder="Contoh: Pegawai Negeri Sipil / Wiraswasta"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner">
                </div>
            </div>
        </div>

        {{-- SECTION 3: Kontak & Alamat Domisili (Floating Elevation) --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
            
            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-white flex items-center justify-center font-bold shadow-md shadow-pink-500/20">
                    <i class="bi bi-telephone-inbound text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Kontak & Alamat Domisili</h3>
                    <p class="text-xs text-slate-400 font-semibold">Nomor telepon aktif dan alamat tempat tinggal wali</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- TELEPON --}}
                <div class="md:col-span-1">
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon"
                           value="{{ old('telepon', $waliSiswa->telepon ?? '') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3.5 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner">
                </div>

                {{-- ALAMAT --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap Tempat Tinggal</label>
                    <textarea name="alamat" rows="2"
                              placeholder="Contoh: Jl. Raya Durian Gadang No. 12, Kec. Akabiluru"
                              class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl p-4 text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner leading-relaxed">{{ old('alamat', $waliSiswa->alamat ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI (Floating Elevation Card) --}}
        <div class="bg-white rounded-[2.2rem] p-6 sm:p-8 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-slate-400 font-bold flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-black">
                    <i class="bi bi-info-circle text-xs"></i>
                </div>
                Pastikan seluruh data bertanda bintang (*) wajib diisi dengan benar.
            </span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.wali-siswa.index') }}"
                   class="px-6 py-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition active:scale-95 text-center w-full sm:w-auto">
                    Batal
                </a>
                <button type="submit"
                        class="group px-8 py-3.5 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-xs shadow-lg shadow-indigo-500/25 transition-all duration-300 active:scale-[0.98] text-center w-full sm:w-auto inline-flex items-center justify-center gap-3">
                    <span>Simpan Data Wali</span>
                    <div class="w-7 h-7 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform group-hover:translate-x-0.5">
                        <i class="bi bi-check2 text-sm font-black"></i>
                    </div>
                </button>
            </div>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nisnInput = document.getElementById('nisn');
    const namaSiswa = document.getElementById('nama_siswa');
    let timer;

    if(nisnInput) {
        nisnInput.addEventListener('input', function () {
            clearTimeout(timer);
            const nisn = this.value.trim();

            if (nisn.length < 3) {
                namaSiswa.value = '';
                return;
            }

            namaSiswa.value = 'Mencari siswa...';

            timer = setTimeout(() => {
                fetch(`/admin/wali-siswa/cari-siswa/${nisn}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            namaSiswa.value = data.nama_siswa;
                        } else {
                            namaSiswa.value = 'Siswa tidak ditemukan';
                        }
                    })
                    .catch(() => {
                        namaSiswa.value = 'Error koneksi ke server';
                    });
            }, 300);
        });
    }
});
</script>