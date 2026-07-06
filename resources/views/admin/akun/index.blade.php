@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-shield-lock-fill text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>OTORITAS & KREDENSIAL</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">MANAJEMEN AKUN PENGGUNA</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">
                    KELOLA KREDENSIAL LOGIN SELURUH WARGA SEKOLAH (ADMIN, GURU, SISWA, KEPALA SEKOLAH)
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 relative z-10 w-full lg:w-auto">
            <!-- Generate Guru -->
            <form action="{{ route('admin.akun.generate-guru') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin me-generate akun login otomatis untuk semua Guru aktif yang belum memiliki akun? Password default adalah 1234.')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-3 bg-gray-100 hover:bg-void text-void hover:text-white border border-black/10 text-xs font-mono font-bold rounded-xl shadow-2xs transition-all uppercase">
                    <i class="bi bi-magic text-signal"></i> GENERATE AKUN GURU
                </button>
            </form>

            <!-- Generate Siswa -->
            <form action="{{ route('admin.akun.generate-siswa') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin me-generate akun login otomatis untuk semua Siswa aktif yang belum memiliki akun? Password default adalah 1234.')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-3 bg-gray-100 hover:bg-void text-void hover:text-white border border-black/10 text-xs font-mono font-bold rounded-xl shadow-2xs transition-all uppercase">
                    <i class="bi bi-magic text-signal"></i> GENERATE AKUN SISWA
                </button>
            </form>

            <!-- Tambah Manual -->
            <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-5 py-3 bg-void hover:bg-black text-white text-xs font-mono font-bold rounded-xl shadow-md transition-all active:scale-95 uppercase">
                <i class="bi bi-plus-lg text-signal"></i> TAMBAH AKUN
            </button>
        </div>
    </div>

    {{-- Alert Messages --}}
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
        <div class="bg-red-50 border border-red-500/30 text-red-900 p-4 rounded-2xl shadow-xs text-xs font-mono font-bold uppercase">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FILTER & SEARCH CARD --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs">
        <form method="GET" action="{{ route('admin.akun.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
            <!-- Cari Username / Nama -->
            <div class="md:col-span-5 min-w-0 space-y-2">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">CARI PENGGUNA</label>
                <div class="relative">
                    <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari username, NIP, NISN, atau nama..." class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl pl-10 pr-4 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all shadow-2xs">
                </div>
            </div>

            <!-- Filter Role -->
            <div class="md:col-span-4 min-w-0 space-y-2">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">FILTER ROLE</label>
                <select name="role_id" onchange="this.form.submit()" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                    <option value="">-- SEMUA ROLE --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id_role }}" {{ request('role_id') == $role->id_role ? 'selected' : '' }}>
                            {{ strtoupper(str_replace('_', ' ', $role->nama_role)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Filter -->
            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="flex-1 bg-void hover:bg-black text-white font-mono font-bold py-3 px-4 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase">
                    <i class="bi bi-funnel-fill text-signal"></i> FILTER
                </button>
                @if(request('search') || request('role_id'))
                    <a href="{{ route('admin.akun.index') }}" class="bg-gray-100 hover:bg-gray-200 text-void font-bold py-3 px-4 rounded-xl transition flex items-center justify-center text-xs" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise text-sm"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-black/10 bg-gray-50 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                    <i class="bi bi-people-fill text-signal"></i>
                </div>
                <div>
                    <h3 class="font-black text-void text-sm uppercase">DAFTAR KREDENSIAL PENGGUNA</h3>
                    <p class="text-xs text-gray-500 font-mono uppercase">MENAMPILKAN SEMUA AKUN SISTEM YANG TERDAFTAR</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface text-void font-mono text-[10px] uppercase tracking-wider border-b border-black/10">
                        <th class="py-4 pl-6 text-center w-16">NO</th>
                        <th class="py-4 px-6">USERNAME / LOGIN ID</th>
                        <th class="py-4 px-6">NAMA PEMILIK AKUN</th>
                        <th class="py-4 px-6 text-center">ROLE</th>
                        <th class="py-4 px-6 text-center">STATUS</th>
                        <th class="py-4 pr-6 text-center w-48">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50/80 transition duration-150">
                            <td class="py-4 pl-6 text-center font-mono font-bold text-gray-400">{{ $users->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-mono font-black text-void text-sm">{{ $user->username }}</td>
                            <td class="py-4 px-6">
                                @if(in_array($user->role?->nama_role, ['guru', 'wali_kelas', 'kepala_sekolah']) && $user->guru)
                                    <span class="font-bold text-void block text-sm uppercase">{{ $user->guru->nama_lengkap }}</span>
                                    <span class="text-[10px] text-cobalt font-mono uppercase font-bold">NIP: {{ $user->guru->nip ?? '-' }}</span>
                                @elseif($user->role?->nama_role == 'siswa' && $user->siswa)
                                    <span class="font-bold text-void block text-sm uppercase">{{ $user->siswa->nama_siswa }}</span>
                                    <span class="text-[10px] text-emerald-700 font-mono uppercase font-bold">NISN: {{ $user->siswa->nisn ?? '-' }}</span>
                                @else
                                    <span class="text-gray-400 italic font-mono uppercase">ADMINISTRATOR / UMUM</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $badgeColor = match($user->role?->nama_role) {
                                        'admin' => 'bg-void text-signal border border-black font-mono font-bold',
                                        'guru' => 'bg-gray-100 text-void border border-black/10 font-mono font-bold',
                                        'wali_kelas' => 'bg-cobalt/10 text-cobalt border border-cobalt/20 font-mono font-bold',
                                        'kepala_sekolah' => 'bg-signal/20 text-void border border-black/10 font-mono font-bold',
                                        'siswa' => 'bg-surface text-void border border-black/10 font-mono font-bold',
                                        default => 'bg-gray-100 text-gray-700 font-mono font-bold'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded text-[10px] uppercase {{ $badgeColor }}">
                                    {{ strtoupper(str_replace('_', ' ', $user->role?->nama_role ?? 'UNKNOWN')) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($user->status == 'aktif')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded text-[10px] font-mono font-bold uppercase bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> AKTIF
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded text-[10px] font-mono font-bold uppercase bg-void text-signal border border-black">
                                        <span class="w-1.5 h-1.5 rounded-full bg-signal"></span> TIDAK AKTIF
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 pr-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit -->
                                    <button onclick="openEditModal('{{ $user->id_user }}', '{{ addslashes($user->username) }}', '{{ $user->role_id }}', '{{ $user->ref_id }}', '{{ $user->status }}')" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-void hover:text-white text-void flex items-center justify-center transition shadow-2xs border border-black/10" title="Edit Akun">
                                        <i class="bi bi-pencil-square text-xs font-bold"></i>
                                    </button>

                                    <!-- Reset Password -->
                                    <form action="{{ route('admin.akun.reset-password', $user->id_user) }}" method="POST" onsubmit="return confirm('Reset password pengguna ini menjadi default (1234)?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-void hover:text-signal text-void flex items-center justify-center transition shadow-2xs border border-black/10" title="Reset Password ke 1234">
                                            <i class="bi bi-key-fill text-xs"></i>
                                        </button>
                                    </form>

                                    <!-- Impersonate -->
                                    @if(session('id_user') != $user->id_user && $user->status == 'aktif')
                                        <form action="{{ route('admin.akun.impersonate', $user->id_user) }}" method="POST" onsubmit="return confirm('Login menggunakan akun ini ({{ addslashes($user->username) }})?')">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-cobalt/10 hover:bg-cobalt hover:text-white text-cobalt flex items-center justify-center transition shadow-2xs border border-cobalt/20" title="Login Menggunakan Akun Ini (Impersonate)">
                                                <i class="bi bi-box-arrow-in-right text-xs font-bold"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Hapus -->
                                    @if(session('id_user') != $user->id_user)
                                        <form action="{{ route('admin.akun.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-red-600 hover:text-white text-red-600 flex items-center justify-center transition shadow-2xs border border-black/10" title="Hapus Akun">
                                                <i class="bi bi-trash-fill text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-gray-400 font-mono uppercase">
                                <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                                BELUM ADA DATA AKUN PENGGUNA.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-6 bg-gray-50 border-t border-black/10">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Akun -->
<div id="addModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 border border-black shadow-2xl">
        <div class="flex justify-between items-center pb-4 border-b border-black/10 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                    <i class="bi bi-person-plus-fill text-signal text-lg"></i>
                </div>
                <h3 class="text-base font-black text-void uppercase">TAMBAH AKUN PENGGUNA</h3>
            </div>
            <button onclick="closeAddModal()" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-void hover:text-white text-void font-bold flex items-center justify-center transition">&times;</button>
        </div>

        <form action="{{ route('admin.akun.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">USERNAME / LOGIN ID</label>
                    <input type="text" name="username" required placeholder="Contoh: admin2 atau NIP/NISN" class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">PASSWORD</label>
                    <input type="password" name="password" required placeholder="Minimal 4 karakter" class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">ROLE / HAK AKSES</label>
                    <select name="role_id" required class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition uppercase">
                        <option value="">-- PILIH ROLE --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ strtoupper(str_replace('_', ' ', $role->nama_role)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">REF ID (OPSIONAL)</label>
                    <input type="number" name="ref_id" placeholder="ID Guru / ID Siswa (jika ada)" class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition">
                    <p class="text-[10px] font-mono text-gray-400 mt-1 uppercase">*Kosongkan jika akun Administrator / Kepala Sekolah.</p>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">STATUS AKUN</label>
                    <select name="status" required class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition uppercase">
                        <option value="aktif">AKTIF</option>
                        <option value="tidak aktif">TIDAK AKTIF</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-black/10">
                <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-void rounded-xl text-xs font-mono font-bold transition uppercase">BATAL</button>
                <button type="submit" class="px-6 py-2.5 bg-void hover:bg-black text-white rounded-xl text-xs font-mono font-bold shadow-md transition uppercase inline-flex items-center gap-2">
                    <i class="bi bi-save2 text-signal"></i> SIMPAN
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Akun -->
<div id="editModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 border border-black shadow-2xl">
        <div class="flex justify-between items-center pb-4 border-b border-black/10 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                    <i class="bi bi-pencil-square text-signal text-lg"></i>
                </div>
                <h3 class="text-base font-black text-void uppercase">EDIT AKUN PENGGUNA</h3>
            </div>
            <button onclick="closeEditModal()" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-void hover:text-white text-void font-bold flex items-center justify-center transition">&times;</button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">USERNAME / LOGIN ID</label>
                    <input type="text" name="username" id="edit_username" required class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">PASSWORD BARU (OPSIONAL)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin merubah" class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">ROLE / HAK AKSES</label>
                    <select name="role_id" id="edit_role_id" required class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition uppercase">
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ strtoupper(str_replace('_', ' ', $role->nama_role)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">REF ID (OPSIONAL)</label>
                    <input type="number" name="ref_id" id="edit_ref_id" class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition">
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void mb-1.5">STATUS AKUN</label>
                    <select name="status" id="edit_status" required class="w-full bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition uppercase">
                        <option value="aktif">AKTIF</option>
                        <option value="tidak aktif">TIDAK AKTIF</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-black/10">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-void rounded-xl text-xs font-mono font-bold transition uppercase">BATAL</button>
                <button type="submit" class="px-6 py-2.5 bg-void hover:bg-black text-white rounded-xl text-xs font-mono font-bold shadow-md transition uppercase inline-flex items-center gap-2">
                    <i class="bi bi-save2 text-signal"></i> PERBARUI
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    function openEditModal(id, username, roleId, refId, status) {
        document.getElementById('editForm').action = `/admin/akun/${id}`;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_role_id').value = roleId;
        document.getElementById('edit_ref_id').value = refId !== 'null' ? refId : '';
        document.getElementById('edit_status').value = status;
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
