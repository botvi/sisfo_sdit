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
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data SPP Siswa</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <!-- Form Filter -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('spp.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label for="kelas_id" class="form-label">Filter Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-select">
                                        <option value="">Semua Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="nama_siswa" class="form-label">Filter Nama Siswa</label>
                                    <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" 
                                           value="{{ request('nama_siswa') }}" placeholder="Cari nama siswa...">
                                </div>
                                <div class="col-md-3">
                                    <label for="tahun_pelajaran_id" class="form-label">Filter Tahun Pelajaran</label>
                                    <select name="tahun_pelajaran_id" id="tahun_pelajaran_id" class="form-select">
                                        <option value="">Semua Tahun Pelajaran</option>
                                        @foreach($tahunPelajaran as $tp)
                                            <option value="{{ $tp->id }}" {{ request('tahun_pelajaran_id') == $tp->id ? 'selected' : '' }}>
                                                {{ $tp->tahun_pelajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-search"></i> Filter
                                        </button>
                                        <a href="{{ route('spp.index') }}" class="btn btn-secondary">
                                            <i class="bx bx-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Form Filter -->
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <a href="{{ route('spp.create') }}" class="btn btn-primary">Tambah Data</a>
                            <button type="button" class="btn btn-warning" onclick="kirimPesanPengingatan()">
                                <i class="bx bx-message-square-dots"></i> Kirim Pesan Pengingatan
                            </button>
                        </div>
                        @if(request('kelas_id') || request('nama_siswa') || request('tahun_pelajaran_id'))
                            <div class="text-muted">
                                <small>Menampilkan {{ $data->count() }} data dari hasil filter</small>
                            </div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Bulan Bayar</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Tahun Pelajaran</th>
                                    <th>Status Bayar</th>
                                    <th>Aksi</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->siswa->nama_anak }}</td>
                                    <td>{{ $data->siswa->masterKelas ? $data->siswa->masterKelas->kelas : '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_bayar)->format('d-m-Y') }}</td>
                                    <td>{{ $data->bulan_bayar }}</td>
                                    <td>Rp. {{ number_format($data->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td>{{ $data->tahunPelajaran->tahun_pelajaran }}</td>
                                    <td><span class="badge bg-{{ $data->status_bayar == 'lunas' ? 'success' : 'danger' }}">{{ $data->status_bayar }}</span></td>
                                    <td>
                                        @php
                                            $isFirstRecord = $data->where('siswa_id', $data->siswa_id)
                                                ->where('tahun_pelajaran_id', $data->tahun_pelajaran_id)
                                                ->first()->id === $data->id;
                                        @endphp
                                        
                                        @if($isFirstRecord)
                                            <a href="{{ route('spp.kartu-pembayaran', urlencode($data->siswa->nama_anak)) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-info">
                                                <i class="bx bx-card"></i> 
                                                Kartu Pembayaran
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('spp.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('spp.destroy', $data->id) }}" method="POST" style="display:inline;" class="delete-form">
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
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Bulan Bayar</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Tahun Pelajaran</th>
                                    <th>Status Bayar</th>
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

        // Auto-submit form saat dropdown berubah
        document.getElementById('kelas_id').addEventListener('change', function() {
            document.querySelector('form').submit();
        });
        
        document.getElementById('tahun_pelajaran_id').addEventListener('change', function() {
            document.querySelector('form').submit();
        });
        
        // Debounce untuk input nama siswa
        let timeout;
        document.getElementById('nama_siswa').addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                document.querySelector('form').submit();
            }, 500);
        });

        function kirimPesanPengingatan() {
            Swal.fire({
                title: 'Kirim Pesan Pengingatan?',
                text: "Pesan akan dikirim ke semua orang tua yang anaknya belum membayar SPP bulan kemarin",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Mengirim Pesan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Kirim request
                    fetch('{{ route("spp.kirim-pesan-belum-bayar") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success'
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat mengirim pesan',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengirim pesan',
                            icon: 'error'
                        });
                    });
                }
            });
        }
    </script>
    @endsection