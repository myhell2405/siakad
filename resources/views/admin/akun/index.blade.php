@extends('admin.layout')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Buttons -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Akun Pengguna</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola kredensial login seluruh warga sekolah (Admin, Guru, Siswa, Kepsek)</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Generate Guru -->
            <form action="{{ route('admin.akun.generate-guru') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin me-generate akun login otomatis untuk semua Guru aktif yang belum memiliki akun? Password default adalah 1234.')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow transition">
                    <i class="bi bi-magic"></i> Generate Akun Guru
                </button>
            </form>

            <!-- Generate Siswa -->
            <form action="{{ route('admin.akun.generate-siswa') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin me-generate akun login otomatis untuk semua Siswa aktif yang belum memiliki akun? Password default adalah 1234.')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg shadow transition">
                    <i class="bi bi-magic"></i> Generate Akun Siswa
                </button>
            </form>

            <!-- Tambah Manual -->
            <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition">
                <i class="bi bi-plus-lg"></i> Tambah Akun
            </button>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-green-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill text-red-600"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-600 font-bold">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-xl shadow border p-6">
        <form method="GET" action="{{ route('admin.akun.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <!-- Cari Username / Nama -->
            <div class="md:col-span-5 min-w-0">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Cari Pengguna</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari username, NIP, NISN, atau nama..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Filter Role -->
            <div class="md:col-span-4 min-w-0">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Filter Role</label>
                <select name="role_id" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
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
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow transition flex items-center justify-center gap-2 text-sm">
                    <i class="bi bi-search"></i> Filter
                </button>
                @if(request('search') || request('role_id'))
                    <a href="{{ route('admin.akun.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-3 rounded-lg transition flex items-center justify-center text-sm" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-16">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Username / Login ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Nama Pemilik Akun</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold">Role</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold">Status</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center font-medium text-gray-500">{{ $users->firstItem() + $index }}</td>
                            <td class="px-4 py-3 font-mono font-bold text-gray-800">{{ $user->username }}</td>
                            <td class="px-4 py-3">
                                @if($user->guru)
                                    <span class="font-semibold text-blue-700">{{ $user->guru->nama_lengkap }}</span>
                                    <span class="block text-xs text-gray-400">NIP: {{ $user->guru->nip }}</span>
                                @elseif($user->siswa)
                                    <span class="font-semibold text-teal-700">{{ $user->siswa->nama_siswa }}</span>
                                    <span class="block text-xs text-gray-400">NISN: {{ $user->siswa->nisn }}</span>
                                @else
                                    <span class="text-gray-500 italic">Administrator / Umum</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $badgeColor = match($user->role?->nama_role) {
                                        'admin' => 'bg-purple-100 text-purple-700 border-purple-300',
                                        'guru' => 'bg-blue-100 text-blue-700 border-blue-300',
                                        'wali_kelas' => 'bg-indigo-100 text-indigo-700 border-indigo-300',
                                        'kepala_sekolah' => 'bg-amber-100 text-amber-700 border-amber-300',
                                        'siswa' => 'bg-teal-100 text-teal-700 border-teal-300',
                                        default => 'bg-gray-100 text-gray-700 border-gray-300'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->role?->nama_role ?? 'Unknown')) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($user->status == 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit -->
                                    <button onclick="openEditModal('{{ $user->id_user }}', '{{ $user->username }}', '{{ $user->role_id }}', '{{ $user->ref_id }}', '{{ $user->status }}')" class="px-2.5 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs transition" title="Edit Akun">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- Reset Password -->
                                    <form action="{{ route('admin.akun.reset-password', $user->id_user) }}" method="POST" onsubmit="return confirm('Reset password pengguna ini menjadi default (1234)?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1.5 bg-gray-600 hover:bg-gray-700 text-white rounded text-xs transition" title="Reset Password ke 1234">
                                            <i class="bi bi-key-fill"></i>
                                        </button>
                                    </form>

                                    <!-- Hapus -->
                                    @if(session('id_user') != $user->id_user)
                                        <form action="{{ route('admin.akun.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs transition" title="Hapus Akun">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data akun pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 bg-gray-50 border-t">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Akun -->
<div id="addModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">
        <div class="flex justify-between items-center pb-3 border-b mb-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Akun Pengguna</h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
        </div>

        <form action="{{ route('admin.akun.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Username / Login ID</label>
                    <input type="text" name="username" required placeholder="Contoh: admin2 atau NIP/NISN" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 4 karakter" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Role / Hak Akses</label>
                    <select name="role_id" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ ucfirst($role->nama_role) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ref ID (Opsional)</label>
                    <input type="number" name="ref_id" placeholder="ID Guru / ID Siswa (jika ada)" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">*Kosongkan jika akun Administrator / Kepala Sekolah.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Akun</label>
                    <select name="status" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-3 border-t">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Akun -->
<div id="editModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">
        <div class="flex justify-between items-center pb-3 border-b mb-4">
            <h3 class="text-lg font-bold text-gray-800">Edit Akun Pengguna</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Username / Login ID</label>
                    <input type="text" name="username" id="edit_username" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin merubah" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Role / Hak Akses</label>
                    <select name="role_id" id="edit_role_id" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ ucfirst($role->nama_role) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ref ID (Opsional)</label>
                    <input type="number" name="ref_id" id="edit_ref_id" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Akun</label>
                    <select name="status" id="edit_status" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-3 border-t">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium">Batal</button>
                <button type="submit" class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-semibold shadow">Perbarui</button>
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
