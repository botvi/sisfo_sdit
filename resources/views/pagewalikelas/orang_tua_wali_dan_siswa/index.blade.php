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
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Orang Tua/Wali dan Siswa</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('orang-tua-wali-dan-siswa.create') }}" class="btn btn-primary">Tambah Data</a>
                        <div class="d-flex gap-2">
                            <button id="btnPindahKelas" class="btn btn-success" style="display: none;">
                                <i class="bx bx-transfer"></i> Pindah Kelas
                            </button>
                           
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>No</th>
                                    <th>Nama Anak</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kelas</th>
                                    <th>NISN</th>
                                    <th>Nama Ibu</th>
                                    <th>NIK Ibu</th>
                                    <th>Nama Ayah</th>
                                    <th>NIK Ayah</th>
                                    <th>Nama Wali</th>
                                    <th>NIK Wali</th>
                                    <th>Alamat Orang Tua</th>
                                    <th>No. WA Orang Tua</th>
                                    <th>Alamat Wali</th>
                                    <th>No. WA Wali</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswa as $index => $data)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input siswa-checkbox" value="{{ $data->id }}">
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->nama_anak }}</td>
                                    <td>{{ $data->jenis_kelamin }}</td>
                                    <td>{{ $data->masterKelas->kelas }}</td>
                                    <td>{{ $data->nisn }}</td>
                                    <td>{{ $data->orangTuaWali->nama_ibu ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->nik_ibu ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->nama_ayah ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->nik_ayah ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->nama_wali ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->nik_wali ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->alamat_ortu ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->no_wa_ortu ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->alamat_wali ?? '-' }}</td>
                                    <td>{{ $data->orangTuaWali->no_wa_wali ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('orang-tua-wali-dan-siswa.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('orang-tua-wali-dan-siswa.destroy', $data->id) }}" method="POST" style="display:inline;" class="delete-form">
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
                                    <th width="50">
                                        <input type="checkbox" id="selectAllFooter" class="form-check-input">
                                    </th>
                                    <th>No</th>
                                    <th>Nama Anak</th>  
                                    <th>Jenis Kelamin</th>
                                    <th>Kelas</th>
                                    <th>NISN</th>
                                    <th>Nama Ibu</th>
                                    <th>NIK Ibu</th>
                                    <th>Nama Ayah</th>
                                    <th>NIK Ayah</th>
                                    <th>Nama Wali</th>
                                    <th>NIK Wali</th>
                                    <th>Alamat Orang Tua</th>
                                    <th>No. WA Orang Tua</th>
                                    <th>Alamat Wali</th>
                                    <th>No. WA Wali</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pindah Kelas -->
    <div class="modal fade" id="modalPindahKelas" tabindex="-1" aria-labelledby="modalPindahKelasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPindahKelasLabel">Pindah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Pindahkan <span id="jumlahSiswaDipilih">0</span> siswa ke kelas:</p>
                    <select id="kelasTujuan" class="form-select">
                        <option value="">Pilih Kelas Tujuan</option>
                        @foreach(\App\Models\MasterKelas::all() as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnKonfirmasiPindah">Pindahkan</button>
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

            // Fungsi untuk checkbox
            const selectAll = document.getElementById('selectAll');
            const selectAllFooter = document.getElementById('selectAllFooter');
            const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox');
            const btnPindahKelas = document.getElementById('btnPindahKelas');
            const btnSelectAll = document.getElementById('btnSelectAll');
            const modalPindahKelas = new bootstrap.Modal(document.getElementById('modalPindahKelas'));
            const jumlahSiswaDipilih = document.getElementById('jumlahSiswaDipilih');
            const btnKonfirmasiPindah = document.getElementById('btnKonfirmasiPindah');

            // Fungsi untuk update tombol pindah kelas
            function updatePindahKelasButton() {
                const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');
                if (checkedBoxes.length > 0) {
                    btnPindahKelas.style.display = 'inline-block';
                    btnPindahKelas.textContent = `Pindah Kelas (${checkedBoxes.length} siswa)`;
                } else {
                    btnPindahKelas.style.display = 'none';
                }
            }

            // Event listener untuk checkbox individual
            siswaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updatePindahKelasButton();
                    
                    // Update select all checkbox
                    const allChecked = document.querySelectorAll('.siswa-checkbox:checked').length === siswaCheckboxes.length;
                    selectAll.checked = allChecked;
                    selectAllFooter.checked = allChecked;
                });
            });

            // Event listener untuk select all
            function handleSelectAll(checkbox) {
                siswaCheckboxes.forEach(cb => {
                    cb.checked = checkbox.checked;
                });
                updatePindahKelasButton();
            }

            selectAll.addEventListener('change', function() {
                handleSelectAll(this);
                selectAllFooter.checked = this.checked;
            });

            selectAllFooter.addEventListener('change', function() {
                handleSelectAll(this);
                selectAll.checked = this.checked;
            });

            // Event listener untuk tombol pindah kelas
            btnPindahKelas.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');
                jumlahSiswaDipilih.textContent = checkedBoxes.length;
                modalPindahKelas.show();
            });

            // Event listener untuk konfirmasi pindah kelas
            btnKonfirmasiPindah.addEventListener('click', function() {
                const kelasTujuan = document.getElementById('kelasTujuan').value;
                const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');
                
                if (!kelasTujuan) {
                    Swal.fire('Error', 'Silakan pilih kelas tujuan', 'error');
                    return;
                }

                const siswaIds = Array.from(checkedBoxes).map(cb => cb.value);

                // Kirim request AJAX
                fetch('{{ route("pindah-kelas-multiple") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        siswa_ids: siswaIds,
                        master_kelas_id: kelasTujuan
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Sukses', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan saat memindahkan siswa', 'error');
                });

                modalPindahKelas.hide();
            });
        });
    </script>
    @endsection