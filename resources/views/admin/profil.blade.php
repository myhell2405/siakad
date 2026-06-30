@extends('admin.layout')

@section('content')
<div class="space-y-10 font-sans text-slate-800 pb-16 max-w-5xl mx-auto">

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="bg-emerald-50 ring-1 ring-emerald-500/20 text-emerald-900 p-4 rounded-2xl shadow-sm flex items-center justify-between text-xs font-bold animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/20">
                    <i class="bi bi-check-lg text-sm font-black"></i>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">
                <i class="bi bi-x-lg text-xs font-bold"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 ring-1 ring-rose-500/20 text-rose-900 p-4 rounded-2xl shadow-sm flex items-center justify-between text-xs font-bold animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center shadow-md shadow-rose-500/20">
                    <i class="bi bi-exclamation-triangle-fill text-sm"></i>
                </div>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-rose-100 text-rose-600 flex items-center justify-center transition">
                <i class="bi bi-x-lg text-xs font-bold"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 ring-1 ring-rose-500/20 text-rose-900 p-5 rounded-3xl shadow-sm space-y-2 animate-fade-in">
            <div class="flex items-center gap-3 font-black text-xs">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center shadow-md shadow-rose-500/20 shrink-0">
                    <i class="bi bi-shield-exclamation text-sm"></i>
                </div>
                <span>Terjadi Kesalahan Validasi:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-medium pl-11 space-y-1 text-rose-800">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================================================
         HERO HEADER SECTION
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6 ring-1 ring-slate-900/[0.03]">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/25 shrink-0">
                <i class="bi bi-person-bounding-box text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span>Account Profile</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Profil Akun Saya</h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span>Informasi detail akun pengguna dan pengaturan keamanan sandi</span>
                </p>
            </div>
        </div>

        <div class="relative z-10 shrink-0">
            <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-50 text-slate-600 rounded-2xl text-xs font-bold ring-1 ring-slate-200/60 shadow-2xs">
                <i class="bi bi-shield-check text-emerald-500 text-sm"></i> Terautentikasi Resmi
            </span>
        </div>
    </div>

    {{-- ================================================
         CARD 1: DATA AKUN LOGIN
         ================================================ --}}
    <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 px-8 py-5 text-white flex items-center justify-between">
            <h2 class="font-black text-sm tracking-wide flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-indigo-300">
                    <i class="bi bi-key-fill text-sm"></i>
                </div>
                <span>Kredensial & Akses Login</span>
            </h2>
            <span class="text-[10px] font-black tracking-widest uppercase bg-white/10 px-3 py-1 rounded-full text-indigo-200">System Identity</span>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60 flex flex-col justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Username / ID Login</span>
                    <span class="text-lg font-black text-slate-800 mt-2 font-mono bg-white px-3 py-1.5 rounded-xl ring-1 ring-slate-200/50 shadow-2xs inline-block w-fit">{{ $user?->username ?? session('username') }}</span>
                </div>
                <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60 flex flex-col justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Role Hak Akses</span>
                    <div class="mt-2">
                        @php
                            $roleName = $user?->role?->nama_role ?? session('role');
                            $badgeStyle = match($roleName) {
                                'admin' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-500/20',
                                'guru' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-500/20',
                                'wali_kelas' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20',
                                'kepala_sekolah' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20',
                                'siswa' => 'bg-teal-50 text-teal-700 ring-1 ring-teal-500/20',
                                default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-300'
                            };
                        @endphp
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider {{ $badgeStyle }}">
                            <i class="bi bi-person-badge mr-1.5"></i> {{ str_replace('_', ' ', $roleName) }}
                        </span>
                    </div>
                </div>
                <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60 flex flex-col justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Akun</span>
                    <div class="mt-2">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-black ring-1 ring-emerald-500/20">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Aktif & Terverifikasi</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================
         CARD 2A: BIODATA SISWA
         ================================================ --}}
    @if(($user?->role?->nama_role ?? session('role')) === 'siswa' && $user?->siswa)
    <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden animate-fade-in">
        <div class="bg-gradient-to-r from-teal-900 via-emerald-950 to-teal-900 px-8 py-5 text-white flex items-center justify-between">
            <h2 class="font-black text-sm tracking-wide flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-teal-300">
                    <i class="bi bi-mortarboard-fill text-sm"></i>
                </div>
                <span>Data Biodata Siswa</span>
            </h2>
            <span class="text-[10px] font-black tracking-widest uppercase bg-white/10 px-3 py-1 rounded-full text-teal-200">Student Record</span>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-xs">
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">NISN</span>
                    <span class="font-black text-slate-800 font-mono bg-slate-50 px-3 py-1 rounded-lg ring-1 ring-slate-200/50">{{ $user->siswa->nisn }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Nama Lengkap Siswa</span>
                    <span class="font-black text-slate-800">{{ $user->siswa->nama_siswa }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Tempat, Tanggal Lahir</span>
                    <span class="font-bold text-slate-700">
                        {{ $user->siswa->tempat_lahir }}, {{ $user->siswa->tanggal_lahir ? $user->siswa->tanggal_lahir->format('d/m/Y') : '-' }}
                    </span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Jenis Kelamin</span>
                    <span class="font-bold text-slate-700">{{ $user->siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Agama</span>
                    <span class="font-bold text-slate-700">{{ $user->siswa->agama ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">No. HP / Telepon</span>
                    <span class="font-bold text-slate-700">{{ $user->siswa->telp_siswa ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 md:col-span-2 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Alamat Lengkap</span>
                    <span class="font-bold text-slate-700 text-right">{{ $user->siswa->alamat_siswa ?? '-' }}</span>
                </div>
                <div class="py-3 md:col-span-2 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Sekolah Asal</span>
                    <span class="font-bold text-slate-700">{{ $user->siswa->sekolah_asal ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ================================================
         CARD 2B: BIODATA GURU / PEGAWAI
         ================================================ --}}
    @if(in_array($user?->role?->nama_role ?? session('role'), ['guru', 'wali_kelas', 'kepala_sekolah']) && $user?->guru)
    <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden animate-fade-in">
        <div class="bg-gradient-to-r from-blue-900 via-indigo-950 to-blue-900 px-8 py-5 text-white flex items-center justify-between">
            <h2 class="font-black text-sm tracking-wide flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-blue-300">
                    <i class="bi bi-briefcase-fill text-sm"></i>
                </div>
                <span>Data Biodata Guru / Pegawai</span>
            </h2>
            <span class="text-[10px] font-black tracking-widest uppercase bg-white/10 px-3 py-1 rounded-full text-blue-200">Educator Record</span>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-xs">
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">NIP / NUPTK / NPDN</span>
                    <span class="font-black text-slate-800 font-mono bg-slate-50 px-3 py-1 rounded-lg ring-1 ring-slate-200/50">{{ $user->guru->nip ?: ($user->guru->nuptk ?: '-') }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Nama Lengkap & Gelar</span>
                    <span class="font-black text-slate-800">{{ $user->guru->nama_lengkap }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Tempat, Tanggal Lahir</span>
                    <span class="font-bold text-slate-700">
                        {{ $user->guru->tempat_lahir }}, {{ $user->guru->tanggal_lahir ? $user->guru->tanggal_lahir->format('d/m/Y') : '-' }}
                    </span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Jenis Kelamin</span>
                    <span class="font-bold text-slate-700">{{ $user->guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Pendidikan Terakhir</span>
                    <span class="font-bold text-slate-700">{{ $user->guru->pendidikan_terakhir ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Jabatan Akademik</span>
                    <span class="font-bold text-slate-700">{{ $user->guru->jabatan_guru ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">No. Handphone / WA</span>
                    <span class="font-bold text-slate-700">{{ $user->guru->no_telepon ?? '-' }}</span>
                </div>
                <div class="py-3 border-b border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Email Aktif</span>
                    <span class="font-bold text-slate-700">{{ $user->guru->email ?? '-' }}</span>
                </div>
                <div class="py-3 md:col-span-2 flex justify-between items-center">
                    <span class="font-bold text-slate-400">Alamat Tempat Tinggal</span>
                    <span class="font-bold text-slate-700 text-right">{{ $user->guru->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ================================================
         CARD 3: UBAH PASSWORD AKUN
         ================================================ --}}
    <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 px-8 py-5 text-white flex items-center justify-between">
            <h2 class="font-black text-sm tracking-wide flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-amber-300">
                    <i class="bi bi-shield-lock-fill text-sm"></i>
                </div>
                <span>Ubah Password Akun</span>
            </h2>
            <span class="text-[10px] font-black tracking-widest uppercase bg-white/10 px-3 py-1 rounded-full text-slate-300">Security Setting</span>
        </div>
        <form action="{{ route('admin.profil.password') }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">Password Saat Ini <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="bi bi-lock-fill text-sm"></i>
                    </span>
                    <input type="password" name="current_password" required
                           placeholder="Masukkan password lama Anda..."
                           class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-xs font-bold text-slate-800 placeholder:font-normal placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none transition shadow-2xs">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">Password Baru <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="bi bi-key-fill text-sm"></i>
                        </span>
                        <input type="password" name="password" required minlength="4"
                               placeholder="Minimal 4 karakter..."
                               class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-xs font-bold text-slate-800 placeholder:font-normal placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none transition shadow-2xs">
                    </div>
                </div>
                <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">Konfirmasi Password Baru <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="bi bi-check-circle-fill text-sm"></i>
                        </span>
                        <input type="password" name="password_confirmation" required minlength="4"
                               placeholder="Ketik ulang password baru..."
                               class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-xs font-bold text-slate-800 placeholder:font-normal placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none transition shadow-2xs">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-2xl text-xs font-black uppercase tracking-wider shadow-lg shadow-indigo-500/25 transition-all active:scale-95">
                    <i class="bi bi-shield-check text-sm"></i> Simpan Password Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
