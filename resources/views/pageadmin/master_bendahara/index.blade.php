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
                            <li class="breadcrumb-item active" aria-current="page">Bendahara</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
                <h6 class="mb-0 text-uppercase">Data Bendahara</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                        <a href="{{ route('bendahara.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bendahara</th>
                                    <th>NUPTK</th>
                                    <th>NIP</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bendahara as $index => $bendahara)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bendahara->nama_bendahara }}</td>
                                    <td>{{ $bendahara->nuptk }}</td>
                                    <td>{{ $bendahara->nip }}</td>
                                    <td>{{ $bendahara->user->username }}</td>
                                    <td>{{ $bendahara->user->email }}</td>
                                    <td>
                                        <a href="{{ route('bendahara.edit', $bendahara->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('bendahara.destroy', $bendahara->id) }}" method="POST" style="display:inline;" class="delete-form">
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
                                    <th>Nama Bendahara</th>
                                    <th>NUPTK</th>
                                    <th>NIP</th>
                                    <th>Username</th>
                                    <th>Email</th>
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
        });
    </script>
    @endsection