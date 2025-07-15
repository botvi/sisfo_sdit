<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hafalan Tahfiz</title>
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
        .search-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
        }
        .summary {
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #28a745;
        }
        .student-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .student-header {
            background-color: #e9ecef;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .detail-table {
            margin-bottom: 20px;
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
        <p>Kelas: {{ $groupedData->first()->first()->siswa->masterKelas->kelas ?? '-' }}</p>
        <p>Tahun: {{ date('Y') }}</p>
        
        @if(request('search'))
            <div class="search-info">
                <strong>Hasil Pencarian:</strong> "{{ request('search') }}"
            </div>
        @endif
        
        <div class="summary">
            <p><strong>Total Siswa:</strong> {{ $groupedData->count() }} siswa</p>
            <p><strong>Total Hafalan:</strong> {{ $groupedData->flatten()->count() }} hafalan</p>
            @php
                $avgHafalan = $groupedData->count() > 0 ? round($groupedData->flatten()->count() / $groupedData->count(), 1) : 0;
                $topStudent = $groupedData->map(function($group) {
                    return [
                        'nama' => $group->first()->siswa->nama_anak,
                        'count' => $group->count()
                    ];
                })->sortByDesc('count')->first();
            @endphp
            <p><strong>Rata-rata hafalan per siswa:</strong> {{ $avgHafalan }} hafalan</p>
            <p><strong>Siswa dengan hafalan terbanyak:</strong> {{ $topStudent['nama'] }} ({{ $topStudent['count'] }} hafalan)</p>
        </div>
    </div>

    @php $no = 1; @endphp
    @foreach($groupedData as $siswaId => $hafalanGroup)
        @php
            $siswa = $hafalanGroup->first()->siswa;
            $hafalanSorted = $hafalanGroup->sortBy('tanggal_hafalan');
        @endphp
        <div class="student-section">
            <div class="student-header">
                <h5>{{ $no++ }}. {{ $siswa->nama_anak }}</h5>
                <p>Total Hafalan: {{ $hafalanGroup->count() }} kali</p>
                @php
                    $totalDays = max(1, (strtotime($hafalanSorted->last()->tanggal_hafalan) - strtotime($hafalanSorted->first()->tanggal_hafalan)) / (24 * 60 * 60));
                    $frequency = $totalDays > 0 ? round($totalDays / $hafalanGroup->count(), 1) : 0;
                    $progress = $hafalanGroup->count() >= 10 ? 'Sangat Baik' : ($hafalanGroup->count() >= 5 ? 'Baik' : ($hafalanGroup->count() >= 3 ? 'Cukup' : 'Perlu Ditingkatkan'));
                @endphp
                <p>Frekuensi: {{ $frequency }} hari sekali</p>
                <p>Progress: {{ $progress }}</p>
            </div>
            
            <table class="detail-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Hafalan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hafalanSorted as $index => $hafalan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $hafalan->tanggal_hafalan }}</td>
                            <td>{{ $hafalan->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

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
