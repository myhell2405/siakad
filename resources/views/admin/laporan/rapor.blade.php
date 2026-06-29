@extends('admin.layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Rapor Siswa</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola data kehadiran, catatan wali kelas, status kenaikan, serta cetak rapor siswa (2 halaman).</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
        <form action="{{ route('admin.laporan.rapor') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Ajaran</label>
                <select name="id_ta" class="w-full border rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ ucfirst($ta->semester) }}) {{ $ta->status == 'Aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                <select name="id_kelas" class="w-full border rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700" onchange="this.form.submit()" {{ !$id_ta ? 'disabled' : '' }}>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $id_kelas == $k->id ? 'selected' : '' }}>
                            {{ $k->kelas->nama_kelas ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="bi bi-filter"></i> Filter Data
                </button>
            </div>
        </form>
    </div>

    @if ($id_kelas)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Daftar Siswa & Pelengkap Rapor (Total: {{ $siswaList->count() }} siswa)</h3>
                <div class="w-full md:w-72">
                    <input type="text" id="searchSiswaRapor" placeholder="Cari nama atau NISN..."
                           class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100/70 text-gray-600 uppercase text-xs font-semibold">
                            <th class="py-3 px-4 text-left w-12">No</th>
                            <th class="py-3 px-4 text-left">NISN</th>
                            <th class="py-3 px-4 text-left">Nama Siswa</th>
                            <th class="py-3 px-4 text-center">Rangking</th>
                            <th class="py-3 px-4 text-left">Ekskul</th>
                            <th class="py-3 px-4 text-center">Kehadiran (S/I/A)</th>
                            <th class="py-3 px-4 text-left">Catatan Walas</th>
                            <th class="py-3 px-4 text-center">Status Naik</th>
                            <th class="py-3 px-4 text-center w-56">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="raporTableBody" class="divide-y divide-gray-100 text-gray-700">
                        @forelse ($siswaList as $index => $sk)
                            @php
                                $r = $raporData->get($sk->id_siswa);
                                $myEks = $nilaiEkskulData->get($sk->id_siswa) ?? collect();
                                $myRank = $rankings->get($sk->id_siswa, '-');
                            @endphp
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="py-4 px-4">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 font-mono text-gray-600">{{ $sk->siswa->nisn ?? '-' }}</td>
                                <td class="py-4 px-4 font-semibold text-gray-800">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                <td class="py-4 px-4 text-center font-bold text-blue-600">
                                    {{ $myRank !== '-' ? '#' . $myRank : '-' }}
                                </td>
                                <td class="py-4 px-4 text-xs">
                                    @forelse ($myEks as $e)
                                        <span class="inline-block bg-purple-100 text-purple-800 px-2 py-0.5 rounded mr-1 mb-1">{{ $e->ekskul?->nama_ekskul ?? '-' }} ({{ $e->predikat }})</span>
                                    @empty
                                        <span class="text-gray-400 italic">-</span>
                                    @endforelse
                                </td>
                                <td class="py-4 px-4 text-center font-mono">
                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded">{{ $r->sakit ?? 0 }}</span> /
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded">{{ $r->izin ?? 0 }}</span> /
                                    <span class="px-2 py-0.5 bg-red-100 text-red-800 rounded">{{ $r->alpa ?? 0 }}</span>
                                </td>
                                <td class="py-4 px-4 text-xs text-gray-600 max-w-xs truncate">{{ $r->catatan_wali_kelas ?? '-' }}</td>
                                <td class="py-4 px-4 text-center font-medium">
                                    @if ($r && $r->status_kenaikan == 'Naik Kelas')
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs">Naik Kelas</span>
                                    @elseif ($r && $r->status_kenaikan == 'Tidak Naik Kelas')
                                        <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs">Tidak Naik</span>
                                    @else
                                        <span class="text-gray-400 text-xs">Belum diisi</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center space-x-1">
                                    @if(in_array(strtolower(session('role')), ['admin', 'wali_kelas']))
                                        <button onclick="openModalRapor({{ $sk->id_siswa }}, '{{ addslashes($sk->siswa->nama_siswa ?? '') }}', {{ $r->sakit ?? 0 }}, {{ $r->izin ?? 0 }}, {{ $r->alpa ?? 0 }}, '{{ addslashes($r->catatan_wali_kelas ?? '') }}', '{{ $r->status_kenaikan ?? '' }}')" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-medium transition-colors shadow-sm inline-flex items-center gap-1">
                                            <i class="bi bi-pencil-square"></i> Isi Data
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.laporan.rapor', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'id_siswa' => $sk->id_siswa, 'print' => 1]) }}" target="_blank" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-medium transition-colors shadow-sm inline-flex items-center gap-1">
                                        <i class="bi bi-printer-fill"></i> Cetak Rapor
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-gray-500">
                                    Belum ada siswa yang terdaftar di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <i class="bi bi-book text-4xl text-blue-400 mb-3 block"></i>
            <p class="text-gray-600 font-medium">Silakan pilih Tahun Ajaran dan Kelas di atas untuk mengelola dan mencetak rapor.</p>
        </div>
    @endif

    @if(in_array(strtolower(session('role')), ['admin', 'wali_kelas']))
    <!-- Modal Form Isi Pelengkap Rapor -->
    <div id="modalRapor" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="font-bold text-lg text-gray-800">Isi Data Pelengkap Rapor</h3>
                <button onclick="closeModalRapor()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <form action="{{ route('admin.laporan.rapor.simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="siswa_id" id="modal_siswa_id">
                <input type="hidden" name="kelas_tahun_ajaran_id" value="{{ $id_kelas }}">

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Siswa</label>
                    <input type="text" id="modal_nama_siswa" class="w-full bg-gray-100 border rounded-lg px-3 py-2 text-gray-700 font-bold" disabled>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Sakit (Hari)</label>
                        <input type="number" name="sakit" id="modal_sakit" min="0" class="w-full border rounded-lg px-3 py-2 text-center focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Izin (Hari)</label>
                        <input type="number" name="izin" id="modal_izin" min="0" class="w-full border rounded-lg px-3 py-2 text-center focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tanpa Ket. (Hari)</label>
                        <input type="number" name="alpa" id="modal_alpa" min="0" class="w-full border rounded-lg px-3 py-2 text-center focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ekstrakurikuler yang Diikuti</label>
                    <input type="hidden" name="has_ekskul_form" value="1">
                    <div class="border rounded-lg p-3 bg-gray-50 max-h-48 overflow-y-auto space-y-2">
                        @forelse ($masterEkskul as $mek)
                            <div class="p-2 bg-white rounded border flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="ekskul[{{ $mek->id_ekskul }}][selected]" value="1" id="ekskul_cb_{{ $mek->id_ekskul }}" class="w-4 h-4 text-blue-600 rounded ekskul-checkbox" data-id="{{ $mek->id_ekskul }}" onchange="toggleEkskulInputs({{ $mek->id_ekskul }})">
                                    <label for="ekskul_cb_{{ $mek->id_ekskul }}" class="font-bold text-sm text-gray-800">{{ $mek->nama_ekskul }}</label>
                                </div>
                                <div id="ekskul_inputs_{{ $mek->id_ekskul }}" class="hidden grid grid-cols-3 gap-2 pl-6">
                                    <div>
                                        <select name="ekskul[{{ $mek->id_ekskul }}][predikat]" id="ekskul_pred_{{ $mek->id_ekskul }}" class="w-full text-xs border rounded px-2 py-1">
                                            <option value="Sangat Baik">Sangat Baik</option>
                                            <option value="Baik" selected>Baik</option>
                                            <option value="Cukup">Cukup</option>
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="text" name="ekskul[{{ $mek->id_ekskul }}][keterangan]" id="ekskul_ket_{{ $mek->id_ekskul }}" placeholder="Keterangan..." class="w-full text-xs border rounded px-2 py-1" value="Mengikuti kegiatan dengan aktif dan baik.">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-500 italic">Belum ada data master ekskul.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Wali Kelas</label>
                    <textarea name="catatan_wali_kelas" id="modal_catatan" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 placeholder-gray-400 text-sm" placeholder="Tulis motivasi atau saran pengembangan untuk siswa..."></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Kenaikan Kelas</label>
                    <select name="status_kenaikan" id="modal_status" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Status --</option>
                        <option value="Naik Kelas">Naik Kelas</option>
                        <option value="Tidak Naik Kelas">Tidak Naik Kelas</option>
                        <option value="Lulus">Lulus (Untuk Kelas VI)</option>
                        <option value="Tidak Lulus">Tidak Lulus</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModalRapor()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium text-gray-700">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const ekskulDataSiswa = {
            @foreach ($siswaList as $sk)
                @php
                    $myEks = $nilaiEkskulData->get($sk->id_siswa) ?? collect();
                @endphp
                "{{ $sk->id_siswa }}": [
                    @foreach ($myEks as $e)
                        { id_ekskul: {{ $e->id_ekskul }}, predikat: "{{ addslashes($e->predikat ?? '') }}", keterangan: "{{ addslashes($e->keterangan ?? '') }}" },
                    @endforeach
                ] @if(!$loop->last),@endif
            @endforeach
        };

        function toggleEkskulInputs(id) {
            const cb = document.getElementById('ekskul_cb_' + id);
            const inputs = document.getElementById('ekskul_inputs_' + id);
            if (cb && inputs) {
                if (cb.checked) {
                    inputs.classList.remove('hidden');
                } else {
                    inputs.classList.add('hidden');
                }
            }
        }

        function openModalRapor(id, nama, sakit, izin, alpa, catatan, status) {
            document.getElementById('modal_siswa_id').value = id;
            document.getElementById('modal_nama_siswa').value = nama;
            document.getElementById('modal_sakit').value = sakit;
            document.getElementById('modal_izin').value = izin;
            document.getElementById('modal_alpa').value = alpa;
            document.getElementById('modal_catatan').value = catatan;
            document.getElementById('modal_status').value = status;

            // Reset all ekskul checkboxes
            document.querySelectorAll('.ekskul-checkbox').forEach(cb => {
                cb.checked = false;
                toggleEkskulInputs(cb.dataset.id);
            });

            // Populate ekskul if exists
            if (ekskulDataSiswa[id]) {
                ekskulDataSiswa[id].forEach(item => {
                    const cb = document.getElementById('ekskul_cb_' + item.id_ekskul);
                    if (cb) {
                        cb.checked = true;
                        if (item.predikat) document.getElementById('ekskul_pred_' + item.id_ekskul).value = item.predikat;
                        if (item.keterangan) document.getElementById('ekskul_ket_' + item.id_ekskul).value = item.keterangan;
                        toggleEkskulInputs(item.id_ekskul);
                    }
                });
            }

            document.getElementById('modalRapor').classList.remove('hidden');
        }

        function closeModalRapor() {
            document.getElementById('modalRapor').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchSiswaRapor');
            const tbody = document.getElementById('raporTableBody');
            if (searchInput && tbody) {
                searchInput.addEventListener('input', function () {
                    const keyword = this.value.toLowerCase().trim();
                    const rows = tbody.querySelectorAll('tr');
                    rows.forEach(row => {
                        if (row.querySelectorAll('td').length === 1) return;
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(keyword) ? '' : 'none';
                    });
                });
            }
        });
    </script>
    @endif
@endsection
