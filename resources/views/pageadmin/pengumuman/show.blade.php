<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#000" />
    <meta name="description" content="Sistem Informasi SDIT LA TAHZAN - Lihat detail {{ $pengumuman->jenis_pengumuman }} terkini" />
    <meta name="keywords" content="pengumuman, event, berita, sistem informasi" />
    <meta name="author" content="SDIT LA TAHZAN" />
	<link rel="icon" href="{{ asset('env') }}/logo_text.jpg" type="image/jpg"/>
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:title" content="{{ $pengumuman->nama_pengumuman }} - SDIT LA TAHZAN" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($pengumuman->konten_pengumuman), 10) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="SDIT LA TAHZAN" />
    <meta name="twitter:image:src" content="{{ asset('env') }}/logo_text.png" />
    <meta name="twitter:site" content="@SDIT LA TAHZAN" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="Detail {{ $pengumuman->jenis_pengumuman }} - SDIT LA TAHZAN" />
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($pengumuman->konten_pengumuman), 10) }}" />
    
    <title>Detail {{ $pengumuman->jenis_pengumuman }} - SDIT LA TAHZAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .pengumuman-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .pengumuman-container p {
            margin-bottom: 10px;
        }
        .card-title {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow">
                 
                    <div class="card-body">
                        <div class="pengumuman-container">
                            <!-- Kop Surat -->
                            <div class="text-center mb-4">
                                <h4 class="mb-0 fw-bold">{{ strtoupper($pengumuman->jenis_pengumuman) }}</h4>
                            </div>

                            <!-- Garis Pembatas -->
                            <hr class="border border-dark border-1">

                            <!-- Tanggal -->
                            <div class="text-end mb-4">
                                <p>{{ \Carbon\Carbon::parse($pengumuman->created_at)->locale('id')->isoFormat('D MMMM Y') }}</p>
                            </div>

                            <!-- Judul -->
                            <div class="mb-4">
                                <h5 class="text-center fw-bold">{{ $pengumuman->nama_pengumuman }}</h5>
                            </div>

                            <!-- Isi Pengumuman -->
                            <div class="mb-4" style="text-align: justify; line-height: 1.6;">
                                {!! $pengumuman->konten_pengumuman !!}
                            </div>
                            <!-- Tombol Share Facebook -->
                            <div class="mb-4 text-center">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-primary">
                                    <i class="fab fa-facebook"></i> Bagikan ke Facebook
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
