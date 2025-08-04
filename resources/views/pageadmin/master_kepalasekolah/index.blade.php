    @extends('template-admin.layout')

    @section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Master Data</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kepala Sekolah</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Kepala Sekolah</h6>
            <hr/>
            
            <!-- Informasi Kepala Sekolah Aktif -->
            @if($activeKepalaSekolah)
            <div class="alert alert-success" role="alert">
                <strong>Kepala Sekolah Aktif:</strong> {{ $activeKepalaSekolah->nama_kepala_sekolah }} ({{ $activeKepalaSekolah->nuptk }})
            </div>
            @else
            <div class="alert alert-warning" role="alert">
                <strong>Peringatan:</strong> Tidak ada kepala sekolah yang aktif saat ini.
            </div>
            @endif
            
            <!-- Statistik -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Kepala Sekolah</h5>
                            <h3 class="mb-0">{{ $kepalaSekolah->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Aktif</h5>
                            <h3 class="mb-0">{{ $kepalaSekolah->where('status', 'aktif')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Nonaktif</h5>
                            <h3 class="mb-0">{{ $kepalaSekolah->where('status', 'nonaktif')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                        <a href="{{ route('kepala-sekolah.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kepala Sekolah</th>
                                    <th>NUPTK</th>
                                    <th>NIP</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kepalaSekolah as $index => $kepalaSekolah)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kepalaSekolah->nama_kepala_sekolah }}</td>
                                    <td>{{ $kepalaSekolah->nuptk }}</td>
                                    <td>{{ $kepalaSekolah->nip }}</td>
                                    <td>{{ $kepalaSekolah->user->username }}</td>
                                    <td>{{ $kepalaSekolah->user->email }}</td>
                                    <td>
                                        @if($kepalaSekolah->status === 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kepala-sekolah.edit', $kepalaSekolah->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @if($kepalaSekolah->status !== 'aktif')
                                            <form action="{{ route('kepala-sekolah.activate', $kepalaSekolah->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Aktifkan</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('kepala-sekolah.destroy', $kepalaSekolah->id) }}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kepala Sekolah</th>
                                    <th>NUPTK</th>
                                    <th>NIP</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Konfirmasi untuk menghapus
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Konfirmasi untuk mengaktifkan kepala sekolah
            document.querySelectorAll('form[action*="/activate"]').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Aktifkan Kepala Sekolah?',
                        text: "Kepala sekolah lain akan otomatis dinonaktifkan. Lanjutkan?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, aktifkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @endsection