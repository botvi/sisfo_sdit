@php
    $url = url()->current();
    $ogImage = $pengumuman->gambar_pengumuman ? asset('pengumuman/' . $pengumuman->gambar_pengumuman) : asset('default-og-image.png');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengumuman->nama_pengumuman }}</title>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $url }}" />
    <meta property="og:title" content="{{ $pengumuman->nama_pengumuman }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($pengumuman->konten_pengumuman), 150) }}" />
    <meta property="og:image" content="{{ $ogImage }}" />
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $pengumuman->nama_pengumuman }}" />
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($pengumuman->konten_pengumuman), 150) }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .letter-container {
            max-width: 750px;
            margin: 48px auto;
            background: #fff;
            border: 2.5px solid #bdbdbd;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 0;
            position: relative;
        }
        .letter-header {
            text-align: center;
            padding: 36px 48px 0 48px;
        }
        .letter-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 12px;
        }
        .letter-logo svg {
            width: 60px;
            height: 60px;
            opacity: 0.7;
        }
        .letter-title {
            font-size: 2.3rem;
            font-weight: bold;
            color: #232946;
            margin-bottom: 0.2em;
            line-height: 1.1;
            letter-spacing: 1px;
        }
        .letter-meta {
            margin: 0 auto 18px auto;
            display: flex;
            justify-content: center;
            gap: 32px;
            color: #444;
            font-size: 1.08rem;
        }
        .letter-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .letter-divider {
            border: none;
            border-top: 2px solid #bdbdbd;
            margin: 18px 0 0 0;
        }
        .letter-image {
            width: 100%;
            max-height: 320px;
            object-fit: cover;
            display: block;
            margin: 0 auto 0 auto;
            border-radius: 0 0 10px 10px;
        }
        .letter-content {
            padding: 36px 48px 36px 48px;
            color: #232946;
            font-size: 1.15rem;
            line-height: 1.8;
            min-height: 180px;
        }
        .letter-footer {
            padding: 0 48px 36px 48px;
            color: #444;
            font-size: 1rem;
            text-align: right;
        }
        .fb-share {
            position: absolute;
            top: 24px;
            right: 24px;
            background: #1877f3;
            color: #fff;
            border-radius: 50%;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(24,119,243,0.10);
            transition: background 0.2s;
            text-decoration: none;
        }
        .fb-share:hover {
            background: #145db2;
        }
        @media (max-width: 900px) {
            .letter-container { max-width: 99vw; }
            .letter-header, .letter-content, .letter-footer { padding-left: 18px; padding-right: 18px; }
            .fb-share { right: 12px; }
        }
        @media (max-width: 600px) {
            .letter-container { border-radius: 0; margin: 0; }
            .letter-header { padding-top: 18px; }
            .letter-title { font-size: 1.3rem; }
            .letter-content { font-size: 1rem; padding: 18px 8px; }
            .letter-image { border-radius: 0; }
            .fb-share { top: 12px; right: 8px; width: 28px; height: 28px; }
        }
    </style>
</head>
<body>
    <div class="letter-container">
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" target="_blank" class="fb-share" title="Bagikan ke Facebook">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.408.595 24 1.326 24H12.82v-9.294H9.692v-3.622h3.127V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.408 24 22.674V1.326C24 .592 23.406 0 22.675 0"/></svg>
        </a>
        <div class="letter-header">
           
            <div class="letter-title">{{ $pengumuman->nama_pengumuman }}</div>
            <div class="letter-meta">
                <span><svg width="16" height="16" fill="#6b7280" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zm0-13H5V6h14v1z"/></svg> {{ $pengumuman->created_at ? $pengumuman->created_at->translatedFormat('d F Y, H:i') : '-' }}</span>
                <span><svg width="16" height="16" fill="#6366f1" viewBox="0 0 24 24"><circle cx="8" cy="8" r="8" fill="#eef2ff"/><circle cx="8" cy="8" r="5" fill="#6366f1"/><rect x="16" y="4" width="6" height="6" rx="1.5" fill="#eef2ff"/><rect x="16" y="4" width="6" height="6" rx="1.5" stroke="#6366f1" stroke-width="1.5" fill="none"/></svg> {{ $pengumuman->jenis_pengumuman }}</span>
            </div>
            <hr class="letter-divider">
        </div>
        @if($pengumuman->gambar_pengumuman)
            <img src="{{ asset('pengumuman/' . $pengumuman->gambar_pengumuman) }}" alt="Gambar Pengumuman" class="letter-image">
        @endif
        <div class="letter-content">
            {!! $pengumuman->konten_pengumuman !!}
        </div>
        <!-- Footer surat, bisa diisi jika ingin tanda tangan atau info tambahan -->
        <!-- <div class="letter-footer">Hormat Kami,<br>Admin Sekolah</div> -->
    </div>
</body>
</html>
