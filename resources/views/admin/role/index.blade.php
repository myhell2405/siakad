@extends('admin.layout')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 font-bold">&times;</button>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Matriks Role & Hak Akses (RBAC)</h1>
            <p class="text-gray-500 text-sm mt-1">Konfigurasi dinamis izin akses fitur dan menu untuk setiap peran pengguna</p>
        </div>
        <div>
            <a href="{{ route('admin.akun.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition">
                <i class="bi bi-people-fill"></i> Kelola Akun Pengguna
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-gradient-to-r from-blue-900 to-indigo-800 rounded-2xl text-white p-6 shadow-lg">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-white/10 rounded-xl text-2xl">
                <i class="bi bi-sliders"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold">Dynamic Access Control List (ACL)</h3>
                <p class="text-blue-100 text-sm mt-1 leading-relaxed">
                    Sistem Informasi Akademik ini menerapkan kendali akses dinamis. Admin dapat mencentang atau menyesuaikan fitur apa saja yang dapat diakses oleh setiap Role dengan mengeklik tombol <strong>Edit Izin</strong> pada tabel di bawah ini.
                </p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-16">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Kode Role</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Deskripsi Peran</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Daftar Hak Akses Fitur & Menu Terkonfigurasi</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-28">Total Akun</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @php
                        $allFeatures = [
                            'kelola_master' => ['label' => 'Kelola Data Master', 'color' => 'bg-purple-50 text-purple-700 border-purple-200'],
                            'kelola_akun' => ['label' => 'Kelola Akun & Role', 'color' => 'bg-purple-50 text-purple-700 border-purple-200'],
                            'pembagian_kelas' => ['label' => 'Pembagian Kelas Aktif', 'color' => 'bg-blue-50 text-blue-700 border-blue-200'],
                            'kelola_nilai_admin' => ['label' => 'Kelola Nilai Massal', 'color' => 'bg-blue-50 text-blue-700 border-blue-200'],
                            'laporan_akademik' => ['label' => 'Laporan Akademik', 'color' => 'bg-blue-50 text-blue-700 border-blue-200'],
                            'portal_guru' => ['label' => 'Akses Portal Guru', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                            'input_nilai_mapel' => ['label' => 'Input Nilai Mapel', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                            'validasi_nilai' => ['label' => 'Validasi Nilai Kelas', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                            'cetak_rapor_kelas' => ['label' => 'Cetak Rapor Siswa', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                            'portal_siswa' => ['label' => 'Akses Portal Siswa', 'color' => 'bg-teal-50 text-teal-700 border-teal-200'],
                            'view_nilai_siswa' => ['label' => 'Lihat Transkrip Nilai', 'color' => 'bg-teal-50 text-teal-700 border-teal-200'],
                            'cetak_rapor_siswa' => ['label' => 'Cetak Rapor Mandiri', 'color' => 'bg-teal-50 text-teal-700 border-teal-200'],
                            'portal_kepsek' => ['label' => 'Akses Portal Kepsek', 'color' => 'bg-amber-50 text-amber-700 border-amber-200'],
                            'monitoring_akademik' => ['label' => 'Monitoring Statistik', 'color' => 'bg-amber-50 text-amber-700 border-amber-200'],
                            'view_laporan' => ['label' => 'Rekapitulasi Laporan', 'color' => 'bg-amber-50 text-amber-700 border-amber-200'],
                        ];
                    @endphp
                    @foreach($roles as $role)
                        @php
                            $badgeColor = match($role->nama_role) {
                                'admin' => 'bg-purple-100 text-purple-700 border-purple-300',
                                'guru' => 'bg-blue-100 text-blue-700 border-blue-300',
                                'wali_kelas' => 'bg-indigo-100 text-indigo-700 border-indigo-300',
                                'kepala_sekolah' => 'bg-amber-100 text-amber-700 border-amber-300',
                                'siswa' => 'bg-teal-100 text-teal-700 border-teal-300',
                                default => 'bg-gray-100 text-gray-700 border-gray-300'
                            };
                            $perms = is_array($role->permissions) ? $role->permissions : [];
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center font-bold text-gray-500">{{ $role->id_role }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                    {{ $role->nama_role }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-700 font-medium whitespace-nowrap">{{ $role->deskripsi }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($perms as $p)
                                        @if(isset($allFeatures[$p]))
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border {{ $allFeatures[$p]['color'] }}">
                                                <i class="bi bi-check2 mr-1"></i> {{ $allFeatures[$p]['label'] }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs border bg-gray-50 text-gray-700">{{ $p }}</span>
                                        @endif
                                    @empty
                                        <span class="text-gray-400 italic text-xs">Belum ada hak akses dikonfigurasi</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-gray-800 text-base whitespace-nowrap">
                                {{ $role->users_count }} <span class="text-xs font-normal text-gray-500">akun</span>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <button type="button" 
                                    onclick="openEditRoleModal({{ $role->id_role }}, '{{ strtoupper($role->nama_role) }}', {{ json_encode($perms) }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg font-semibold text-xs transition shadow-sm">
                                    <i class="bi bi-gear-fill"></i> Edit Izin
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit Izin Akses -->
<div id="editRoleModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" onclick="closeEditRoleModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
            <form id="editRoleForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-indigo-800 to-blue-700 px-6 py-4 text-white flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Konfigurasi Hak Akses Role: <span id="modalRoleName" class="text-yellow-300"></span></h3>
                        <p class="text-xs text-blue-100 mt-0.5">Centang fitur dan menu yang diizinkan untuk peran ini</p>
                    </div>
                    <button type="button" onclick="closeEditRoleModal()" class="text-white/80 hover:text-white text-2xl font-bold leading-none">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6 max-h-[65vh] overflow-y-auto">
                    
                    <!-- Group 1: Administrasi & Master -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h4 class="text-sm font-bold text-gray-800 border-b pb-2 mb-3 flex items-center gap-2">
                            <i class="bi bi-database-fill text-purple-600"></i> Kelompok Administrasi & Data Master
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="kelola_master" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Kelola Data Master Sekolah</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="kelola_akun" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Kelola Akun & Role RBAC</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="pembagian_kelas" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Pembagian Kelas Aktif</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="kelola_nilai_admin" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Kelola Nilai Massal (Admin)</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="laporan_akademik" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Laporan Akademik Sekolah</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 2: Portal Guru & Wali Kelas -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h4 class="text-sm font-bold text-gray-800 border-b pb-2 mb-3 flex items-center gap-2">
                            <i class="bi bi-person-badge-fill text-indigo-600"></i> Kelompok Portal Guru & Wali Kelas
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="portal_guru" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Akses Portal Dashboard Guru</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="input_nilai_mapel" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Input & Edit Nilai Mapel</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="validasi_nilai" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Validasi Nilai (Wali Kelas)</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="cetak_rapor_kelas" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Cetak Rapor PDF Siswa</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 3: Portal Siswa & Orang Tua -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h4 class="text-sm font-bold text-gray-800 border-b pb-2 mb-3 flex items-center gap-2">
                            <i class="bi bi-mortarboard-fill text-teal-600"></i> Kelompok Portal Siswa & Orang Tua
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="portal_siswa" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Akses Portal Dashboard Siswa</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="view_nilai_siswa" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Lihat Transkrip Nilai Siswa</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="cetak_rapor_siswa" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Cetak Rapor Mandiri</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 4: Portal Kepala Sekolah -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h4 class="text-sm font-bold text-gray-800 border-b pb-2 mb-3 flex items-center gap-2">
                            <i class="bi bi-building-fill text-amber-600"></i> Kelompok Portal Kepala Sekolah
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="portal_kepsek" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Akses Dashboard Kepala Sekolah</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="monitoring_akademik" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Monitoring Statistik & Grafik</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="view_laporan" class="perm-cb rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Lihat Rekapitulasi Laporan</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-100">
                    <button type="button" onclick="selectAllPermissions()" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 underline">
                        Centang Semua Fitur
                    </button>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeEditRoleModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold rounded-lg transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition">
                            <i class="bi bi-save mr-1"></i> Simpan Konfigurasi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditRoleModal(idRole, roleName, permissions) {
    document.getElementById('modalRoleName').innerText = roleName;
    document.getElementById('editRoleForm').action = '/admin/role/' + idRole;
    
    // Uncheck all first
    document.querySelectorAll('.perm-cb').forEach(cb => cb.checked = false);
    
    // Check existing permissions
    if (Array.isArray(permissions)) {
        permissions.forEach(perm => {
            let cb = document.querySelector(`.perm-cb[value="${perm}"]`);
            if (cb) cb.checked = true;
        });
    }
    
    document.getElementById('editRoleModal').classList.remove('hidden');
}

function closeEditRoleModal() {
    document.getElementById('editRoleModal').classList.add('hidden');
}

function selectAllPermissions() {
    document.querySelectorAll('.perm-cb').forEach(cb => cb.checked = true);
}
</script>
@endsection
