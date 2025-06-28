@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Forms</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Orang Tua/Wali dan Siswa</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->

            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <hr />
                    <form action="{{ route('orang-tua-wali-dan-siswa.update', $data->id) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Card Data Orang Tua -->
                        <div class="col-xl-6">
                            <div class="card border-top border-0 border-4 border-primary">
                                <div class="card-body p-5">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bx-user me-1 font-22 text-primary"></i></div>
                                        <h5 class="mb-0 text-primary">Data Orang Tua</h5>
                                    </div>
                                    <hr>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                            <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $data->orangTuaWali->nama_ibu) }}" required>
                                            <small class="text-danger">
                                                @foreach ($errors->get('nama_ibu') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nik_ibu" class="form-label">NIK Ibu</label>
                                            <input type="number" class="form-control" id="nik_ibu" name="nik_ibu" minlength="16" maxlength="16" value="{{ old('nik_ibu', $data->orangTuaWali->nik_ibu) }}" required>
                                            <small class="text-danger">
                                                @foreach ($errors->get('nik_ibu') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                            <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $data->orangTuaWali->nama_ayah) }}" required>
                                            <small class="text-danger">
                                                @foreach ($errors->get('nama_ayah') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nik_ayah" class="form-label">NIK Ayah</label>
                                            <input type="number" class="form-control" id="nik_ayah" name="nik_ayah" minlength="16" maxlength="16" value="{{ old('nik_ayah', $data->orangTuaWali->nik_ayah) }}" required>
                                            <small class="text-danger">
                                                @foreach ($errors->get('nik_ayah') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <label for="alamat_ortu" class="form-label">Alamat Orang Tua</label>
                                            <textarea class="form-control" id="alamat_ortu" name="alamat_ortu" rows="3" required>{{ old('alamat_ortu', $data->orangTuaWali->alamat_ortu) }}</textarea>
                                            <small class="text-danger">
                                                @foreach ($errors->get('alamat_ortu') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <label for="no_wa_ortu" class="form-label">No. WhatsApp Orang Tua</label>
                                            <input type="number" minlength="10" maxlength="13" class="form-control" id="no_wa_ortu" name="no_wa_ortu" value="{{ old('no_wa_ortu', $data->orangTuaWali->no_wa_ortu) }}" required>
                                            <small class="text-danger">
                                                @foreach ($errors->get('no_wa_ortu') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Data Wali -->
                        <div class="col-xl-6">
                            <div class="card border-top border-0 border-4 border-info">
                                <div class="card-body p-5">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bx-user-plus me-1 font-22 text-info"></i></div>
                                        <h5 class="mb-0 text-info">Data Wali (Opsional)</h5>
                                    </div>
                                    <hr>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nama_wali" class="form-label">Nama Wali</label>
                                            <input type="text" class="form-control" id="nama_wali" name="nama_wali" value="{{ old('nama_wali', $data->orangTuaWali->nama_wali) }}">
                                            <small class="text-danger">
                                                @foreach ($errors->get('nama_wali') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nik_wali" class="form-label">NIK Wali</label>
                                            <input type="number" minlength="16" maxlength="16" class="form-control" id="nik_wali" name="nik_wali" value="{{ old('nik_wali', $data->orangTuaWali->nik_wali) }}">
                                            <small class="text-danger">
                                                @foreach ($errors->get('nik_wali') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <label for="alamat_wali" class="form-label">Alamat Wali</label>
                                            <textarea class="form-control" id="alamat_wali" name="alamat_wali" rows="3">{{ old('alamat_wali', $data->orangTuaWali->alamat_wali) }}</textarea>
                                            <small class="text-danger">
                                                @foreach ($errors->get('alamat_wali') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <label for="no_wa_wali" class="form-label">No. WhatsApp Wali</label>    
                                            <input type="number" minlength="10" maxlength="13" class="form-control" id="no_wa_wali" name="no_wa_wali" value="{{ old('no_wa_wali', $data->orangTuaWali->no_wa_wali) }}">
                                            <small class="text-danger">
                                                @foreach ($errors->get('no_wa_wali') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Data Siswa -->
                        <div class="col-xl-12">
                            <div class="card border-top border-0 border-4 border-success">
                                <div class="card-body p-5">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bx-user-pin me-1 font-22 text-success"></i></div>
                                        <h5 class="mb-0 text-success">Data Siswa</h5>
                                    </div>
                                    <hr>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nama_anak" class="form-label">Nama Siswa</label>
                                            <input type="text" class="form-control" id="nama_anak" name="nama_anak" value="{{ old('nama_anak', $data->nama_anak) }}" required>
                                            <small class="text-danger">
                                                @foreach ($errors->get('nama_anak') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            <small class="text-danger">
                                                @foreach ($errors->get('jenis_kelamin') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="master_kelas_id" class="form-label">Kelas</label>
                                            <select class="form-select" id="master_kelas_id" name="master_kelas_id" required>
                                                <option value="">Pilih Kelas</option>
                                                @foreach($masterKelas as $kelas)
                                                    <option value="{{ $kelas->id }}" {{ old('master_kelas_id', $data->master_kelas_id) == $kelas->id ? 'selected' : '' }}>Kelas {{ $kelas->kelas }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger">
                                                @foreach ($errors->get('master_kelas_id') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nisn" class="form-label">NISN</label>
                                            <input type="number" minlength="10" maxlength="10" class="form-control" id="nisn" name="nisn" value="{{ old('nisn', $data->nisn) }}" required>
                                            <small class="text-danger">
                                                @foreach ($errors->get('nisn') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
