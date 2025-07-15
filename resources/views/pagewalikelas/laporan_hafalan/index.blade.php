@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Laporan Hafalan</div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <!-- Form Pencarian -->
                    <form method="GET" action="{{ route('laporan.hafalan') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama siswa ..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bx bx-search"></i> Cari
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('laporan.hafalan') }}" class="btn btn-secondary">
                                            <i class="bx bx-x"></i> Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(request('search'))
                        <div class="alert alert-info">
                            <i class="bx bx-info-circle"></i> 
                            Menampilkan {{ $groupedData->count() }} siswa dengan total {{ $data->count() }} hafalan untuk pencarian "{{ request('search') }}"
                        </div>
                    @else
                        @php
                            $avgHafalan = $groupedData->count() > 0 ? round($data->count() / $groupedData->count(), 1) : 0;
                        @endphp
                        <div class="alert alert-success">
                            <i class="bx bx-info-circle"></i> 
                            Total {{ $groupedData->count() }} siswa dengan {{ $data->count() }} hafalan (rata-rata {{ $avgHafalan }} hafalan per siswa)
                        </div>
                    @endif

                    @if($groupedData->count() > 0)
                        @php
                            $topStudent = $groupedData->map(function($group) {
                                return [
                                    'nama' => $group->first()->siswa->nama_anak,
                                    'count' => $group->count()
                                ];
                            })->sortByDesc('count')->first();
                        @endphp
                        <div class="alert alert-warning">
                            <i class="bx bx-trophy"></i> 
                            <strong>Siswa dengan hafalan terbanyak:</strong> {{ $topStudent['nama'] }} ({{ $topStudent['count'] }} hafalan)
                        </div>
                    @endif

                    <a href="{{ route('laporan.hafalan.print') }}?search={{ request('search') }}" class="btn btn-success btn d-inline-block mb-3" style="width: auto; padding: 2px 12px; font-size: 0.85rem;">Print Semua</a>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                                                            <th>Jumlah Hafalan</th>
                                        <th>Tanggal Terakhir</th>
                                        <th>Keterangan & Progress</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupedData = $data->groupBy('siswa_id');
                                    $no = 1;
                                @endphp
                                @forelse($groupedData as $siswaId => $hafalanGroup)
                                    @php
                                        $siswa = $hafalanGroup->first()->siswa;
                                        $jumlahHafalan = $hafalanGroup->count();
                                        $hafalanTerakhir = $hafalanGroup->sortByDesc('tanggal_hafalan')->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $siswa->nama_anak }}</td>
                                        <td>
                                            @php
                                                $progressColor = $jumlahHafalan >= 10 ? 'success' : ($jumlahHafalan >= 5 ? 'info' : ($jumlahHafalan >= 3 ? 'warning' : 'danger'));
                                            @endphp
                                            <span class="badge bg-{{ $progressColor }}">{{ $jumlahHafalan }}</span>
                                        </td>
                                        <td>{{ $hafalanTerakhir->tanggal_hafalan }}</td>
                                        <td>
                                            {{ $hafalanTerakhir->keterangan }}
                                            @if($jumlahHafalan > 1)
                                                <br><small class="text-muted">+{{ $jumlahHafalan - 1 }} hafalan lainnya</small>
                                            @endif
                                            @php
                                                $progress = $jumlahHafalan >= 10 ? 'Sangat Baik' : ($jumlahHafalan >= 5 ? 'Baik' : ($jumlahHafalan >= 3 ? 'Cukup' : 'Perlu Ditingkatkan'));
                                                $progressColor = $jumlahHafalan >= 10 ? 'text-success' : ($jumlahHafalan >= 5 ? 'text-info' : ($jumlahHafalan >= 3 ? 'text-warning' : 'text-danger'));
                                            @endphp
                                            <br><small class="{{ $progressColor }}"><strong>{{ $progress }}</strong></small>
                                        </td>
                                        <td>
                                            <a href="{{ route('laporan.hafalan.print.per.siswa', $siswaId) }}" class="btn btn-sm btn-info">
                                                <i class="bx bx-printer"></i> Print
                                            </a>
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $siswaId }}">
                                                <i class="bx bx-show"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data hafalan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Hafalan -->
    @foreach($groupedData as $siswaId => $hafalanGroup)
        @php
            $siswa = $hafalanGroup->first()->siswa;
            $hafalanSorted = $hafalanGroup->sortBy('tanggal_hafalan');
        @endphp
        <div class="modal fade" id="detailModal{{ $siswaId }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $siswaId }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $siswaId }}">Detail Hafalan - {{ $siswa->nama_anak }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nama:</strong> {{ $siswa->nama_anak }}<br>
                                <strong>Total Hafalan:</strong> {{ $hafalanGroup->count() }} kali
                            </div>
                            <div class="col-md-6">
                                <strong>Tanggal Pertama:</strong> {{ $hafalanSorted->first()->tanggal_hafalan }}<br>
                                <strong>Tanggal Terakhir:</strong> {{ $hafalanSorted->last()->tanggal_hafalan }}
                                @php
                                    $totalDays = max(1, (strtotime($hafalanSorted->last()->tanggal_hafalan) - strtotime($hafalanSorted->first()->tanggal_hafalan)) / (24 * 60 * 60));
                                    $frequency = $totalDays > 0 ? round($totalDays / $hafalanGroup->count(), 1) : 0;
                                @endphp
                                <br><strong>Frekuensi:</strong> {{ $frequency }} hari sekali
                                @if($hafalanGroup->count() > 1)
                                    @php
                                        $progress = $hafalanGroup->count() >= 10 ? 'Sangat Baik' : ($hafalanGroup->count() >= 5 ? 'Baik' : ($hafalanGroup->count() >= 3 ? 'Cukup' : 'Perlu Ditingkatkan'));
                                        $progressColor = $hafalanGroup->count() >= 10 ? '#28a745' : ($hafalanGroup->count() >= 5 ? '#17a2b8' : ($hafalanGroup->count() >= 3 ? '#ffc107' : '#dc3545'));
                                    @endphp
                                    <br><strong>Progress:</strong> <span style="color: {{ $progressColor }}; font-weight: bold;">{{ $progress }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
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
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('laporan.hafalan.print.per.siswa', $siswaId) }}" class="btn btn-info">
                            <i class="bx bx-printer"></i> Print Laporan
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection