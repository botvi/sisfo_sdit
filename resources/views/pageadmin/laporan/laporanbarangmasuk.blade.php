<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
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
            padding: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .line {
            border-top: 2px solid black;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
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
        <div class="line"></div>
        <h3>LAPORAN BARANG MASUK</h3>
        <p>Periode: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah Masuk</th>
                <th>Tanggal Masuk</th>
                <th>Penanggung Jawab</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang_masuk as $index => $bm)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $bm->barang->kode_barang }}</td>
                <td>{{ $bm->barang->nama_barang }}</td>
                <td>{{ $bm->supplier->nama_supplier }}</td>
                <td>{{ $bm->jumlah }}</td>
                <td>{{ \Carbon\Carbon::parse($bm->tanggal_masuk)->format('d/m/Y') }}</td>
                <td>{{ $bm->user->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Siak, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        <br><br><br>
        <p>{{ $asisten_kiper->nama }}</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Cetak Laporan</button>
    </div>
</body>
</html>
