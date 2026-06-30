<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi {{ isset($waliSiswa) ? 'bi-person-heart' : 'bi-people-fill' }} text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>{{ isset($waliSiswa) ? 'PEMBARUAN DATA WALI' : 'INPUT WALI SISWA BARU' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? (isset($waliSiswa) ? 'EDIT DATA WALI SISWA' : 'TAMBAH WALI SISWA BARU')) }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>FORMULIR RESMI HUBUNGAN ORANG TUA / WALI</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.wali-siswa.index') }}"
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
    <form action="{{ isset($waliSiswa) ? route('admin.wali-siswa.update', $waliSiswa->id_wali ?? $waliSiswa->id) : route('admin.wali-siswa.store') }}"
          method="POST"
          class="space-y-8">

        @csrf
        @if(isset($waliSiswa))
            @method('PUT')
        @endif

        {{-- SECTION 1: Keterkaitan Siswa --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-black/10">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold">
                    <i class="bi bi-person-check-fill text-lg text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void tracking-tight uppercase">KETERKAITAN PESERTA DIDIK</h3>
                    <p class="text-xs text-gray-500 font-mono uppercase">Masukkan NISN untuk mencari dan menautkan data siswa secara otomatis</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">NISN SISWA <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" name="nisn" id="nisn" required
                               value="{{ old('nisn', $waliSiswa->nisn ?? '') }}"
                               placeholder="Ketik NISN Siswa..."
                               class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all pl-10">
                        <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    </div>
                    <span class="text-[11px] text-gray-500 font-mono font-medium mt-1.5 block flex items-center gap-1 uppercase">
                        <i class="bi bi-lightning-charge-fill text-signal"></i> Sistem akan mencarikan nama siswa secara otomatis.
                    </span>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">NAMA SISWA TERVERIFIKASI</label>
                    <input type="text" id="nama_siswa" readonly
                           value="{{ $waliSiswa->siswa->nama_siswa ?? '' }}"
                           placeholder="Nama siswa akan muncul di sini..."
                           class="w-full bg-gray-100 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-cobalt cursor-not-allowed transition-all uppercase">
                </div>
            </div>
        </div>

        {{-- SECTION 2: Profil Wali / Orang Tua --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-black/10">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold">
                    <i class="bi bi-person-lines-fill text-lg text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void tracking-tight uppercase">PROFIL WALI / ORANG TUA</h3>
                    <p class="text-xs text-gray-500 font-mono uppercase">Identitas lengkap, status hubungan, dan pekerjaan wali</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">NAMA WALI / ORANG TUA <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_wali" required
                           value="{{ old('nama_wali', $waliSiswa->nama_wali ?? '') }}"
                           placeholder="Contoh: H. SUDIRMAN"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">HUBUNGAN KELUARGA <span class="text-red-500">*</span></label>
                    <select name="hubungan" required
                            class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                        <option value="">-- PILIH HUBUNGAN --</option>
                        <option value="AYAH" {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'AYAH' ? 'selected' : '' }}>AYAH</option>
                        <option value="IBU" {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'IBU' ? 'selected' : '' }}>IBU</option>
                        <option value="WALI" {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'WALI' ? 'selected' : '' }}>WALI LAINNYA</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">PEKERJAAN</label>
                    <input type="text" name="pekerjaan"
                           value="{{ old('pekerjaan', $waliSiswa->pekerjaan ?? '') }}"
                           placeholder="Contoh: PNS / WIRASWASTA"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                </div>
            </div>
        </div>

        {{-- SECTION 3: Kontak & Alamat Domisili --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-5 border-b border-black/10">
                <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold">
                    <i class="bi bi-telephone-inbound text-lg text-signal"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-void tracking-tight uppercase">KONTAK & ALAMAT DOMISILI</h3>
                    <p class="text-xs text-gray-500 font-mono uppercase">Nomor telepon aktif dan alamat tempat tinggal wali</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">NO. TELEPON / WHATSAPP</label>
                    <input type="text" name="telepon"
                           value="{{ old('telepon', $waliSiswa->telepon ?? '') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-mono font-bold text-void uppercase tracking-wider mb-2">ALAMAT LENGKAP TEMPAT TINGGAL</label>
                    <textarea name="alamat" rows="2"
                              placeholder="Contoh: JL. RAYA DURIAN GADANG NO. 12"
                              class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl p-4 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all leading-relaxed uppercase">{{ old('alamat', $waliSiswa->alamat ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-gray-500 font-mono font-bold flex items-center gap-2 uppercase">
                <i class="bi bi-info-circle text-cobalt text-base"></i> Pastikan seluruh data bertanda bintang (*) wajib diisi dengan benar.
            </span>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.wali-siswa.index') }}"
                   class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-void font-mono font-bold text-xs transition uppercase text-center w-full sm:w-auto">
                    BATAL
                </a>
                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase text-center w-full sm:w-auto inline-flex items-center justify-center gap-2">
                    <i class="bi bi-check2 text-signal"></i> SIMPAN DATA WALI
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