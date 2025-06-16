<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran SPP</title>
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
        <h4>PEMBAYARAN SPP SISWA <br>
        SDIT LA TAHZAN GUNUNG TOAR <br>
        TAHUN PELAJARAN {{ $sppSiswa->first()->tahunPelajaran->tahun_pelajaran }}</h4>
    </div>
    <div class="header">
        @if(request('master_kelas_id'))
            <p>Kelas: {{ $kelas->where('id', request('master_kelas_id'))->first()->kelas }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Bulan</th>
                <th>Tahun Pelajaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sppSiswa as $index => $spp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $spp->siswa->nama_anak }}</td>
                    <td>{{ $spp->siswa->masterKelas->kelas }}</td>
                    <td>{{ $spp->tanggal_bayar }}</td>
                    <td>{{ $spp->bulan_bayar }}</td>
                    <td>{{ $spp->tahunPelajaran->tahun_pelajaran }}</td>
                    <td>{{ $spp->status_bayar }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data pembayaran SPP</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <table>
        <tr>
            <td style=" padding-top: 20px;">
                <p>Mengetahui, <br> Wali Kelas</p>
                <br><br><br>
                <p>{{ $sppSiswa->first()->siswa->masterKelas->waliKelas->nama_wali_kelas }}</p>
            </td>
            <td style="text-align: right; padding-top: 20px;">
                <p>Bendahara</p>
                <br><br><br>
                <p>{{ $bendahara->nama }}</p>
            </td>
        </tr>
    </table>

    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()">Print</button>
        <button onclick="window.history.back()">Kembali</button>
    </div>
</body>
</html>
