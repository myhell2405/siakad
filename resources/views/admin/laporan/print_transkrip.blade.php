<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transkrip Nilai Akademik - {{ $siswa->nama_siswa ?? $siswa->nama_lengkap }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            line-height: 1.4;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 5px 0 0;
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 10pt;
        }

        .student-info {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .student-info td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .student-info td.label {
            width: 150px;
            font-weight: bold;
        }

        .student-info td.colon {
            width: 10px;
        }

        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
            text-transform: uppercase;
        }

        .semester-title {
            font-weight: bold;
            font-size: 12pt;
            margin: 20px 0 10px 0;
            padding-left: 5px;
            border-left: 4px solid #000;
            text-transform: uppercase;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .grades-table th,
        .grades-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .grades-table th {
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
            font-size: 10pt;
        }

        .grades-table td.center {
            text-align: center;
        }

        .grades-table td.mapel {
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature-date {
            margin-bottom: 60px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            body {
                background: none;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }

            .no-print {
                display: none !important;
            }
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #000;
            color: #fff;
            border: none;
            padding: 15px 25px;
            font-size: 16px;
            font-family: sans-serif;
            font-weight: bold;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.2s;
            z-index: 999;
        }

        .print-btn:hover {
            transform: scale(1.05);
            background: #222;
        }
    </style>
</head>

<body>

    <button class="print-btn no-print" onclick="window.print()">🖨️ CETAK DOKUMEN</button>

    <div class="page">
        <!-- HEADER -->
        <div class="header">
            <h1>PEMERINTAH KABUPATEN MUKOMUKO<br>DINAS PENDIDIKAN DAN KEBUDAYAAN</h1>
            <h2>SD NEGERI 01 DURIAN GADANG</h2>
            <p>Alamat: Jl. Lintas Barat Sumatera, Desa Durian Gadang, Kec. V Koto, Kab. Mukomuko</p>
        </div>

        <div class="title">TRANSKRIP NILAI AKADEMIK</div>

        <!-- IDENTITAS -->
        <table class="student-info">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="colon">:</td>
                <td style="font-weight: bold; text-transform: uppercase;">
                    {{ $siswa->nama_siswa ?? $siswa->nama_lengkap }}</td>
                <td class="label">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td>{{ ($siswa->jenis_kelamin == 'L' || $siswa->jenis_kelamin == 'Laki-laki') ? 'Laki-laki' : 'Perempuan' }}
                </td>
            </tr>
            <tr>
                <td class="label">NIS / NISN</td>
                <td class="colon">:</td>
                <td>{{ $siswa->nis ?: '-' }} / {{ $siswa->nisn ?: '-' }}</td>
                <td class="label">Tempat, Tgl Lahir</td>
                <td class="colon">:</td>
                <td>{{ $siswa->tempat_lahir ?: '-' }},
                    {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '-' }}
                </td>
            </tr>
        </table>

        <!-- REKAP NILAI -->
        @forelse($groupedNilai as $semester => $nilais)
            <div class="semester-title">{{ $semester }}</div>

            <table class="grades-table">
                <thead>
                    <tr>
                        <th style="width: 5%">NO</th>
                        <th style="width: 30%">MATA PELAJARAN</th>
                        <th style="width: 10%">KKM</th>
                        <th style="width: 10%">TUGAS</th>
                        <th style="width: 10%">UTS</th>
                        <th style="width: 10%">UAS</th>
                        <th style="width: 10%">NILAI AKHIR</th>
                        <th style="width: 15%">PREDIKAT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilais as $n)
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td class="mapel">{{ strtoupper($n->mapel->nama_mapel ?? '-') }}</td>
                            <td class="center">{{ $n->mapel->kkm ?? 75 }}</td>
                            <td class="center">{{ $n->nilai_tugas ?? '-' }}</td>
                            <td class="center">{{ $n->nilai_uts ?? '-' }}</td>
                            <td class="center">{{ $n->nilai_uas ?? '-' }}</td>
                            <td class="center" style="font-weight: bold">{{ $n->nilai_akhir ?? '-' }}</td>
                            <td class="center" style="font-weight: bold">
                                @php
                                    $na = $n->nilai_akhir ?? 0;
                                    $predikat = 'D';
                                    if ($na >= 90)
                                        $predikat = 'A';
                                    elseif ($na >= 80)
                                        $predikat = 'B';
                                    elseif ($na >= 70)
                                        $predikat = 'C';
                                @endphp
                                {{ $predikat }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @empty
            <div style="text-align: center; padding: 50px; border: 1px dashed #000;">
                <em>Belum ada rekam nilai akademik untuk siswa ini.</em>
            </div>
        @endforelse

        <!-- FOOTER SIGNATURE -->
        <div class="footer">
            <div class="signature-box">
                <div class="signature-date">Durian Gadang,
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Kepala Sekolah</div>
                <div class="signature-name">Peri Anita, S.Pd</div>
                <div>NIP. 19800101 200501 1 001</div>
            </div>
            <div style="clear: both;"></div>
        </div>

    </div>

    <script>
        window.onload = function () {
            setTimeout(function () {
                window.print();
            }, 500);
        }
    </script>
</body>

</html>