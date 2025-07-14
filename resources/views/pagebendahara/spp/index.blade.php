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
            
            <!-- Modal Pilih Bulan dan Tahun Pelajaran -->
            <div class="modal fade" id="modalPilihBulanTahun" tabindex="-1" aria-labelledby="modalPilihBulanTahunLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPilihBulanTahunLabel">Pilih Bulan dan Tahun Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning" role="alert">
                                <strong>Perhatian!</strong> Form ini digunakan untuk mengirim notifikasi kepada orang tua/wali siswa yang <b>belum membayar SPP</b> pada bulan dan tahun pelajaran yang dipilih.
                            </div>
                            <form id="formPilihBulanTahun">
                                <div class="mb-3">
                                    <label for="bulan_pilih" class="form-label">Bulan</label>
                                    <select class="form-select" id="bulan_pilih" name="bulan" required>
                                        <option value="">Pilih Bulan</option>
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
                                </div>
                                <div class="mb-3">
                                    <label for="tahun_pelajaran_pilih" class="form-label">Tahun Pelajaran</label>
                                    <select class="form-select" id="tahun_pelajaran_pilih" name="tahun_pelajaran_id" required>
                                        <option value="">Pilih Tahun Pelajaran</option>
                                        @foreach($tahunPelajaran as $tp)
                                            <option value="{{ $tp->id }}">{{ $tp->tahun_pelajaran }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-warning" onclick="kirimPesanPengingatan()">
                                <i class="bx bx-message-square-dots"></i> Kirim Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <!-- Form Filter -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('spp.index') }}" class="row g-3" id="filterForm">
                                <div class="col-md-2">
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
                                <div class="col-md-2">
                                    <label for="nama_siswa" class="form-label">Filter Nama Siswa</label>
                                    <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" 
                                           value="{{ request('nama_siswa') }}" placeholder="Cari nama siswa...">
                                </div>
                                <div class="col-md-2">
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
                              
                                <div class="col-md-2">
                                    <label for="bulan_bayar" class="form-label">Filter Bulan</label>
                                    <select name="bulan_bayar" id="bulan_bayar" class="form-select">
                                        <option value="">Semua Bulan</option>
                                        @foreach($bulanList as $bulan)
                                            <option value="{{ $bulan }}" {{ request('bulan_bayar') == $bulan ? 'selected' : '' }}>
                                                {{ $bulan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
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
                    
                    <!-- Tampilkan Filter Aktif -->
                    @if(request('kelas_id') || request('nama_siswa') || request('tahun_pelajaran_id') || request('status_bayar') || request('bulan_bayar') || request('tanggal_mulai') || request('tanggal_akhir'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Filter Aktif:</strong>
                            <ul class="mb-0 mt-1">
                                @if(request('kelas_id'))
                                    @php $kelasAktif = $kelas->find(request('kelas_id')); @endphp
                                    <li>Kelas: <strong>{{ $kelasAktif ? $kelasAktif->kelas : 'Tidak ditemukan' }}</strong></li>
                                @endif
                                @if(request('nama_siswa'))
                                    <li>Nama Siswa: <strong>{{ request('nama_siswa') }}</strong></li>
                                @endif
                                @if(request('tahun_pelajaran_id'))
                                    @php $tpAktif = $tahunPelajaran->find(request('tahun_pelajaran_id')); @endphp
                                    <li>Tahun Pelajaran: <strong>{{ $tpAktif ? $tpAktif->tahun_pelajaran : 'Tidak ditemukan' }}</strong></li>
                                @endif
                               
                                @if(request('bulan_bayar'))
                                    <li>Bulan: <strong>{{ request('bulan_bayar') }}</strong></li>
                                @endif
                              
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <a href="{{ route('spp.create') }}" class="btn btn-primary">Tambah Data</a>
                            <button type="button" class="btn btn-warning" onclick="bukaModalPilihBulanTahun()">
                                <i class="bx bx-message-square-dots"></i> Kirim Pesan Pengingatan Belum Bayar
                            </button>
                            {{-- <a href="{{ route('spp.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success">
                                <i class="bx bx-download"></i> Export Excel
                            </a> --}}
                        </div>
                        @if(request('kelas_id') || request('nama_siswa') || request('tahun_pelajaran_id') || request('status_bayar') || request('bulan_bayar') || request('tanggal_mulai') || request('tanggal_akhir'))
                            <div class="text-muted">
                                <small>Menampilkan {{ $data->count() }} data dari {{ $data->total() }} total data (halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }})</small>
                            </div>
                        @else
                            <div class="text-muted">
                                <small>Total {{ $data->total() }} data (halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }})</small>
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
                                        
                                        {{-- <a href="{{ route('spp.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a> --}}
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
            document.getElementById('filterForm').submit();
        });
        
        document.getElementById('tahun_pelajaran_id').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('status_bayar').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('bulan_bayar').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Auto-submit untuk filter tanggal
        document.getElementById('tanggal_mulai').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('tanggal_akhir').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
        
        // Debounce untuk input nama siswa
        let timeout;
        document.getElementById('nama_siswa').addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 800); // Increased delay for better UX
        });

        function bukaModalPilihBulanTahun() {
            // Reset form
            document.getElementById('formPilihBulanTahun').reset();
            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('modalPilihBulanTahun')).show();
        }

        function kirimPesanPengingatan() {
            // Ambil nilai dari form
            const bulan = document.getElementById('bulan_pilih').value;
            const tahunPelajaranId = document.getElementById('tahun_pelajaran_pilih').value;
            
            // Validasi form
            if (!bulan || !tahunPelajaranId) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Silakan pilih bulan dan tahun pelajaran terlebih dahulu',
                    icon: 'warning'
                });
                return;
            }
            
            // Ambil nama bulan dan tahun pelajaran untuk ditampilkan
            const namaBulan = document.getElementById('bulan_pilih').options[document.getElementById('bulan_pilih').selectedIndex].text;
            const namaTahunPelajaran = document.getElementById('tahun_pelajaran_pilih').options[document.getElementById('tahun_pelajaran_pilih').selectedIndex].text;
            
            Swal.fire({
                title: 'Kirim Pesan Pengingatan?',
                text: `Pesan akan dikirim ke semua orang tua yang anaknya belum membayar SPP bulan ${namaBulan} tahun pelajaran ${namaTahunPelajaran}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tutup modal
                    bootstrap.Modal.getInstance(document.getElementById('modalPilihBulanTahun')).hide();
                    
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
                        body: JSON.stringify({
                            bulan: bulan,
                            tahun_pelajaran_id: tahunPelajaranId
                        })
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