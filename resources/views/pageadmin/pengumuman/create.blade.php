@extends('template-admin.layout')
@section('style')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
@endsection
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
                            <li class="breadcrumb-item active" aria-current="page">Manajemen Pengumuman</li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Pengumuman</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->

            <div class="row">
                <div class="col-xl-7 mx-auto">
                    <hr />
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bx-plus-circle me-1 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">Tambah Pengumuman</h5>
                            </div>
                            <hr>
                            <form action="{{ route('pengumuman.store') }}" method="POST" class="row g-3"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="nama_pengumuman" class="form-label">Nama Pengumuman</label>
                                    <input type="text" class="form-control" id="nama_pengumuman" name="nama_pengumuman"
                                        required>
                                    <small class="text-danger">
                                        @foreach ($errors->get('nama_pengumumun') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="jenis_pengumuman" class="form-label">Jenis Pengumuman</label>
                                    <select class="form-control" id="jenis_pengumuman" name="jenis_pengumuman" required>
                                        <option value="">Pilih Jenis Pengumuman</option>
                                        <option value="pengumuman">Pengumuman</option>
                                        <option value="berita">Berita</option>
                                        <option value="event">Event</option>
                                    </select>
                                    <small class="text-danger">
                                        @foreach ($errors->get('jenis_pengumuman') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="konten_pengumuman" class="form-label">Konten</label>
                                    <textarea id="konten_pengumuman" name="konten_pengumuman"></textarea>
                                    <small class="text-danger">
                                        @foreach ($errors->get('konten_pengumuman') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="gambar_pengumuman" class="form-label">Gambar Pengumuman</label>
                                    <input type="file" class="form-control" id="gambar_pengumuman" name="gambar_pengumuman"
                                        accept="image/*">
                                    <small class="text-danger">
                                        @foreach ($errors->get('gambar_pengumuman') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#konten_pengumuman').summernote({
            tabsize: 2,
            height: 500,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endsection