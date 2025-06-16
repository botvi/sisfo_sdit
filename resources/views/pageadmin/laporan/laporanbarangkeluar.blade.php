<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .signature {
            margin-top: 50px;
            float: right;
            text-align: center;
        }
        .signature p {
            margin: 50px 0 5px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PT. Riau Andalan Pulp Paper (RAPP)</h2>
        <p>Alamat: Jl. Raya Km. 12, Kel. Sukahati, Kec. Siak, Riau</p>
        <p>Telepon: (0761) 21212 | Email: info@rapp.com</p>
        <hr style="border: 2px solid #000;">
    </div>

    <h3 style="text-align: center;">LAPORAN BARANG KELUAR</h3>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Keluar</th>
                <th>Tujuan</th>
                <th>DiInput Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang_keluars as $index => $barang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $barang->barang->kode_barang }}</td>
                <td>{{ $barang->barang->nama_barang }}</td>
                <td>{{ $barang->jumlah }}</td>
                <td>{{ \Carbon\Carbon::parse($barang->tanggal_keluar)->format('d/m/Y') }}</td>
                <td>{{ $barang->tujuan }}</td>
                <td>{{ $barang->user->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>Siak, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        <p>Asisten Kiper</p>
        <br><br><br>
        <p>{{ $asisten_kiper->nama }}</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">Cetak Laporan</button>
    </div>
</body>
</html>
