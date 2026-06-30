@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto font-sans pb-16 text-gray-900">

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-500/30 text-emerald-900 p-4 rounded-2xl shadow-xs flex items-center justify-between text-xs font-mono font-bold uppercase">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">✕</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-500/30 text-red-900 p-4 rounded-2xl shadow-xs flex items-center justify-between text-xs font-mono font-bold uppercase">
            <div class="flex items-center gap-3">
                <i class="bi bi-exclamation-triangle-fill text-red-600 text-base"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-red-100 text-red-600 flex items-center justify-center transition">✕</button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-500/30 text-red-900 p-5 rounded-3xl shadow-xs space-y-2 text-xs font-mono font-bold uppercase">
            <div class="flex items-center gap-3">
                <i class="bi bi-shield-exclamation text-red-600 text-base"></i>
                <span>TERJADI KESALAHAN VALIDASI:</span>
            </div>
            <ul class="list-disc list-inside pl-7 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- HERO HEADER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-person-bounding-box text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>ACCOUNT PROFILE</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">PROFIL AKUN SAYA</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">
                    INFORMASI DETAIL AKUN PENGGUNA DAN PENGATURAN KEAMANAN KATA SANDI
                </p>
            </div>
        </div>

        <div class="relative z-10 shrink-0">
            <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-void rounded-xl text-xs font-mono font-bold border border-black/10 shadow-2xs uppercase">
                <i class="bi bi-shield-check text-emerald-600 text-sm"></i> TERAUTENTIKASI RESMI
            </span>
        </div>
    </div>

    {{-- CARD 1: DATA AKUN LOGIN --}}
    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
        <div class="bg-void px-8 py-5 text-white flex items-center justify-between border-b border-black">
            <h2 class="font-black text-sm tracking-wide flex items-center gap-2.5 uppercase font-mono">
                <i class="bi bi-key-fill text-signal"></i> KREDENSIAL & AKSES LOGIN
            </h2>
            <span class="text-[10px] font-mono font-bold tracking-widest uppercase bg-surface text-void px-3 py-1 rounded border border-black/10">SYSTEM IDENTITY</span>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-5 rounded-2xl border border-black/10 flex flex-col justify-between">
                    <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider">USERNAME / ID LOGIN</span>
                    <span class="text-lg font-black text-void mt-2 font-mono bg-white px-3 py-1.5 rounded-xl border border-black/10 inline-block w-fit">{{ $user?->username ?? session('username') }}</span>
                </div>
                <div class="bg-gray-50 p-5 rounded-2xl border border-black/10 flex flex-col justify-between">
                    <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider">ROLE HAK AKSES</span>
                    <div class="mt-2">
                        @php
                            $roleName = $user?->role?->nama_role ?? session('role');
                            $badgeStyle = match($roleName) {
                                'admin' => 'bg-void text-signal border border-black',
                                'guru' => 'bg-gray-200 text-void border border-black/10',
                                'wali_kelas' => 'bg-cobalt/10 text-cobalt border border-cobalt/20',
                                'kepala_sekolah' => 'bg-signal/20 text-void border border-black/10',
                                'siswa' => 'bg-surface text-void border border-black/10',
                                default => 'bg-gray-100 text-gray-700 border border-black/10'
                            };
                        @endphp
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded text-xs font-mono font-bold uppercase tracking-wider {{ $badgeStyle }}">
                            <i class="bi bi-person-badge mr-1.5"></i> {{ strtoupper(str_replace('_', ' ', $roleName)) }}
                        </span>
                    </div>
                </div>
                <div class="bg-gray-50 p-5 rounded-2xl border border-black/10 flex flex-col justify-between">
                    <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider">STATUS AKUN</span>
                    <div class="mt-2">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-emerald-100 text-emerald-900 border border-emerald-300 rounded text-xs font-mono font-bold uppercase">
                            <span class="h-2 w-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            <span>AKTIF & TERVERIFIKASI</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 2A: BIODATA SISWA --}}
    @if(($user?->role?->nama_role ?? session('role')) === 'siswa' && $user?->siswa)
    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
        <div class="bg-gray-100 px-8 py-5 text-void flex items-center justify-between border-b border-black/10">
            <h2 class="font-black text-sm tracking-wide flex items-center gap-2.5 uppercase font-mono">
                <i class="bi bi-mortarboard-fill text-cobalt"></i> BIODATA PESERTA DIDIK
            </h2>
            <span class="text-[10px] font-mono font-bold tracking-widest uppercase bg-void text-white px-3 py-1 rounded">STUDENT RECORD</span>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-xs font-mono">
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">NISN</span>
                    <span class="font-black text-void bg-gray-50 px-3 py-1 rounded border border-black/10">{{ $user->siswa->nisn }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">NAMA LENGKAP SISWA</span>
                    <span class="font-black text-void uppercase">{{ $user->siswa->nama_siswa }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">TEMPAT, TANGGAL LAHIR</span>
                    <span class="font-bold text-gray-700 uppercase">
                        {{ $user->siswa->tempat_lahir }}, {{ $user->siswa->tanggal_lahir ? $user->siswa->tanggal_lahir->format('d/m/Y') : '-' }}
                    </span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">JENIS KELAMIN</span>
                    <span class="font-bold text-gray-700 uppercase">{{ $user->siswa->jenis_kelamin === 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">AGAMA</span>
                    <span class="font-bold text-gray-700 uppercase">{{ $user->siswa->agama ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">NO. HP / TELEPON</span>
                    <span class="font-bold text-gray-700">{{ $user->siswa->telp_siswa ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-black/5 md:col-span-2 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">ALAMAT LENGKAP</span>
                    <span class="font-bold text-gray-700 text-right uppercase">{{ $user->siswa->alamat_siswa ?? '-' }}</span>
                </div>
                <div class="py-3 md:col-span-2 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">SEKOLAH ASAL</span>
                    <span class="font-bold text-gray-700 uppercase">{{ $user->siswa->sekolah_asal ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- CARD 2B: BIODATA GURU / PEGAWAI --}}
    @if(in_array($user?->role?->nama_role ?? session('role'), ['guru', 'wali_kelas', 'kepala_sekolah']) && $user?->guru)
    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
        <div class="bg-gray-100 px-8 py-5 text-void flex items-center justify-between border-b border-black/10">
            <h2 class="font-black text-sm tracking-wide flex items-center gap-2.5 uppercase font-mono">
                <i class="bi bi-briefcase-fill text-cobalt"></i> BIODATA GURU / PEGAWAI
            </h2>
            <span class="text-[10px] font-mono font-bold tracking-widest uppercase bg-void text-white px-3 py-1 rounded">EDUCATOR RECORD</span>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-xs font-mono">
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">NIP / NUPTK / NPDN</span>
                    <span class="font-black text-void bg-gray-50 px-3 py-1 rounded border border-black/10">{{ $user->guru->nip ?: ($user->guru->nuptk ?: '-') }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">NAMA LENGKAP & GELAR</span>
                    <span class="font-black text-void uppercase">{{ $user->guru->nama_lengkap }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">TEMPAT, TANGGAL LAHIR</span>
                    <span class="font-bold text-gray-700 uppercase">
                        {{ $user->guru->tempat_lahir }}, {{ $user->guru->tanggal_lahir ? $user->guru->tanggal_lahir->format('d/m/Y') : '-' }}
                    </span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">JENIS KELAMIN</span>
                    <span class="font-bold text-gray-700 uppercase">{{ $user->guru->jenis_kelamin === 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">PENDIDIKAN TERAKHIR</span>
                    <span class="font-bold text-gray-700 uppercase">{{ $user->guru->pendidikan_terakhir ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">JABATAN AKADEMIK</span>
                    <span class="font-bold text-gray-700 uppercase">{{ $user->guru->jabatan_guru ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">NO. HANDPHONE / WA</span>
                    <span class="font-bold text-gray-700">{{ $user->guru->no_telepon ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-black/5 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">EMAIL AKTIF</span>
                    <span class="font-bold text-gray-700">{{ $user->guru->email ?? '-' }}</span>
                </div>
                <div class="py-3 md:col-span-2 flex justify-between items-center">
                    <span class="font-bold text-gray-400 uppercase">ALAMAT TEMPAT TINGGAL</span>
                    <span class="font-bold text-gray-700 text-right uppercase">{{ $user->guru->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- CARD 3: UBAH PASSWORD AKUN --}}
    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
        <div class="bg-gray-100 px-8 py-5 text-void flex items-center justify-between border-b border-black/10">
            <h2 class="font-black text-sm tracking-wide flex items-center gap-2.5 uppercase font-mono">
                <i class="bi bi-shield-lock-fill text-signal"></i> UBAH PASSWORD AKUN
            </h2>
            <span class="text-[10px] font-mono font-bold tracking-widest uppercase bg-void text-white px-3 py-1 rounded">SECURITY SETTING</span>
        </div>
        <form action="{{ route('admin.profil.password') }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-gray-50 p-5 rounded-2xl border border-black/10">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-2">PASSWORD SAAT INI <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="bi bi-lock-fill text-sm"></i>
                    </span>
                    <input type="password" name="current_password" required
                           placeholder="Masukkan password lama Anda..."
                           class="w-full bg-white border border-black/10 rounded-xl pl-11 pr-4 py-3 text-xs font-mono font-bold text-void placeholder:font-normal placeholder:text-gray-400 focus:ring-2 focus:ring-void focus:outline-none transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-5 rounded-2xl border border-black/10">
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-2">PASSWORD BARU <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="bi bi-key-fill text-sm"></i>
                        </span>
                        <input type="password" name="password" required minlength="4"
                               placeholder="Minimal 4 karakter..."
                               class="w-full bg-white border border-black/10 rounded-xl pl-11 pr-4 py-3 text-xs font-mono font-bold text-void placeholder:font-normal placeholder:text-gray-400 focus:ring-2 focus:ring-void focus:outline-none transition shadow-2xs">
                    </div>
                </div>
                <div class="bg-gray-50 p-5 rounded-2xl border border-black/10">
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-2">KONFIRMASI PASSWORD BARU <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="bi bi-check-circle-fill text-sm"></i>
                        </span>
                        <input type="password" name="password_confirmation" required minlength="4"
                               placeholder="Ketik ulang password baru..."
                               class="w-full bg-white border border-black/10 rounded-xl pl-11 pr-4 py-3 text-xs font-mono font-bold text-void placeholder:font-normal placeholder:text-gray-400 focus:ring-2 focus:ring-void focus:outline-none transition shadow-2xs">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end border-t border-black/10">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3.5 bg-void hover:bg-black text-white rounded-xl text-xs font-mono font-bold uppercase tracking-wider shadow-md transition-all active:scale-95">
                    <i class="bi bi-shield-check text-signal text-sm"></i> SIMPAN PASSWORD BARU
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
