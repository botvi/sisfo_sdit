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
                            <li class="breadcrumb-item active" aria-current="page">Hafalan Tahfiz</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Hafalan Tahfiz</li>
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
                                <div><i class="bx bx-edit me-1 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">Edit Hafalan Tahfiz</h5>
                            </div>
                            <hr>
                            <form action="{{ route('hafalan-tahfiz.update', $hafalan->id) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label for="siswa_id" class="form-label">Nama Siswa</label>
                                    <input type="text" class="form-control" id="search_siswa" placeholder="Cari nama siswa..." autocomplete="off">
                                    <select class="form-control" id="siswa_id" name="siswa_id" required>
                                        <option value="">Pilih Siswa</option>
                                        @foreach ($siswa as $item)
                                            <option value="{{ $item->id }}" data-nama="{{ $item->nama_anak }}" {{ $spp->siswa_id == $item->id ? 'selected' : '' }}>{{ $item->nama_anak }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">
                                        @foreach ($errors->get('siswa_id') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const searchInput = document.getElementById('search_siswa');
                                        const selectElement = document.getElementById('siswa_id');
                                        const options = selectElement.querySelectorAll('option');

                                        searchInput.addEventListener('input', function() {
                                            const searchTerm = this.value.toLowerCase();
                                            
                                            options.forEach(option => {
                                                if (option.value === '') return; // Skip placeholder option
                                                
                                                const namaSiswa = option.getAttribute('data-nama').toLowerCase();
                                                if (namaSiswa.includes(searchTerm)) {
                                                    option.style.display = '';  
                                                } else {
                                                    option.style.display = 'none';
                                                }
                                            });
                                        });

                                        // Reset search when select changes
                                        selectElement.addEventListener('change', function() {
                                            searchInput.value = '';
                                            options.forEach(option => {
                                                option.style.display = '';
                                            });
                                        });
                                    });
                                </script>
                                <div class="col-md-12">
                                    <label for="tanggal_hafalan" class="form-label">Tanggal Hafalan</label>
                                    <input type="date" class="form-control" id="tanggal_hafalan" name="tanggal_hafalan" value="{{ $hafalan->tanggal_hafalan }}" required>
                                    <small class="text-danger">
                                        @foreach ($errors->get('tanggal_hafalan') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea rows="5" class="form-control" id="keterangan" name="keterangan" required>{{ $hafalan->keterangan }}</textarea>
                                    <small class="text-danger">
                                        @foreach ($errors->get('keterangan') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                        
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5"><i class='bx bx-save me-1'></i> Update Hafalan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
