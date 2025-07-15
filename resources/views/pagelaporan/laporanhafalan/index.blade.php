@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Laporan Hafalan</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laporan-admin.hafalan') }}" method="GET" class="row g-3">
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
                            <a href="{{ route('laporan-admin.hafalan.print', request()->query()) }}" class="btn btn-success d-block" target="_blank">Print</a>
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
                                    <th>Tanggal Hafalan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $index => $h)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $h->siswa->nama_anak }}</td>
                                        <td>{{ $h->siswa->masterKelas->kelas ?? '-' }}</td>
                                        <td>{{ $h->tanggal_hafalan }}</td>
                                        <td>{{ $h->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data hafalan</td>
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