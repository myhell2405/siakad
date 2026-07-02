<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Siswa - {{ $siswaKelas->siswa->nama_siswa ?? '' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 0mm !important;
        }
        body {
            font-family: 'Arial', sans-serif;
            color: #000;
            line-height: 1.5;
        }
        .print-sheet {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm;
            margin: 0 auto 2rem auto;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            box-sizing: border-box;
        }
        .page-break {
            page-break-after: always;
        }
        @media print {
            @page {
                size: A4 portrait;
                margin: 0mm !important;
            }
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
                margin: 0;
                background: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .print-sheet {
                width: 210mm !important;
                min-height: 297mm !important;
                padding: 15mm 20mm !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
                box-sizing: border-box !important;
            }
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000;
            padding: 6px 8px;
        }
    </style>
</head>
<body class="bg-gray-100 py-8 px-4 print:bg-white print:py-0 print:px-0">

    <!-- Top Action Bar (Hidden on Print) -->
    <div class="max-w-4xl mx-auto mb-6 bg-white p-4 rounded-xl shadow no-print border flex flex-col gap-3">
        <div class="flex justify-between items-center flex-wrap gap-2">
            <div class="flex items-center gap-3">
                <button onclick="window.close()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-semibold transition-colors">
                    <i class="bi bi-arrow-left"></i> Kembali / Tutup
                </button>
                <span class="text-sm font-medium text-gray-600">Pratinjau Cetak Rapor (2 Halaman A4)</span>
            </div>
            <button onclick="window.print()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold shadow-lg transition-colors flex items-center gap-2">
                <i class="bi bi-printer-fill"></i> Cetak Rapor Lengkap
            </button>
        </div>
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-2.5 rounded-lg text-xs flex items-center gap-2">
            <i class="bi bi-info-circle-fill text-amber-600 text-base shrink-0"></i>
            <span><strong>Tips Cetak Bersih:</strong> Jika masih muncul tulisan tanggal/waktu (misal: <i>7/2/26, 11:10 AM</i>) atau URL di pojok atas/bawah kertas, pastikan pada pengaturan cetak browser Anda (Setelan Tambahan / More Settings) opsi <strong>Headers and footers</strong> (Header dan catatan kaki) sudah <strong>tidak dicentang</strong>.</span>
        </div>
    </div>

    @php
        $s = $siswaKelas->siswa;
        $k = $siswaKelas->kelasTahunAjaran;
        $ta = $k->tahunAjaran;
        $wali = $k->waliKelas;

        // Calculate grades sum and avg
        $totalNilai = 0;
        $countMapel = 0;
        foreach ($mapelList as $m) {
            $n = $nilaiList->get($m->id_mapel);
            if ($n && $n->nilai_akhir !== null) {
                $totalNilai += $n->nilai_akhir;
                $countMapel++;
            }
        }
        $rataRata = $countMapel > 0 ? round($totalNilai / $countMapel, 2) : 0;
    @endphp

    <!-- ================= HALAMAN 1 ================= -->
    <div class="print-sheet">
        
        <div class="text-center font-bold text-lg uppercase mb-4">
            SD NEGERI 01 DURIAN GADANG<br>
            LAPORAN PERKEMBANGAN BELAJAR SISWA
        </div>

        <div class="flex justify-center mb-6">
            <div class="border-2 border-black px-6 py-1 font-bold text-sm">HALAMAN 1</div>
        </div>

        <!-- Header Identitas -->
        <div class="border border-black p-4 mb-6 rounded text-sm">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <table class="w-full">
                        <tr>
                            <td class="w-24 font-semibold">Nama Siswa</td>
                            <td class="w-4">:</td>
                            <td class="font-bold uppercase">{{ $s->nama_siswa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold">NISN</td>
                            <td>:</td>
                            <td>{{ $s->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold align-top">Alamat</td>
                            <td class="align-top">:</td>
                            <td>{{ $s->alamat_siswa ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="w-full">
                        <tr>
                            <td class="w-28 font-semibold">Kelas</td>
                            <td class="w-4">:</td>
                            <td class="font-bold">{{ $k->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Tahun Ajaran</td>
                            <td>:</td>
                            <td>{{ $ta->tahun_ajaran ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Semester</td>
                            <td>:</td>
                            <td>{{ ucfirst($ta->semester ?? '-') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="font-bold text-center mb-2 text-sm">DAFTAR NILAI SISWA</div>

        <!-- Tabel Nilai -->
        <table class="w-full text-sm table-bordered mb-4 border-collapse">
            <thead>
                <tr class="bg-gray-100 text-center font-bold">
                    <th class="w-10">No</th>
                    <th>Mata Pelajaran</th>
                    <th class="w-16">KKM</th>
                    <th class="w-24">Nilai Akhir</th>
                    <th class="w-24">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mapelList as $index => $m)
                    @php
                        $n = $nilaiList->get($m->id_mapel);
                        $val = $n ? $n->nilai_akhir : null;
                        $kkm = $m->kkm ?? 75;
                        $predikat = '-';
                        if ($val !== null) {
                            if ($val >= 90) $predikat = 'A';
                            elseif ($val >= 80) $predikat = 'B';
                            elseif ($val >= $kkm) $predikat = 'C';
                            else $predikat = 'D';
                        }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $m->nama_mapel }}</td>
                        <td class="text-center">{{ $kkm }}</td>
                        <td class="text-center font-bold">{{ $val !== null ? $val : '-' }}</td>
                        <td class="text-center font-semibold">{{ $predikat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Rata-rata -->
        <table class="w-full text-sm table-bordered mb-6 border-collapse text-center font-bold">
            <tr class="bg-gray-50">
                <td class="w-1/3">Jumlah Nilai<br><span class="text-base text-black">{{ $totalNilai }}</span></td>
                <td class="w-1/3">Rata-rata<br><span class="text-base text-black">{{ $rataRata }}</span></td>
                <td class="w-1/3">Rangking<br><span class="text-base text-black">{{ isset($rangking) && $rangking !== '-' ? $rangking . ' dari ' . ($totalSiswaKelas ?? '-') . ' Siswa' : '-' }}</span></td>
            </tr>
        </table>

        <!-- Keterangan Kenaikan Kelas -->
        <div class="border border-black p-4 mb-8 text-sm">
            <div class="font-bold mb-2">Keterangan Kenaikan Kelas</div>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 font-medium">
                    <input type="checkbox" disabled {{ $rapor && in_array($rapor->status_kenaikan, ['Naik Kelas', 'Lulus']) ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                    Naik Kelas / Lulus
                </label>
                <label class="flex items-center gap-2 font-medium">
                    <input type="checkbox" disabled {{ $rapor && in_array($rapor->status_kenaikan, ['Tidak Naik Kelas', 'Tidak Lulus']) ? 'checked' : '' }} class="w-4 h-4 text-red-600">
                    Tidak Naik Kelas / Tidak Lulus
                </label>
            </div>
        </div>

        <!-- Tanda Tangan Halaman 1 -->
        <div class="grid grid-cols-2 text-center text-sm pt-4">
            <div>
                Mengetahui,<br>Kepala Sekolah
                <div class="h-20"></div>
                <span class="font-bold underline">___________________________</span><br>
                NIP. ........................................
            </div>
            <div>
                Durian Gadang, {{ date('d F Y') }}<br>Wali Kelas
                <div class="h-20"></div>
                <span class="font-bold underline">{{ $wali->nama_lengkap ?? '___________________________' }}</span><br>
                NIP. {{ $wali->nip ?? '........................................' }}
            </div>
        </div>

    </div>

    <!-- Page Break for Print -->
    <div class="page-break"></div>

    <!-- ================= HALAMAN 2 ================= -->
    <div class="print-sheet">
        
        <div class="text-center font-bold text-lg uppercase mb-4">
            SD NEGERI 01 DURIAN GADANG<br>
            LAPORAN PERKEMBANGAN BELAJAR SISWA
        </div>

        <div class="flex justify-center mb-6">
            <div class="border-2 border-black px-6 py-1 font-bold text-sm">HALAMAN 2</div>
        </div>

        <div class="font-bold text-center mb-2 text-sm uppercase">KEGIATAN EKSTRAKURIKULER</div>

        <!-- Tabel Ekskul -->
        <table class="w-full text-sm table-bordered mb-6 border-collapse">
            <thead>
                <tr class="bg-gray-100 text-center font-bold">
                    <th class="w-10">No</th>
                    <th>Ekstrakurikuler</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ekskulList as $idx => $ek)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="font-medium">{{ $ek->ekskul?->nama_ekskul ?? '-' }}</td>
                        <td>{{ $ek->predikat ?? 'Baik' }} - {{ $ek->keterangan ?? 'Mengikuti kegiatan dengan aktif dan baik.' }}</td>
                    </tr>
                @empty
                    @for ($i = 1; $i <= 3; $i++)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor
                @endforelse
            </tbody>
        </table>

        <div class="font-bold text-center mb-2 text-sm uppercase">KEHADIRAN SISWA</div>

        @php
            $sakit = $rapor->sakit ?? 0;
            $izin = $rapor->izin ?? 0;
            $alpa = $rapor->alpa ?? 0;
            $jmlHadir = $sakit + $izin + $alpa;
        @endphp

        <!-- Tabel Kehadiran -->
        <table class="w-full text-sm table-bordered mb-6 border-collapse">
            <thead>
                <tr class="bg-gray-100 text-center font-bold">
                    <th>Keterangan</th>
                    <th class="w-36">Jumlah Hari</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-medium">Sakit</td>
                    <td class="text-center">{{ $sakit }} Hari</td>
                </tr>
                <tr>
                    <td class="font-medium">Izin</td>
                    <td class="text-center">{{ $izin }} Hari</td>
                </tr>
                <tr>
                    <td class="font-medium">Tanpa Keterangan</td>
                    <td class="text-center">{{ $alpa }} Hari</td>
                </tr>
                <tr class="bg-gray-50 font-bold">
                    <td class="text-center">Jumlah</td>
                    <td class="text-center">{{ $jmlHadir }} Hari</td>
                </tr>
            </tbody>
        </table>

        <!-- Catatan Wali Kelas -->
        <div class="font-bold text-center mb-2 text-sm uppercase">CATATAN WALI KELAS</div>
        <div class="border border-black p-4 mb-10 min-h-[100px] text-sm italic bg-gray-50/50">
            "{{ $rapor->catatan_wali_kelas ?? 'Tingkatkan terus semangat belajarmu dan pertahankan prestasimu!' }}"
        </div>

        <!-- Tanda Tangan Halaman 2 -->
        <div class="grid grid-cols-2 text-center text-sm pt-6">
            <div>
                Mengetahui,<br>Kepala Sekolah
                <div class="h-20"></div>
                <span class="font-bold underline">___________________________</span><br>
                NIP. ........................................
            </div>
            <div>
                Durian Gadang, {{ date('d F Y') }}<br>Wali Kelas
                <div class="h-20"></div>
                <span class="font-bold underline">{{ $wali->nama_lengkap ?? '___________________________' }}</span><br>
                NIP. {{ $wali->nip ?? '........................................' }}
            </div>
        </div>

    </div>

</body>
</html>
