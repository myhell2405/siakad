@extends('admin.layout')

@section('content')
<div class="space-y-10 font-sans text-slate-800 pb-16">

    {{-- ================================================
         HERO HEADER SECTION
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 ring-1 ring-slate-900/[0.03]">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-indigo-500/10 via-purple-500/10 to-pink-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/25 shrink-0">
                <i class="bi bi-shield-lock-fill text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span>Otoritas & Kredensial</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Manajemen Akun Pengguna</h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span>Kelola kredensial login seluruh warga sekolah (Admin, Guru, Siswa, Kepsek)</span>
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 relative z-10 w-full lg:w-auto">
            <!-- Generate Guru -->
            <form action="{{ route('admin.akun.generate-guru') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin me-generate akun login otomatis untuk semua Guru aktif yang belum memiliki akun? Password default adalah 1234.')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-emerald-500/20 transition-all active:scale-95">
                    <i class="bi bi-magic text-sm"></i> Generate Akun Guru
                </button>
            </form>

            <!-- Generate Siswa -->
            <form action="{{ route('admin.akun.generate-siswa') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin me-generate akun login otomatis untuk semua Siswa aktif yang belum memiliki akun? Password default adalah 1234.')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-teal-500/20 transition-all active:scale-95">
                    <i class="bi bi-magic text-sm"></i> Generate Akun Siswa
                </button>
            </form>

            <!-- Tambah Manual -->
            <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold rounded-2xl shadow-lg shadow-blue-500/25 transition-all active:scale-95">
                <i class="bi bi-plus-lg text-sm font-black"></i> Tambah Akun
            </button>
        </div>
    </div>

    {{-- Alert Messages --}}
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
        <div class="bg-rose-50 ring-1 ring-rose-500/20 text-rose-900 p-4 rounded-2xl shadow-sm flex items-center justify-between text-xs font-bold">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center shadow-md shadow-rose-500/20">
                    <i class="bi bi-exclamation-triangle-fill text-sm font-black"></i>
                </div>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-rose-100 text-rose-600 flex items-center justify-center transition">
                <i class="bi bi-x-lg text-xs font-bold"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 ring-1 ring-rose-500/20 text-rose-900 p-4 rounded-2xl shadow-sm text-xs font-bold">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================================================
         FILTER & SEARCH CARD
         ================================================ --}}
    <div class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
        <form method="GET" action="{{ route('admin.akun.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
            <!-- Cari Username / Nama -->
            <div class="md:col-span-5 min-w-0 space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Cari Pengguna</label>
                <div class="relative">
                    <i class="bi bi-search absolute left-4 top-3.5 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari username, NIP, NISN, atau nama..." class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl pl-10 pr-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner">
                </div>
            </div>

            <!-- Filter Role -->
            <div class="md:col-span-4 min-w-0 space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Filter Role</label>
                <select name="role_id" onchange="this.form.submit()" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner">
                    <option value="">-- Semua Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id_role }}" {{ request('role_id') == $role->id_role ? 'selected' : '' }}>
                            {{ ucfirst($role->nama_role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Filter -->
            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-2xl shadow-lg shadow-indigo-500/25 transition-all flex items-center justify-center gap-2 text-xs active:scale-[0.98]">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                @if(request('search') || request('role_id'))
                    <a href="{{ route('admin.akun.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 px-4 rounded-2xl transition flex items-center justify-center text-xs active:scale-95" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise text-sm"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ================================================
         TABLE CARD
         ================================================ --}}
    <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                        <th class="py-4 px-6 text-center w-16">No</th>
                        <th class="py-4 px-6">Username / Login ID</th>
                        <th class="py-4 px-6">Nama Pemilik Akun</th>
                        <th class="py-4 px-6 text-center">Role</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="py-4 px-6 text-center font-bold text-slate-400">{{ $users->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-mono font-black text-slate-900 text-sm">{{ $user->username }}</td>
                            <td class="py-4 px-6">
                                @if($user->guru)
                                    <span class="font-extrabold text-indigo-600 block text-sm">{{ $user->guru->nama_lengkap }}</span>
                                    <span class="text-[11px] text-slate-400 font-bold">NIP: {{ $user->guru->nip }}</span>
                                @elseif($user->siswa)
                                    <span class="font-extrabold text-teal-600 block text-sm">{{ $user->siswa->nama_siswa }}</span>
                                    <span class="text-[11px] text-slate-400 font-bold">NISN: {{ $user->siswa->nisn }}</span>
                                @else
                                    <span class="text-slate-400 italic font-medium">Administrator / Umum</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $badgeColor = match($user->role?->nama_role) {
                                        'admin' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-500/20 font-black',
                                        'guru' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-500/20 font-black',
                                        'wali_kelas' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20 font-black',
                                        'kepala_sekolah' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20 font-black',
                                        'siswa' => 'bg-teal-50 text-teal-700 ring-1 ring-teal-500/20 font-black',
                                        default => 'bg-slate-100 text-slate-700 font-bold'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] {{ $badgeColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->role?->nama_role ?? 'Unknown')) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($user->status == 'aktif')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black bg-rose-50 text-rose-700 ring-1 ring-rose-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit -->
                                    <button onclick="openEditModal('{{ $user->id_user }}', '{{ $user->username }}', '{{ $user->role_id }}', '{{ $user->ref_id }}', '{{ $user->status }}')" class="w-8 h-8 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-600 flex items-center justify-center transition active:scale-90 shadow-2xs" title="Edit Akun">
                                        <i class="bi bi-pencil-square text-xs font-bold"></i>
                                    </button>

                                    <!-- Reset Password -->
                                    <form action="{{ route('admin.akun.reset-password', $user->id_user) }}" method="POST" onsubmit="return confirm('Reset password pengguna ini menjadi default (1234)?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition active:scale-90 shadow-2xs" title="Reset Password ke 1234">
                                            <i class="bi bi-key-fill text-xs"></i>
                                        </button>
                                    </form>

                                    <!-- Hapus -->
                                    @if(session('id_user') != $user->id_user)
                                        <form action="{{ route('admin.akun.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition active:scale-90 shadow-2xs" title="Hapus Akun">
                                                <i class="bi bi-trash-fill text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-400 italic font-medium">
                                Belum ada data akun pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-6 bg-slate-50/50 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Akun -->
<div id="addModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-8 shadow-2xl ring-1 ring-slate-900/10 animate-scale-up">
        <div class="flex justify-between items-center pb-4 border-b border-slate-100 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black">
                    <i class="bi bi-person-plus-fill text-lg"></i>
                </div>
                <h3 class="text-base font-black text-slate-900">Tambah Akun Pengguna</h3>
            </div>
            <button onclick="closeAddModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.akun.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Username / Login ID</label>
                    <input type="text" name="username" required placeholder="Contoh: admin2 atau NIP/NISN" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 4 karakter" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Role / Hak Akses</label>
                    <select name="role_id" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ ucfirst($role->nama_role) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Ref ID (Opsional)</label>
                    <input type="number" name="ref_id" placeholder="ID Guru / ID Siswa (jika ada)" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                    <p class="text-[11px] font-semibold text-slate-400 mt-1">*Kosongkan jika akun Administrator / Kepala Sekolah.</p>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Status Akun</label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-xs font-bold transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-2xl text-xs font-bold shadow-lg shadow-indigo-500/25 transition active:scale-95">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Akun -->
<div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-8 shadow-2xl ring-1 ring-slate-900/10 animate-scale-up">
        <div class="flex justify-between items-center pb-4 border-b border-slate-100 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-black">
                    <i class="bi bi-pencil-square text-lg"></i>
                </div>
                <h3 class="text-base font-black text-slate-900">Edit Akun Pengguna</h3>
            </div>
            <button onclick="closeEditModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition font-bold">&times;</button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Username / Login ID</label>
                    <input type="text" name="username" id="edit_username" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin merubah" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Role / Hak Akses</label>
                    <select name="role_id" id="edit_role_id" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition">
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ ucfirst($role->nama_role) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Ref ID (Opsional)</label>
                    <input type="number" name="ref_id" id="edit_ref_id" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-1.5">Status Akun</label>
                    <select name="status" id="edit_status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition">
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-xs font-bold transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-2xl text-xs font-bold shadow-lg shadow-amber-500/25 transition active:scale-95">Perbarui</button>
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
