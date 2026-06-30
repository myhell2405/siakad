@extends('admin.layout')

@section('content')
<div class="space-y-10 font-sans text-slate-800 pb-16">

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

    {{-- ================================================
         HERO HEADER SECTION
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6 ring-1 ring-slate-900/[0.03]">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-purple-500/10 via-indigo-500/10 to-blue-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-purple-500/25 shrink-0">
                <i class="bi bi-sliders text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-purple-50 text-purple-700 ring-1 ring-purple-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-600"></span>
                    </span>
                    <span>Access Control List</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Matriks Role & Hak Akses (RBAC)</h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span>Konfigurasi dinamis izin akses fitur dan menu untuk setiap peran pengguna</span>
                </p>
            </div>
        </div>

        <div class="relative z-10 shrink-0">
            <a href="{{ route('admin.akun.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-2xl text-xs font-bold transition-all shadow-md shadow-indigo-500/20 active:scale-95">
                <i class="bi bi-people-fill"></i> Kelola Akun Pengguna
            </a>
        </div>
    </div>

    {{-- ================================================
         INFO CARD
         ================================================ --}}
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl text-white p-8 shadow-xl ring-1 ring-white/10 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="flex items-start gap-5 relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-xl shrink-0 ring-1 ring-white/20">
                <i class="bi bi-shield-check text-indigo-300"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-black tracking-tight text-white">Dynamic Access Control List (ACL)</h3>
                <p class="text-slate-300 text-xs font-medium leading-relaxed max-w-4xl">
                    Sistem Informasi Akademik ini menerapkan kendali akses dinamis berbasis peran. Admin dapat menyesuaikan fitur apa saja yang dapat diakses oleh setiap Role secara mandiri dan *real-time* dengan mengeklik tombol <span class="text-indigo-300 font-bold">Edit Izin</span> pada tabel di bawah ini.
                </p>
            </div>
        </div>
    </div>

    {{-- ================================================
         TABLE CARD
         ================================================ --}}
    <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                        <th class="py-4 px-6 text-center w-16">ID</th>
                        <th class="py-4 px-6">Kode Role</th>
                        <th class="py-4 px-6">Deskripsi Peran</th>
                        <th class="py-4 px-6">Daftar Hak Akses Fitur & Menu Terkonfigurasi</th>
                        <th class="py-4 px-6 text-center w-28">Total Akun</th>
                        <th class="py-4 px-6 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                    @php
                        $allFeatures = [
                            'kelola_master' => ['label' => 'Kelola Data Master', 'color' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-500/20'],
                            'kelola_akun' => ['label' => 'Kelola Akun & Role', 'color' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-500/20'],
                            'pembagian_kelas' => ['label' => 'Pembagian Kelas Aktif', 'color' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-500/20'],
                            'kelola_nilai_admin' => ['label' => 'Kelola Nilai Massal', 'color' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-500/20'],
                            'laporan_akademik' => ['label' => 'Laporan Akademik', 'color' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-500/20'],
                            'portal_guru' => ['label' => 'Akses Portal Guru', 'color' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20'],
                            'input_nilai_mapel' => ['label' => 'Input Nilai Mapel', 'color' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20'],
                            'validasi_nilai' => ['label' => 'Validasi Nilai Kelas', 'color' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20'],
                            'cetak_rapor_kelas' => ['label' => 'Cetak Rapor Siswa', 'color' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20'],
                            'portal_siswa' => ['label' => 'Akses Portal Siswa', 'color' => 'bg-teal-50 text-teal-700 ring-1 ring-teal-500/20'],
                            'view_nilai_siswa' => ['label' => 'Lihat Transkrip Nilai', 'color' => 'bg-teal-50 text-teal-700 ring-1 ring-teal-500/20'],
                            'cetak_rapor_siswa' => ['label' => 'Cetak Rapor Mandiri', 'color' => 'bg-teal-50 text-teal-700 ring-1 ring-teal-500/20'],
                            'portal_kepsek' => ['label' => 'Akses Portal Kepsek', 'color' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20'],
                            'monitoring_akademik' => ['label' => 'Monitoring Statistik', 'color' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20'],
                            'view_laporan' => ['label' => 'Rekapitulasi Laporan', 'color' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20'],
                        ];
                    @endphp
                    @foreach($roles as $role)
                        @php
                            $badgeColor = match($role->nama_role) {
                                'admin' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-500/20 font-black',
                                'guru' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-500/20 font-black',
                                'wali_kelas' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-500/20 font-black',
                                'kepala_sekolah' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20 font-black',
                                'siswa' => 'bg-teal-50 text-teal-700 ring-1 ring-teal-500/20 font-black',
                                default => 'bg-slate-100 text-slate-700 font-bold'
                            };
                            $perms = is_array($role->permissions) ? $role->permissions : [];
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="py-5 px-6 text-center font-bold text-slate-400">{{ $role->id_role }}</td>
                            <td class="py-5 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] {{ $badgeColor }}">
                                    {{ $role->nama_role }}
                                </span>
                            </td>
                            <td class="py-5 px-6 text-slate-700 font-bold whitespace-nowrap">{{ $role->deskripsi }}</td>
                            <td class="py-5 px-6">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($perms as $p)
                                        @if(isset($allFeatures[$p]))
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $allFeatures[$p]['color'] }}">
                                                <i class="bi bi-check2 text-xs font-black"></i> {{ $allFeatures[$p]['label'] }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-700">{{ $p }}</span>
                                        @endif
                                    @empty
                                        <span class="text-slate-400 italic text-xs font-medium">Belum ada hak akses dikonfigurasi</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-5 px-6 text-center font-black text-slate-900 text-sm whitespace-nowrap">
                                <span class="px-3 py-1 bg-slate-100 rounded-xl">{{ $role->users_count }} <span class="text-[11px] font-semibold text-slate-400">akun</span></span>
                            </td>
                            <td class="py-5 px-6 text-center whitespace-nowrap">
                                <button type="button" 
                                    onclick="openEditRoleModal({{ $role->id_role }}, '{{ strtoupper($role->nama_role) }}', {{ json_encode($perms) }})"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white rounded-xl font-bold text-xs transition shadow-2xs active:scale-95">
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
        <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="closeEditRoleModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full ring-1 ring-slate-900/10 animate-scale-up">
            <form id="editRoleForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 px-8 py-6 text-white flex justify-between items-center">
                    <div class="space-y-1">
                        <div class="inline-flex items-center gap-2 rounded-full px-2.5 py-0.5 text-[10px] uppercase tracking-widest font-black bg-indigo-500/20 text-indigo-300 ring-1 ring-indigo-400/30">
                            <span>RBAC CONFIG</span>
                        </div>
                        <h3 class="text-base font-black">Konfigurasi Hak Akses Role: <span id="modalRoleName" class="text-indigo-300 font-extrabold"></span></h3>
                    </div>
                    <button type="button" onclick="closeEditRoleModal()" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center font-bold transition">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-8 space-y-6 max-h-[65vh] overflow-y-auto">
                    
                    <!-- Group 1: Administrasi & Master -->
                    <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider border-b border-slate-200/80 pb-3 mb-4 flex items-center gap-2.5">
                            <i class="bi bi-database-fill text-purple-600 text-sm"></i> Kelompok Administrasi & Data Master
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="kelola_master" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Kelola Data Master Sekolah</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="kelola_akun" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Kelola Akun & Role RBAC</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="pembagian_kelas" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Pembagian Kelas Aktif</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="kelola_nilai_admin" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Kelola Nilai Massal (Admin)</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="laporan_akademik" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Laporan Akademik Sekolah</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 2: Portal Guru & Wali Kelas -->
                    <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider border-b border-slate-200/80 pb-3 mb-4 flex items-center gap-2.5">
                            <i class="bi bi-person-badge-fill text-indigo-600 text-sm"></i> Kelompok Portal Guru & Wali Kelas
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="portal_guru" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Akses Portal Dashboard Guru</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="input_nilai_mapel" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Input & Edit Nilai Mapel</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="validasi_nilai" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Validasi Nilai (Wali Kelas)</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="cetak_rapor_kelas" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Cetak Rapor PDF Siswa</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 3: Portal Siswa & Orang Tua -->
                    <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider border-b border-slate-200/80 pb-3 mb-4 flex items-center gap-2.5">
                            <i class="bi bi-mortarboard-fill text-teal-600 text-sm"></i> Kelompok Portal Siswa & Orang Tua
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="portal_siswa" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Akses Portal Dashboard Siswa</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="view_nilai_siswa" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Lihat Transkrip Nilai Siswa</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="cetak_rapor_siswa" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Cetak Rapor Mandiri</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 4: Portal Kepala Sekolah -->
                    <div class="bg-slate-50/80 p-5 rounded-2xl ring-1 ring-slate-200/60">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider border-b border-slate-200/80 pb-3 mb-4 flex items-center gap-2.5">
                            <i class="bi bi-building-fill text-amber-600 text-sm"></i> Kelompok Portal Kepala Sekolah
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="portal_kepsek" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Akses Dashboard Kepala Sekolah</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="monitoring_akademik" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Monitoring Statistik & Grafik</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-slate-700 cursor-pointer bg-white p-3 rounded-xl ring-1 ring-slate-200/60 hover:ring-indigo-500/40 transition">
                                <input type="checkbox" name="permissions[]" value="view_laporan" class="perm-cb rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                <span>Lihat Rekapitulasi Laporan</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50/80 px-8 py-5 flex items-center justify-between border-t border-slate-100">
                    <button type="button" onclick="selectAllPermissions()" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 underline transition">
                        Centang Semua Fitur
                    </button>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeEditRoleModal()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-800 text-xs font-bold rounded-2xl transition">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-xs font-bold rounded-2xl shadow-lg shadow-indigo-500/25 transition active:scale-95">
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
