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
        <h4>LAPORAN HAFAALAN TAHFIZ <br>
        SDIT LA TAHZAN GUNUNG TOAR</h4>
    </div>
    <div class="header">
        <p>Wali Kelas: {{ $waliKelas->nama_wali_kelas }}</p>
        <p>Kelas: {{ $data->first()->siswa->masterKelas->kelas ?? '-' }}</p>
        <p>Tahun: {{ date('Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Tanggal Hafalan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $h)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $h->siswa->nama_anak ?? '-' }}</td>
                    <td>{{ $h->tanggal_hafalan ?? '-' }}</td>
                    <td>{{ $h->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data hafalan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <table>
        <tr>
            <td style="text-align: right; padding-top: 20px;">
                <p>Gunung Toar, {{ date('d-m-Y') }}</p>
                <br><br><br>
                <p>{{ $waliKelas->nama_wali_kelas }}</p>
            </td>
        </tr>
    </table>

    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()">Print</button>
        <button onclick="window.history.back()">Kembali</button>
    </div>
</body>
</html>
