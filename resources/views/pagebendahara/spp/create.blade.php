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
                            <li class="breadcrumb-item active" aria-current="page">SPP Siswa</li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah SPP</li>
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
                                <h5 class="mb-0 text-primary">Tambah SPP</h5>
                            </div>
                            <hr>
                            <form action="{{ route('spp.store') }}" method="POST" class="row g-3"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="siswa_id" class="form-label">Nama Siswa</label>
                                    <input type="text" class="form-control" id="search_siswa" placeholder="Cari nama siswa..." autocomplete="off">
                                    <select class="form-control" id="siswa_id" name="siswa_id" required>
                                        <option value="">Pilih Siswa</option>
                                        @foreach ($siswa as $item)
                                            <option value="{{ $item->id }}" data-nama="{{ $item->nama_anak }}">{{ $item->nama_anak }}</option>
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
                                    <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                                    <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar"
                                        required>
                                    <small class="text-danger">
                                        @foreach ($errors->get('tanggal_bayar') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="bulan_bayar" class="form-label">Bulan Bayar</label>
                                    <select class="form-control" id="bulan_bayar" name="bulan_bayar" required>
                                        <option value="">Pilih Bulan Bayar</option>
                                        <option value="Januari">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>
                                    <small class="text-danger">
                                        @foreach ($errors->get('bulan_bayar') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                                    <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar"
                                        required>
                                    <small class="text-danger">
                                        @foreach ($errors->get('jumlah_bayar') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="tahun_pelajaran_id" class="form-label">Tahun Pelajaran</label>
                                    <select class="form-control" id="tahun_pelajaran_id" name="tahun_pelajaran_id" required>
                                        <option value="">Pilih Tahun Pelajaran</option>
                                        @foreach ($tahunPelajaran as $item)
                                            <option value="{{ $item->id }}">{{ $item->tahun_pelajaran }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">
                                        @foreach ($errors->get('tahun_pelajaran_id') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="status_bayar" class="form-label">Status Bayar</label>
                                    <select class="form-control" id="status_bayar" name="status_bayar" required>
                                        <option value="lunas">Lunas</option>
                                    </select>
                                    <small class="text-danger">
                                        @foreach ($errors->get('status_bayar') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Simpan dan Kirim Notifikasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
