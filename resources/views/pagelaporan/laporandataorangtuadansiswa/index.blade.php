@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Laporan Data Orang Tua dan Siswa</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laporan.data.orang.tua.dan.siswa') }}" method="GET" class="row g-3">
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
                            <a href="{{ route('laporan.data.orang.tua.dan.siswa.print', request()->query()) }}" class="btn btn-success d-block" target="_blank">Print</a>
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
                                    <th>Nisn</th>
                                    <th>Nik</th>
                                    <th>Nama Orang Tua/Wali</th>
                                    <th>Alamat Orang Tua/Wali</th>
                                    <th>No HP Orang Tua/Wali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa as $index => $s)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $s->nama_anak }}</td>
                                        <td>{{ $s->nisn }}</td>
                                        <td>{{ $s->nik_anak }}</td>
                                        <td>{{ $s->orangTuaWali->nama_ibu ?? $s->orangTuaWali->nama_ayah ?? $s->orangTuaWali->nama_wali }}</td>
                                        <td>{{ $s->orangTuaWali->alamat_ortu ?? $s->orangTuaWali->alamat_wali }}</td>
                                        <td>{{ $s->orangTuaWali->no_wa_ortu ?? $s->orangTuaWali->no_wa_wali }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data orang tua dan siswa</td>
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