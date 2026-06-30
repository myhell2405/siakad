@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-500/30 text-emerald-900 p-4 rounded-2xl shadow-xs flex items-center justify-between text-xs font-mono font-bold uppercase">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">✕</button>
        </div>
    @endif

    {{-- HERO HEADER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-sliders text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>ACCESS CONTROL LIST</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">MATRIKS ROLE & HAK AKSES (RBAC)</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">
                    KONFIGURASI DINAMIS IZIN AKSES FITUR DAN MENU UNTUK SETIAP PERAN PENGGUNA
                </p>
            </div>
        </div>

        <div class="relative z-10 shrink-0">
            <a href="{{ route('admin.akun.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-void hover:bg-black text-white rounded-xl text-xs font-mono font-bold transition-all shadow-md active:scale-95 uppercase">
                <i class="bi bi-people-fill text-signal"></i> KELOLA AKUN PENGGUNA
            </a>
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="bg-void rounded-3xl text-white p-8 border border-black shadow-md relative overflow-hidden font-mono">
        <div class="flex items-start gap-5 relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-surface text-void flex items-center justify-center text-xl shrink-0 border border-black/10">
                <i class="bi bi-shield-check text-cobalt"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-sm font-black tracking-tight text-white uppercase">DYNAMIC ACCESS CONTROL LIST (ACL)</h3>
                <p class="text-gray-300 text-xs font-medium leading-relaxed max-w-4xl uppercase">
                    Sistem Informasi Akademik ini menerapkan kendali akses dinamis berbasis peran. Admin dapat menyesuaikan fitur apa saja yang dapat diakses oleh setiap Role secara mandiri dan real-time dengan mengeklik tombol <span class="text-signal font-bold">EDIT IZIN</span> pada tabel di bawah ini.
                </p>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-black/10 bg-gray-50 flex justify-between items-center">
            <h3 class="font-black text-void text-sm uppercase flex items-center gap-2">
                <i class="bi bi-lock-fill text-cobalt text-base"></i> DAFTAR ROLE TERDAFTAR
            </h3>
            <span class="text-[10px] font-mono font-bold uppercase bg-void text-white px-3 py-1 rounded">TOTAL: {{ $roles->count() }} ROLE</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface text-void font-mono text-[10px] uppercase tracking-wider border-b border-black/10">
                        <th class="py-4 pl-6 text-center w-16">ID</th>
                        <th class="py-4 px-6">KODE ROLE</th>
                        <th class="py-4 px-6">DESKRIPSI PERAN</th>
                        <th class="py-4 px-6">DAFTAR HAK AKSES FITUR & MENU TERKONFIGURASI</th>
                        <th class="py-4 px-6 text-center w-32">TOTAL AKUN</th>
                        <th class="py-4 pr-6 text-center w-32">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                    @php
                        $allFeatures = [
                            'kelola_master' => ['label' => 'KELOLA DATA MASTER', 'color' => 'bg-gray-100 text-void border border-black/10 font-mono font-bold'],
                            'kelola_akun' => ['label' => 'KELOLA AKUN & ROLE', 'color' => 'bg-gray-100 text-void border border-black/10 font-mono font-bold'],
                            'pembagian_kelas' => ['label' => 'PEMBAGIAN KELAS AKTIF', 'color' => 'bg-cobalt/10 text-cobalt border border-cobalt/20 font-mono font-bold'],
                            'kelola_nilai_admin' => ['label' => 'KELOLA NILAI MASSAL', 'color' => 'bg-cobalt/10 text-cobalt border border-cobalt/20 font-mono font-bold'],
                            'laporan_akademik' => ['label' => 'LAPORAN AKADEMIK', 'color' => 'bg-cobalt/10 text-cobalt border border-cobalt/20 font-mono font-bold'],
                            'portal_guru' => ['label' => 'AKSES PORTAL GURU', 'color' => 'bg-surface text-void border border-black/10 font-mono font-bold'],
                            'input_nilai_mapel' => ['label' => 'INPUT NILAI MAPEL', 'color' => 'bg-surface text-void border border-black/10 font-mono font-bold'],
                            'validasi_nilai' => ['label' => 'VALIDASI NILAI KELAS', 'color' => 'bg-surface text-void border border-black/10 font-mono font-bold'],
                            'cetak_rapor_kelas' => ['label' => 'CETAK RAPOR SISWA', 'color' => 'bg-surface text-void border border-black/10 font-mono font-bold'],
                            'portal_siswa' => ['label' => 'AKSES PORTAL SISWA', 'color' => 'bg-emerald-100 text-emerald-900 border border-emerald-300 font-mono font-bold'],
                            'view_nilai_siswa' => ['label' => 'LIHAT TRANSKRIP NILAI', 'color' => 'bg-emerald-100 text-emerald-900 border border-emerald-300 font-mono font-bold'],
                            'cetak_rapor_siswa' => ['label' => 'CETAK RAPOR MANDIRI', 'color' => 'bg-emerald-100 text-emerald-900 border border-emerald-300 font-mono font-bold'],
                            'portal_kepsek' => ['label' => 'AKSES PORTAL KEPSEK', 'color' => 'bg-signal/20 text-void border border-black/10 font-mono font-bold'],
                            'monitoring_akademik' => ['label' => 'MONITORING STATISTIK', 'color' => 'bg-signal/20 text-void border border-black/10 font-mono font-bold'],
                            'view_laporan' => ['label' => 'REKAPITULASI LAPORAN', 'color' => 'bg-signal/20 text-void border border-black/10 font-mono font-bold'],
                        ];
                    @endphp
                    @foreach($roles as $role)
                        @php
                            $badgeColor = match($role->nama_role) {
                                'admin' => 'bg-void text-signal border border-black font-mono font-bold',
                                'guru' => 'bg-gray-100 text-void border border-black/10 font-mono font-bold',
                                'wali_kelas' => 'bg-cobalt/10 text-cobalt border border-cobalt/20 font-mono font-bold',
                                'kepala_sekolah' => 'bg-signal/20 text-void border border-black/10 font-mono font-bold',
                                'siswa' => 'bg-surface text-void border border-black/10 font-mono font-bold',
                                default => 'bg-gray-100 text-gray-700 font-mono font-bold'
                            };
                            $perms = is_array($role->permissions) ? $role->permissions : [];
                        @endphp
                        <tr class="hover:bg-gray-50/80 transition duration-150">
                            <td class="py-5 pl-6 text-center font-mono font-bold text-gray-400">{{ $role->id_role }}</td>
                            <td class="py-5 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded text-[10px] uppercase {{ $badgeColor }}">
                                    {{ strtoupper($role->nama_role) }}
                                </span>
                            </td>
                            <td class="py-5 px-6 text-void font-bold whitespace-nowrap uppercase">{{ $role->deskripsi }}</td>
                            <td class="py-5 px-6">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($perms as $p)
                                        @if(isset($allFeatures[$p]))
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded text-[10px] uppercase {{ $allFeatures[$p]['color'] }}">
                                                <i class="bi bi-check2 text-xs font-black"></i> {{ $allFeatures[$p]['label'] }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded text-[10px] font-mono font-bold bg-gray-100 text-gray-700 uppercase">{{ $p }}</span>
                                        @endif
                                    @empty
                                        <span class="text-gray-400 italic text-xs font-mono uppercase">BELUM ADA HAK AKSES DIKONFIGURASI</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-5 px-6 text-center font-mono font-black text-void text-sm whitespace-nowrap">
                                <span class="px-3 py-1 bg-gray-100 rounded border border-black/10">{{ $role->users_count }} <span class="text-[10px] font-mono text-gray-500 uppercase">AKUN</span></span>
                            </td>
                            <td class="py-5 pr-6 text-center whitespace-nowrap">
                                <button type="button" 
                                    onclick="openEditRoleModal({{ $role->id_role }}, '{{ strtoupper($role->nama_role) }}', {{ json_encode($perms) }})"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-void text-void hover:text-white border border-black/10 rounded-xl font-mono font-bold text-xs transition shadow-2xs active:scale-95 uppercase">
                                    <i class="bi bi-gear-fill text-signal"></i> EDIT IZIN
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
        <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-xs" onclick="closeEditRoleModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-black">
            <form id="editRoleForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <!-- Modal Header -->
                <div class="bg-void px-8 py-6 text-white flex justify-between items-center border-b border-black">
                    <div class="space-y-1">
                        <div class="inline-flex items-center gap-2 rounded px-2 py-0.5 text-[10px] uppercase tracking-widest font-mono font-bold bg-surface text-void border border-black/10">
                            <span>RBAC CONFIG</span>
                        </div>
                        <h3 class="text-base font-black uppercase">KONFIGURASI HAK AKSES ROLE: <span id="modalRoleName" class="text-signal font-extrabold"></span></h3>
                    </div>
                    <button type="button" onclick="closeEditRoleModal()" class="w-8 h-8 rounded-xl bg-surface/20 hover:bg-surface/30 text-white flex items-center justify-center font-bold transition">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 sm:p-8 space-y-6 max-h-[65vh] overflow-y-auto font-mono">
                    
                    <!-- Group 1: Administrasi & Master -->
                    <div class="bg-gray-50 p-5 rounded-2xl border border-black/10">
                        <h4 class="text-xs font-black text-void uppercase tracking-wider border-b border-black/10 pb-3 mb-4 flex items-center gap-2.5">
                            <i class="bi bi-database-fill text-signal text-base"></i> KELOMPOK ADMINISTRASI & DATA MASTER
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="kelola_master" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">KELOLA DATA MASTER SEKOLAH</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="kelola_akun" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">KELOLA AKUN & ROLE RBAC</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="pembagian_kelas" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">PEMBAGIAN KELAS AKTIF</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="kelola_nilai_admin" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">KELOLA NILAI MASSAL (ADMIN)</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="laporan_akademik" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">LAPORAN AKADEMIK SEKOLAH</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 2: Portal Guru & Wali Kelas -->
                    <div class="bg-gray-50 p-5 rounded-2xl border border-black/10">
                        <h4 class="text-xs font-black text-void uppercase tracking-wider border-b border-black/10 pb-3 mb-4 flex items-center gap-2.5">
                            <i class="bi bi-person-badge-fill text-cobalt text-base"></i> KELOMPOK PORTAL GURU & WALI KELAS
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="portal_guru" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">AKSES PORTAL DASHBOARD GURU</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="input_nilai_mapel" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">INPUT & EDIT NILAI MAPEL</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="validasi_nilai" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">VALIDASI NILAI (WALI KELAS)</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="cetak_rapor_kelas" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">CETAK RAPOR PDF SISWA</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 3: Portal Siswa & Orang Tua -->
                    <div class="bg-gray-50 p-5 rounded-2xl border border-black/10">
                        <h4 class="text-xs font-black text-void uppercase tracking-wider border-b border-black/10 pb-3 mb-4 flex items-center gap-2.5">
                            <i class="bi bi-mortarboard-fill text-emerald-700 text-base"></i> KELOMPOK PORTAL SISWA & ORANG TUA
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="portal_siswa" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">AKSES PORTAL DASHBOARD SISWA</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="view_nilai_siswa" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">LIHAT TRANSKRIP NILAI SISWA</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="cetak_rapor_siswa" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">CETAK RAPOR MANDIRI</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 4: Portal Kepala Sekolah -->
                    <div class="bg-gray-50 p-5 rounded-2xl border border-black/10">
                        <h4 class="text-xs font-black text-void uppercase tracking-wider border-b border-black/10 pb-3 mb-4 flex items-center gap-2.5">
                            <i class="bi bi-building-fill text-signal text-base"></i> KELOMPOK PORTAL KEPALA SEKOLAH
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="portal_kepsek" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">AKSES DASHBOARD KEPALA SEKOLAH</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="monitoring_akademik" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">MONITORING STATISTIK & GRAFIK</span>
                            </label>
                            <label class="flex items-center gap-3 text-xs font-bold text-void cursor-pointer bg-white p-3.5 rounded-xl border border-black/10 hover:border-black transition">
                                <input type="checkbox" name="permissions[]" value="view_laporan" class="perm-cb rounded border-black/20 text-void focus:ring-void w-4 h-4">
                                <span class="uppercase">LIHAT REKAPITULASI LAPORAN</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-8 py-5 flex items-center justify-between border-t border-black/10 font-mono">
                    <button type="button" onclick="selectAllPermissions()" class="text-xs font-bold text-cobalt hover:text-void underline transition uppercase">
                        CENTANG SEMUA FITUR
                    </button>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeEditRoleModal()" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-void text-xs font-bold rounded-xl transition uppercase">
                            BATAL
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-void hover:bg-black text-white text-xs font-bold rounded-xl shadow-md transition active:scale-95 uppercase inline-flex items-center gap-2">
                            <i class="bi bi-save text-signal"></i> SIMPAN KONFIGURASI
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
