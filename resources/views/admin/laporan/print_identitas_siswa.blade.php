<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Identitas Peserta Didik - {{ $data->siswa->nama_siswa ?? '' }}</title>
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
            line-height: 1.6;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
                margin: 0;
            }
            .page-break {
                page-break-after: always;
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
            <span class="text-sm font-medium text-gray-600">Pratinjau Cetak Identitas Peserta Didik</span>
        </div>
        <button onclick="window.print()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold shadow-lg transition-colors flex items-center gap-2">
            <i class="bi bi-printer-fill"></i> Cetak Sekarang (A4)
        </button>
    </div>

    <!-- Printable F4/A4 Sheet -->
    <div class="max-w-3xl mx-auto bg-white p-12 shadow-xl print:shadow-none print:p-0">
        
        <h1 class="text-center font-bold text-xl tracking-wide uppercase mb-10">IDENTITAS PESERTA DIDIK</h1>

        @php
            $s = $data->siswa;
            $waliCollection = $s->waliSiswa;
            $ayah = $waliCollection->first(fn($item) => strtoupper($item->hubungan) == 'AYAH');
            $ibu = $waliCollection->first(fn($item) => strtoupper($item->hubungan) == 'IBU');
            $wali = $waliCollection->first(fn($item) => strtoupper($item->hubungan) == 'WALI');
            $w = $waliCollection->first();
        @endphp

        <table class="w-full text-base">
            <tbody>
                <tr class="align-top">
                    <td class="w-8 py-1.5">1.</td>
                    <td class="w-64 py-1.5">Nama Lengkap Peserta Didik</td>
                    <td class="w-6 py-1.5">:</td>
                    <td class="py-1.5 font-bold uppercase">{{ $s->nama_siswa ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">2.</td>
                    <td class="py-1.5">NISN / Nomor Induk</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5 font-bold">{{ $s->nisn ?? '-' }} / {{ $s->id ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">3.</td>
                    <td class="py-1.5">Tempat, Tanggal Lahir</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">4.</td>
                    <td class="py-1.5">Jenis Kelamin</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : ($s->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">5.</td>
                    <td class="py-1.5">Agama</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $s->agama ?? 'Islam' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">6.</td>
                    <td class="py-1.5">Status dalam Keluarga</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $s->status_keluarga ?? 'Anak Kandung' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">7.</td>
                    <td class="py-1.5">Anak ke</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $s->anak_ke ?? '1' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">8.</td>
                    <td class="py-1.5">Alamat Peserta Didik</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $s->alamat_siswa ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">9.</td>
                    <td class="py-1.5">Nomor Telepon Rumah</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $s->telp_siswa ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">10.</td>
                    <td class="py-1.5">Sekolah Asal</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $s->sekolah_asal ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">11.</td>
                    <td class="py-1.5">Diterima di sekolah ini</td>
                    <td class="py-1.5"></td>
                    <td class="py-1.5"></td>
                </tr>
                <tr class="align-top">
                    <td class="py-1"></td>
                    <td class="py-1 pl-6">Di Kelas</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $data->kelasTahunAjaran?->kelas?->nama_kelas ?? '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1"></td>
                    <td class="py-1 pl-6">Pada Tanggal</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $s->tanggal_diterima ? \Carbon\Carbon::parse($s->tanggal_diterima)->translatedFormat('d F Y') : '15 Juli ' . ($data->kelasTahunAjaran?->tahunAjaran?->tahun_ajaran ?? date('Y')) }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">12.</td>
                    <td class="py-1.5">Nama Orang Tua</td>
                    <td class="py-1.5"></td>
                    <td class="py-1.5"></td>
                </tr>
                <tr class="align-top">
                    <td class="py-1"></td>
                    <td class="py-1 pl-6">a. Ayah</td>
                    <td class="py-1">:</td>
                    <td class="py-1 uppercase">{{ $ayah ? $ayah->nama_wali : ($w ? $w->nama_wali : '-') }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1"></td>
                    <td class="py-1 pl-6">b. Ibu</td>
                    <td class="py-1">:</td>
                    <td class="py-1 uppercase">{{ $ibu ? $ibu->nama_wali : '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">13.</td>
                    <td class="py-1.5">Alamat Orang Tua</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $w ? $w->alamat : ($s->alamat_siswa ?? '-') }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1"></td>
                    <td class="py-1">Nomor Telepon Rumah</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $w ? $w->telepon : ($s->telp_siswa ?? '-') }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">14.</td>
                    <td class="py-1.5">Pekerjaan Orang Tua</td>
                    <td class="py-1.5"></td>
                    <td class="py-1.5"></td>
                </tr>
                <tr class="align-top">
                    <td class="py-1"></td>
                    <td class="py-1 pl-6">a. Ayah</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $ayah ? $ayah->pekerjaan : ($w ? $w->pekerjaan : '-') }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1"></td>
                    <td class="py-1 pl-6">b. Ibu</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $ibu ? $ibu->pekerjaan : 'Rumah Tangga' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">15.</td>
                    <td class="py-1.5">Nama Wali Peserta Didik</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5 uppercase">{{ $wali ? $wali->nama_wali : '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">16.</td>
                    <td class="py-1.5">Alamat Wali Peserta Didik</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $wali ? $wali->alamat : '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1"></td>
                    <td class="py-1">Nomor Telepon Rumah</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $wali ? $wali->telepon : '-' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-1.5">17.</td>
                    <td class="py-1.5">Pekerjaan Wali Peserta Didik</td>
                    <td class="py-1.5">:</td>
                    <td class="py-1.5">{{ $wali ? $wali->pekerjaan : '-' }}</td>
                </tr>
            </tbody>
        </table>

    </div>

</body>
</html>
