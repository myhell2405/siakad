<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Identitas Guru Kelas - {{ $selectedKelas->waliKelas->nama_lengkap ?? '' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 2.5cm;
        }
        body {
            font-family: 'Arial', sans-serif;
            color: #000;
            line-height: 1.8;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100 py-8 px-4 print:bg-white print:py-0 print:px-0">

    <!-- Top Action Bar (Hidden on Print) -->
    <div class="max-w-3xl mx-auto mb-6 bg-white p-4 rounded-xl shadow flex justify-between items-center no-print border">
        <div class="flex items-center gap-3">
            <button onclick="window.close()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-semibold transition-colors">
                <i class="bi bi-arrow-left"></i> Kemabli / Tutup
            </button>
            <span class="text-sm font-medium text-gray-600">Pratinjau Cetak Identitas Guru Kelas</span>
        </div>
        <button onclick="window.print()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold shadow-lg transition-colors flex items-center gap-2">
            <i class="bi bi-printer-fill"></i> Cetak Sekarang (A4)
        </button>
    </div>

    <!-- Printable F4/A4 Sheet -->
    <div class="max-w-3xl mx-auto bg-white p-12 shadow-xl print:shadow-none print:p-0">
        
        <h1 class="text-center font-bold text-xl tracking-wide uppercase mb-12">IDENTITAS GURU KELAS</h1>

        @php
            $g = $selectedKelas->waliKelas;
        @endphp

        <table class="w-full text-base">
            <tbody>
                <tr class="align-top">
                    <td class="w-56 py-2">Nama Lengkap</td>
                    <td class="w-6 py-2">:</td>
                    <td class="py-2 font-bold uppercase">{{ $g->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">NIP</td>
                    <td class="py-2">:</td>
                    <td class="py-2 font-mono">{{ $g->nip ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">NUPTK</td>
                    <td class="py-2">:</td>
                    <td class="py-2 font-mono">{{ $g->nuptk ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Tempat Tgl Lahir</td>
                    <td class="py-2">:</td>
                    <td class="py-2 uppercase">{{ $g->tempat_lahir ?? '-' }}, {{ $g->tanggal_lahir ? \Carbon\Carbon::parse($g->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Pendidikan Terakhir</td>
                    <td class="py-2">:</td>
                    <td class="py-2">{{ $g->pendidikan_terakhir ?? 'S1. PGSD' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Jabatan Guru</td>
                    <td class="py-2">:</td>
                    <td class="py-2">Guru Kelas</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Pangkat / Gol</td>
                    <td class="py-2">:</td>
                    <td class="py-2">{{ $g->pangkat_gol ?? 'Ahli Pertama, IX' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Tugas Mengajar Kls</td>
                    <td class="py-2">:</td>
                    <td class="py-2 font-bold">{{ $selectedKelas->kelas?->nama_kelas ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Nama Sekolah</td>
                    <td class="py-2">:</td>
                    <td class="py-2">UPTD SD Negeri 01 Durian Gadang</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Alamat</td>
                    <td class="py-2">:</td>
                    <td class="py-2">Jorong Beringin, Durian Gadang</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Kenagarian</td>
                    <td class="py-2">:</td>
                    <td class="py-2">Durian Gadang</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Kecamatan</td>
                    <td class="py-2">:</td>
                    <td class="py-2">Akabiluru</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Kab/Kota</td>
                    <td class="py-2">:</td>
                    <td class="py-2">Lima Puluh Kota</td>
                </tr>
                <tr class="align-top">
                    <td class="py-2">Provinsi</td>
                    <td class="py-2">:</td>
                    <td class="py-2">Sumatera Barat</td>
                </tr>
            </tbody>
        </table>

    </div>

</body>
</html>
