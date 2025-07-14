@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Laporan Hafalan</div>
            </div>

           

            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ route('laporan-admin.hafalan.print') }}" class="btn btn-success d-block mb-3">Print</a>
                        <table class="table table-striped table-bordered">
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
                                        <td>{{ $h->siswa->nama_anak }}</td>
                                        <td>{{ $h->tanggal_hafalan }}</td>
                                        <td>{{ $h->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data hafalan</td>
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