<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Orang Tua dan Siswa</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 20px;
        }
        .header {
            margin-bottom: 20px;
        }
        .kop {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="kop">
        <h4>DATA ORANG TUA DAN SISWA <br>
        SDIT LA TAHZAN GUNUNG TOAR</h4>
    </div>
    <div class="header">
        @if(request('master_kelas_id'))
            <p>Kelas: {{ $kelas->where('id', request('master_kelas_id'))->first()->kelas }}</p>
            <p>Wali Kelas: {{ $siswa->first()->masterKelas->waliKelas->nama_wali_kelas }}</p>
            <p>Tahun: {{ date('Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Nisn</th>
                <th>Nik</th>
                <th>Nama Orang Tua/Wali</th>
                <th>Alamat Orang Tua/Wali</th>
                <th>No HP Orang Tua/Wali</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->nama_anak }}</td>
                    <td>{{ $s->nisn }}</td>
                    <td>{{ $s->nik_anak }}</td>
                    <td>{{ $s->orangTuaWali->nama_ibu ?? $s->orangTuaWali->nama_ayah ?? $s->orangTuaWali->nama_wali }}</td>
                    <td>{{ $s->orangTuaWali->alamat_ortu ?? $s->orangTuaWali->alamat_ayah ?? $s->orangTuaWali->alamat_wali }}</td>
                    <td>{{ $s->orangTuaWali->no_wa_ortu ?? $s->orangTuaWali->no_wa_ayah ?? $s->orangTuaWali->no_wa_wali }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data orang tua dan siswa</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <table>
        <tr>
            <td style="text-align: right; padding-top: 20px;">
                <p>Gunung Toar, {{ date('d-m-Y') }}</p>
                <br><br><br>
                <p>{{ $siswa->first()->masterKelas->waliKelas->nama_wali_kelas }}</p>
            </td>
        </tr>
    </table>

    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()">Print</button>
        <button onclick="window.history.back()">Kembali</button>
    </div>
</body>
</html>
