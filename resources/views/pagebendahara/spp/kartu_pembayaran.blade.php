<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pembayaran {{ $siswa->nama_anak }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #9ad0ff;
            min-height: 100vh;
        }
        .header {
            text-align: center;
            margin-bottom: 6px;
        }
        .header h3 {
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
            background-color: #9ad0ff;
        }
        th {
            background-color: #9ad0ff;
        }
        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            padding: 0 50px;
        }
        .signature {
            text-align: center;
        }
        .signature p {
            margin: 50px 0 5px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                background-color: #9ad0ff;
            }
            th, td {
                background-color: #9ad0ff !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>KARTU PEMBAYARAN</h3>
        <h3>SDIT LA TAHZAN GUNUNG TOAR</h3>
        <h3>TP. {{ $tahunPelajaran->tahun_pelajaran }}</h3>
    </div>

    <div class="header">
     <table style="border: none; width: 50%;">
        <tr>
            <td style="border: none; padding: 2px;">NAMA ANAK</td>
            <td style="border: none; padding: 2px;">:</td>
            <td style="border: none; padding: 2px;">{{ strtoupper($siswa->nama_anak) }}</td>
        </tr>
        <tr>
            <td style="border: none; padding: 2px;">KELAS</td>
            <td style="border: none; padding: 2px;">:</td>
            <td style="border: none; padding: 2px;">{{ strtoupper($siswa->masterKelas->kelas) }}</td>
        </tr>
     </table>
    </div>

    <table class="table w-auto m-0" style="border:1px solid black;">
        <thead>
          <tr>
            <th rowspan="2" class="border border-black">NO</th>
            <th colspan="2" class="border border-black">SPP</th>
            <th colspan="2" class="border border-black">EKSKUL</th>
            <th rowspan="2" class="border border-black">PARAF</th>
          </tr>
          <tr>
            <th class="border border-black">TANGGAL</th>
            <th class="border border-black">BULAN</th>
            <th class="border border-black">TANGGAL</th>
            <th class="border border-black">BULAN</th>
          </tr>
        </thead>
        <tbody>
          @php
            $bulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
            // Buat array untuk mapping data pembayaran
            $pembayaranSpp = $sppData->keyBy('bulan_bayar');
            $pembayaranEkskul = $sppData->keyBy('bulan_bayar');
          @endphp
          
          @foreach($bulan as $index => $nama_bulan)
          <tr>
            <td class="border border-black align-top">{{ $index + 1 }}</td>
            <td class="border border-black">
              @if(isset($pembayaranSpp[$nama_bulan]))
                {{ \Carbon\Carbon::parse($pembayaranSpp[$nama_bulan]->tanggal_bayar)->format('d-m-Y') }}
              @endif
            </td>
            <td class="border border-black">{{ strtoupper($nama_bulan) }}</td>
            <td class="border border-black">
              @if(isset($pembayaranEkskul[$nama_bulan]))
                {{ \Carbon\Carbon::parse($pembayaranEkskul[$nama_bulan]->tanggal_bayar)->format('d-m-Y') }}
              @endif
            </td>
            <td class="border border-black">{{ strtoupper($nama_bulan) }}</td>
            <td class="border border-black"></td>
          </tr>
          @endforeach
        </tbody>
    </table>
    <div class="">
       <p class="text-start" style="font-size: 12px; font-style: italic;">NB : Pembayaran SPP dan Ekskul selambat-lambatnya tanggal 10 setiap bulan</p>
    </div>

    <div class="signature-container">
        <div class="signature">
            <p style="margin-bottom: 0;">MENGETAHUI,</p>
            <p style="margin-top: 0;">KEPALA SEKOLAH</p>
            <br><br><br>
            <p>{{ strtoupper($kepalaSekolah->nama) }}</p>
        </div>
        <div class="signature">
            <p>BENDAHARA</p>
            <br><br><br><br>
            <p>{{ strtoupper($bendahara->nama) }}</p>
        </div>
    </div>

</body>
<script>
    window.print();
</script>
</html>
