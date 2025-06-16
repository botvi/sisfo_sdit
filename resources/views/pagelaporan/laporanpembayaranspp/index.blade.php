@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Laporan Pembayaran SPP</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laporan.pembayaran.spp') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Filter Kelas</label>
                            <select name="master_kelas_id" class="form-select">
                                <option value="">Semua Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ request('master_kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary d-block">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <a href="{{ route('laporan.pembayaran.spp.print', request()->query()) }}" class="btn btn-success d-block" target="_blank">Print</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Bulan</th>
                                    <th>Tahun Pelajaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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
                                        <td>Rp {{ number_format($spp->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td>
                                            @if($spp->status == 'Lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @else
                                                <span class="badge bg-danger">Belum Lunas</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data pembayaran SPP</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection