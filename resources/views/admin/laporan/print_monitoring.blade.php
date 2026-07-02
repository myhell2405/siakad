<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap Nilai Akademik Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @page {
            size: A4 landscape;
            margin: 0mm !important;
        }
        body {
            font-family: 'Arial', sans-serif;
            color: #000;
            line-height: 1.5;
        }
        .print-sheet {
            width: 297mm;
            min-height: 210mm;
            padding: 15mm 20mm;
            margin: 0 auto 2rem auto;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            box-sizing: border-box;
        }
        @media print {
            @page {
                size: A4 landscape;
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
                width: 297mm !important;
                min-height: 210mm !important;
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
    <div class="max-w-6xl mx-auto mb-6 bg-white p-4 rounded-xl shadow no-print border flex flex-col gap-3">
        <div class="flex justify-between items-center flex-wrap gap-2">
            <div class="flex items-center gap-3">
                <button onclick="window.close()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-semibold transition-colors">
                    <i class="bi bi-arrow-left"></i> Kembali / Tutup
                </button>
                <span class="text-sm font-medium text-gray-600">Pratinjau Cetak Laporan Rekap Akademik (A4 Landscape)</span>
            </div>
            <button onclick="window.print()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold shadow-lg transition-colors flex items-center gap-2">
                <i class="bi bi-printer-fill"></i> Cetak Laporan Sekarang
            </button>
        </div>
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-2.5 rounded-lg text-xs flex items-center gap-2">
            <i class="bi bi-info-circle-fill text-amber-600 text-base shrink-0"></i>
            <span><strong>Tips Cetak Bersih:</strong> Jika masih muncul tulisan tanggal/waktu atau URL di pojok atas/bawah kertas, pastikan pada pengaturan cetak browser Anda (Setelan Tambahan / More Settings) opsi <strong>Headers and footers</strong> (Header dan catatan kaki) sudah <strong>tidak dicentang</strong>.</span>
        </div>
    </div>

    <!-- Printable A4 Landscape Sheet -->
    <div class="print-sheet">
        
        <div class="flex items-center justify-between pb-4 border-b-2 border-black mb-6">
            <div class="w-24 shrink-0 flex justify-center">
                <img src="{{ asset('images/tutwurilapor.png') }}" alt="Logo Tut Wuri Handayani" class="w-20 h-auto object-contain">
            </div>
            <div class="flex-1 text-center font-bold text-xl uppercase tracking-wider px-4">
                SD NEGERI 01 DURIAN GADANG<br>
                LAPORAN REKAP NILAI AKADEMIK SISWA
            </div>
            <div class="w-24 shrink-0"></div>
        </div>

        <div class="flex justify-between font-bold text-sm mb-6 px-10">
            <div>Tahun Ajaran : {{ $selectedTa->tahun_ajaran ?? '-' }}</div>
            <div>Semester : {{ ucfirst($selectedTa->semester ?? '-') }}</div>
        </div>

        <!-- Tabel 1: Rekap Nilai Per Kelas -->
        <div class="font-bold text-center mb-2 text-sm uppercase">REKAP NILAI PER KELAS</div>
        <table class="w-full text-sm table-bordered mb-8 border-collapse">
            <thead>
                <tr class="bg-gray-100 text-center font-bold">
                    <th class="w-12">No</th>
                    <th>Kelas</th>
                    <th class="w-36">Jumlah Siswa</th>
                    <th class="w-36">Nilai Rata-rata</th>
                    <th class="w-36">Nilai Tertinggi</th>
                    <th class="w-36">Nilai Terendah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekapKelas as $idx => $rk)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="font-bold pl-4">{{ $rk['nama_kelas'] }}</td>
                        <td class="text-center">{{ $rk['jumlah_siswa'] }}</td>
                        <td class="text-center font-bold">{{ $rk['rata_rata'] }}</td>
                        <td class="text-center">{{ $rk['tertinggi'] }}</td>
                        <td class="text-center">{{ $rk['terendah'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <!-- Tabel 2: Data Kenaikan Kelas -->
            <div>
                <div class="font-bold text-center mb-2 text-sm uppercase">DATA KENAIKAN KELAS</div>
                <table class="w-full text-sm table-bordered border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-center font-bold">
                            <th class="w-10">No</th>
                            <th>Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Naik Kelas</th>
                            <th>Tidak Naik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekapKelas as $idx => $rk)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td class="font-bold pl-2">{{ $rk['nama_kelas'] }}</td>
                                <td class="text-center">{{ $rk['jumlah_siswa'] }}</td>
                                <td class="text-center font-bold">{{ $rk['naik_kelas'] }}</td>
                                <td class="text-center">{{ $rk['tidak_naik'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tabel 3: Peringkat Siswa Terbaik -->
            <div>
                <div class="font-bold text-center mb-2 text-sm uppercase">PERINGKAT SISWA TERBAIK (BERDASARKAN RATA-RATA NILAI)</div>
                <table class="w-full text-sm table-bordered border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-center font-bold">
                            <th class="w-10">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topSiswa as $idx => $ts)
                            <tr>
                                <td class="text-center font-bold">{{ $idx + 1 }}</td>
                                <td class="font-bold uppercase pl-2">{{ $ts['siswa']->nama_siswa ?? '-' }}</td>
                                <td class="text-center">{{ $ts['kelas_nama'] }}</td>
                                <td class="text-center font-bold">{{ $ts['rata_rata'] }}</td>
                            </tr>
                        @empty
                            @for ($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Box Keterangan -->
        <div class="border border-black p-4 mb-8 text-xs rounded">
            <div class="font-bold mb-1 underline">KETERANGAN :</div>
            <ul class="list-disc list-inside space-y-1">
                <li>Nilai Rata-rata dihitung dari rata-rata seluruh mata pelajaran setiap siswa.</li>
                <li>Nilai Tertinggi dan Nilai Terendah merupakan nilai tertinggi dan terendah dari rata-rata nilai siswa pada masing-masing kelas.</li>
                <li>Data kenaikan kelas berdasarkan hasil penilaian akhir semester.</li>
            </ul>
        </div>

        <!-- Tanda Tangan -->
        <div class="flex justify-end text-center text-sm pt-4 pr-12">
            <div>
                Durian Gadang, {{ date('d F Y') }}<br>Kepala Sekolah
                <div class="h-20"></div>
                <span class="font-bold underline">( .................................................... )</span><br>
                NIP. ....................................................
            </div>
        </div>

    </div>

</body>
</html>
