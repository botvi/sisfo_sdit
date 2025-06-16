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
                <div class="breadcrumb-title pe-3">Pengumuman</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('pengumumun.manage') }}"><i
                                        class="bx bx-arrow-back"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Pengumuman</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-xl-7 mx-auto">
                    <hr />
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-card me-1 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">Tambah Kartu</h5>
                            </div>
                            <hr>
                            <form action="{{ route('buat_game.store_card') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_buat_game" value="{{ $game->id }}">
                                <div class="mb-3">
                                    <label for="judul_kartu" class="form-label">Judul Kartu</label>
                                    <input type="text" class="form-control @error('judul_kartu') is-invalid @enderror"
                                        id="judul_kartu" name="judul_kartu" value="{{ old('judul_kartu') }}" required>
                                    @error('judul_kartu')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="gambar_kartu" class="form-label">Gambar Kartu</label>
                                    <input type="file" class="form-control @error('gambar_kartu') is-invalid @enderror"
                                        id="gambar_kartu" name="gambar_kartu" value="{{ old('gambar_kartu') }}" required>
                                    @error('gambar_kartu')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="konten_kartu" class="form-label">Konten</label>
                                    <textarea id="konten_kartu" name="konten_kartu"></textarea>
                                    @error('konten_kartu')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="quiz" class="form-label">Quiz</label>
                                    <div id="quiz-container">
                                        <!-- Quiz items will be added here -->
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success mt-2" id="add-quiz">Tambah
                                        Quiz</button>
                                    @error('quiz')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
        $('#konten_kartu').summernote({
            placeholder: 'Halo {{ Auth::user()->nama_lengkap }}, silahkan masukkan konten kartu disini',
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
    <script>
        let soalIndex = 0; // Counter untuk soal

        document.getElementById('add-quiz').addEventListener('click', function() {
            const quizContainer = document.getElementById('quiz-container');

            const quizHtml = `
                <div class="quiz-item border rounded p-3 mb-3" data-index="${soalIndex}">
                    <div class="mb-2">
                        <label for="quiz_${soalIndex}_pertanyaan" class="form-label">Pertanyaan</label>
                        <textarea name="quiz[${soalIndex}][pertanyaan]" class="form-control @error('quiz') is-invalid @enderror" required></textarea>
                        @error('quiz')
                                <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Pilihan</label>
                        <input type="text" name="quiz[${soalIndex}][pilihan][a]" class="form-control mb-1 @error('quiz') is-invalid @enderror" placeholder="Pilihan A" required>
                        <input type="text" name="quiz[${soalIndex}][pilihan][b]" class="form-control mb-1 @error('quiz') is-invalid @enderror" placeholder="Pilihan B" required>
                        <input type="text" name="quiz[${soalIndex}][pilihan][c]" class="form-control mb-1 @error('quiz') is-invalid @enderror" placeholder="Pilihan C" required>
                        <input type="text" name="quiz[${soalIndex}][pilihan][d]" class="form-control mb-1 @error('quiz') is-invalid @enderror" placeholder="Pilihan D" required>
                        @error('quiz')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="mb-2">
                            <label for="quiz_${soalIndex}_time_limit" class="form-label">Batas Waktu (detik)</label>
                            <input type="number" name="quiz[${soalIndex}][time_limit]" class="form-control @error('quiz') is-invalid @enderror" min="1" required>
                            @error('quiz')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="quiz_${soalIndex}_jawaban" class="form-label">Jawaban Benar</label>
                        <select name="quiz[${soalIndex}][jawaban]" class="form-control @error('quiz') is-invalid @enderror" required>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                        @error('quiz')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-quiz">Hapus Quiz</button>
                </div>
            `;

            quizContainer.insertAdjacentHTML('beforeend', quizHtml);
            soalIndex++;
        });

        document.getElementById('quiz-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-quiz')) {
                e.target.closest('.quiz-item').remove();
            }
        });
    </script>
@endsection
