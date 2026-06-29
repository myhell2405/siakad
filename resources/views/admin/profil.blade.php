@extends('admin.layout')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Profil Akun Saya</h1>
        <p class="text-gray-500 mt-1">Informasi detail akun pengguna dan pengaturan keamanan sandi.</p>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
        <p class="font-bold">Berhasil!</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
        <p class="font-bold">Gagal!</p>
        <p>{{ session('error') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
        <p class="font-bold">Terjadi Kesalahan Validation:</p>
        <ul class="list-disc list-inside text-sm mt-1">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- CARD 1: DATA AKUN --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h2 class="font-semibold text-lg flex items-center gap-2">
                <i class="bi bi-person-badge"></i> Data Akun Login
            </h2>
        </div>
        <div class="p-6">
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="py-3 font-medium w-48 text-gray-500">Username / ID Login</td>
                        <td class="py-3 font-bold text-gray-800">{{ $user?->username ?? session('username') }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Role Akses</td>
                        <td class="py-3">
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 font-bold rounded-full text-xs uppercase">
                                {{ str_replace('_', ' ', $user?->role?->nama_role ?? session('role')) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Status Akun</td>
                        <td class="py-3">
                            <span class="inline-flex items-center gap-1.5 text-green-600 font-bold">
                                <i class="bi bi-check-circle-fill"></i> Aktif
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- CARD 2A: BIODATA SISWA --}}
    @if(($user?->role?->nama_role ?? session('role')) === 'siswa' && $user?->siswa)
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="bg-indigo-600 text-white px-6 py-4">
            <h2 class="font-semibold text-lg flex items-center gap-2">
                <i class="bi bi-mortarboard-fill"></i> Data Biodata Siswa
            </h2>
        </div>
        <div class="p-6">
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="py-3 font-medium w-48 text-gray-500">NISN</td>
                        <td class="py-3 font-bold text-gray-800">{{ $user->siswa->nisn }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Nama Siswa</td>
                        <td class="py-3 font-bold text-gray-800">{{ $user->siswa->nama_siswa }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Tempat, Tanggal Lahir</td>
                        <td class="py-3 text-gray-800">
                            {{ $user->siswa->tempat_lahir }}, {{ $user->siswa->tanggal_lahir ? $user->siswa->tanggal_lahir->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Jenis Kelamin</td>
                        <td class="py-3 text-gray-800">{{ $user->siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Agama</td>
                        <td class="py-3 text-gray-800">{{ $user->siswa->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">No. HP / Telepon</td>
                        <td class="py-3 text-gray-800">{{ $user->siswa->telp_siswa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Alamat Lengkap</td>
                        <td class="py-3 text-gray-800">{{ $user->siswa->alamat_siswa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Sekolah Asal</td>
                        <td class="py-3 text-gray-800">{{ $user->siswa->sekolah_asal ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- CARD 2B: BIODATA GURU / PEGAWAI --}}
    @if(in_array($user?->role?->nama_role ?? session('role'), ['guru', 'wali_kelas', 'kepala_sekolah']) && $user?->guru)
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="bg-emerald-600 text-white px-6 py-4">
            <h2 class="font-semibold text-lg flex items-center gap-2">
                <i class="bi bi-briefcase-fill"></i> Data Biodata Guru / Pegawai
            </h2>
        </div>
        <div class="p-6">
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="py-3 font-medium w-48 text-gray-500">NIP / NUPTK / NPDN</td>
                        <td class="py-3 font-bold text-gray-800">{{ $user->guru->nip ?: ($user->guru->nuptk ?: '-') }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Nama Lengkap</td>
                        <td class="py-3 font-bold text-gray-800">{{ $user->guru->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Tempat, Tanggal Lahir</td>
                        <td class="py-3 text-gray-800">
                            {{ $user->guru->tempat_lahir }}, {{ $user->guru->tanggal_lahir ? $user->guru->tanggal_lahir->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Jenis Kelamin</td>
                        <td class="py-3 text-gray-800">{{ $user->guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Pendidikan Terakhir</td>
                        <td class="py-3 text-gray-800">{{ $user->guru->pendidikan_terakhir ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Jabatan</td>
                        <td class="py-3 text-gray-800">{{ $user->guru->jabatan_guru ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">No. Handphone</td>
                        <td class="py-3 text-gray-800">{{ $user->guru->no_telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Email</td>
                        <td class="py-3 text-gray-800">{{ $user->guru->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-medium text-gray-500">Alamat</td>
                        <td class="py-3 text-gray-800">{{ $user->guru->alamat ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- CARD 3: UBAH PASSWORD --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            <h2 class="font-semibold text-lg flex items-center gap-2">
                <i class="bi bi-shield-lock-fill"></i> Ubah Password Akun
            </h2>
        </div>
        <form action="{{ route('admin.profil.password') }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini <span class="text-red-500">*</span></label>
                <input type="password" name="current_password" required
                       placeholder="Masukkan password lama Anda..."
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required minlength="4"
                           placeholder="Minimal 4 karakter..."
                           class="w-full border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required minlength="4"
                           placeholder="Ketik ulang password baru..."
                           class="w-full border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none">
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition">
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
