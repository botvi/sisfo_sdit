<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hafalan Tahfiz - {{ $siswa->nama_anak }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
        }
        
        .kop {
            margin-bottom: 15px;
        }
        
        .kop h3 {
            color: #28a745;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .kop h4 {
            color: #666;
            font-size: 18px;
            font-weight: normal;
        }
        
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        
        .info-item {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 5px;
            min-width: 200px;
            text-align: center;
        }
        
        .info-item h5 {
            font-size: 14px;
            margin-bottom: 5px;
            opacity: 0.9;
        }
        
        .info-item p {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }
        
        .student-info {
            background: linear-gradient(135deg, #e9ecef, #f8f9fa);
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 10px;
            border-left: 5px solid #28a745;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .student-info h5 {
            color: #28a745;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 5px;
        }
        
        .student-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .detail-item {
            background: white;
            padding: 12px 15px;
            border-radius: 6px;
            border-left: 3px solid #28a745;
        }
        
        .detail-item strong {
            color: #28a745;
            display: block;
            margin-bottom: 5px;
        }
        
        .summary {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 10px;
            border-left: 5px solid #17a2b8;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .summary h5 {
            color: #17a2b8;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #17a2b8;
            padding-bottom: 5px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }
        
        .summary-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .summary-item strong {
            display: block;
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .summary-item span {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        
        .progress-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        th {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tr:hover {
            background-color: #e9ecef;
        }
        
        .text-center {
            text-align: center;
        }
        
        .signature-section {
            margin-top: 40px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            padding: 20px;
            border-top: 2px solid #28a745;
            min-width: 200px;
        }
        
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #333;
            width: 200px;
            display: inline-block;
        }
        
        .no-print {
            margin-top: 30px;
            text-align: center;
        }
        
        .btn {
            padding: 12px 25px;
            margin: 0 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .container {
                box-shadow: none;
                padding: 20px;
            }
            
            .no-print {
                display: none;
            }
            
            .btn {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .info-section {
                flex-direction: column;
            }
            
            .student-details {
                grid-template-columns: 1fr;
            }
            
            .summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="kop">
                <h3>LAPORAN HAFAALAN TAHFIZ</h3>
                <h4>SDIT LA TAHZAN GUNUNG TOAR</h4>
            </div>
        </div>
        
        <div class="info-section">
            <div class="info-item">
                <h5>Wali Kelas</h5>
                <p>{{ $waliKelas->nama_wali_kelas }}</p>
            </div>
            <div class="info-item">
                <h5>Kelas</h5>
                <p>{{ $siswa->masterKelas->kelas ?? '-' }}</p>
            </div>
            <div class="info-item">
                <h5>Tahun Ajaran</h5>
                <p>{{ date('Y') }}</p>
            </div>
        </div>

        <div class="student-info">
            <h5>📋 Data Siswa</h5>
            <div class="student-details">
                <div class="detail-item">
                    <strong>Nama Lengkap</strong>
                    {{ $siswa->nama_anak }}
                </div>
                <div class="detail-item">
                    <strong>Nomor Induk Siswa Nasional</strong>
                    {{ $siswa->nisn ?? '-' }}
                </div>
                <div class="detail-item">
                    <strong>Kelas</strong>
                    {{ $siswa->masterKelas->kelas ?? '-' }}
                </div>
            </div>
        </div>

        <div class="summary">
            <h5>📊 Ringkasan Hafalan</h5>
            <div class="summary-grid">
                <div class="summary-item">
                    <strong>Total Hafalan</strong>
                    <span>{{ $hafalanData->count() }} kali</span>
                </div>
                <div class="summary-item">
                    <strong>Tanggal Pertama</strong>
                    <span>{{ $hafalanData->min('tanggal_hafalan') ?? '-' }}</span>
                </div>
                <div class="summary-item">
                    <strong>Tanggal Terakhir</strong>
                    <span>{{ $hafalanData->max('tanggal_hafalan') ?? '-' }}</span>
                </div>
                <div class="summary-item">
                    <strong>Rata-rata per Bulan</strong>
                    <span>{{ round($hafalanData->count() / max(1, ceil((strtotime($hafalanData->max('tanggal_hafalan')) - strtotime($hafalanData->min('tanggal_hafalan'))) / (30 * 24 * 60 * 60))), 1) }} hafalan</span>
                </div>
                @php
                    $totalDays = max(1, (strtotime($hafalanData->max('tanggal_hafalan')) - strtotime($hafalanData->min('tanggal_hafalan'))) / (24 * 60 * 60));
                    $frequency = $totalDays > 0 ? round($totalDays / $hafalanData->count(), 1) : 0;
                @endphp
                <div class="summary-item">
                    <strong>Frekuensi Hafalan</strong>
                    <span>{{ $frequency }} hari sekali</span>
                </div>
                @if($hafalanData->count() > 1)
                    @php
                        $progress = $hafalanData->count() >= 10 ? 'Sangat Baik' : ($hafalanData->count() >= 5 ? 'Baik' : ($hafalanData->count() >= 3 ? 'Cukup' : 'Perlu Ditingkatkan'));
                        $progressColor = $hafalanData->count() >= 10 ? '#28a745' : ($hafalanData->count() >= 5 ? '#17a2b8' : ($hafalanData->count() >= 3 ? '#ffc107' : '#dc3545'));
                    @endphp
                    <div class="summary-item">
                        <strong>Progress</strong>
                        <span class="progress-badge" style="background-color: {{ $progressColor }}; color: white;">{{ $progress }}</span>
                    </div>
                @endif
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Hafalan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hafalanData as $index => $hafalan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $hafalan->tanggal_hafalan }}</td>
                        <td>{{ $hafalan->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data hafalan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <p>Gunung Toar, {{ date('d-m-Y') }}</p>
                <div class="signature-line"></div>
                <p style="margin-top: 10px; font-weight: bold;">{{ $waliKelas->nama_wali_kelas }}</p>
                <p style="font-size: 12px; color: #666;">Wali Kelas</p>
            </div>
        </div>

        <div class="no-print">
            <button class="btn btn-primary" onclick="window.print()">🖨️ Cetak Laporan</button>
            <button class="btn btn-secondary" onclick="window.history.back()">⬅️ Kembali</button>
        </div>
    </div>
</body>
</html> 