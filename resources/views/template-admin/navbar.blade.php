<ul class="metismenu" id="menu">
    <li class="menu-label">DASHBOARD</li>
    @if(Auth::user()->role == 'admin')
    <li>
        <a href="{{ route('dashboard-admin') }}">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
            <div class="menu-title">DASHBOARD</div>
        </a>
    </li>
    <li>
        <a href="{{ route('profil') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
            <div class="menu-title">PROFIL</div>
        </a>
    </li>
    @elseif(Auth::user()->role == 'bendahara')
    <li>
        <a href="{{ route('dashboard-bendahara') }}">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
            <div class="menu-title">DASHBOARD</div>
        </a>
    </li>
    <li>
        <a href="{{ route('profil') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
            <div class="menu-title">PROFIL</div>
        </a>
    </li>
    @elseif(Auth::user()->role == 'wali_kelas')
    <li>
        <a href="{{ route('dashboard-wali-kelas') }}">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
            <div class="menu-title">DASHBOARD</div>
        </a>
    </li>
    <li>
        <a href="{{ route('profil') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
            <div class="menu-title">PROFIL</div>
        </a>
    </li>

    @elseif(Auth::user()->role == 'kepala_sekolah')
    <li>
        <a href="{{ route('dashboard-kepala-sekolah') }}">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
            <div class="menu-title">DASHBOARD</div>
        </a>
    </li>
    <li>
        <a href="{{ route('profil') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
            <div class="menu-title">PROFIL</div>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'admin')
    <li>
        <a href="{{ route('master-tahun-pelajaran.index') }}">
            <div class="parent-icon"><i class='bx bx-book-alt'></i></div>
            <div class="menu-title">MASTER TAHUN PELAJARAN</div>
        </a>
    </li>
    <li>
        <a href="{{ route('wali-kelas.index') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
            <div class="menu-title">MASTER WALI KELAS</div>
        </a>
    </li>
    <li>
        <a href="{{ route('bendahara.index') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
            <div class="menu-title">MASTER BENDABAHARA</div>
        </a>
    </li>
    <li>
        <a href="{{ route('kepala-sekolah.index') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
            <div class="menu-title">MASTER KEPALA SEKOLAH</div>
        </a>
    </li>
    <li>
        <a href="{{ route('master-kelas.index') }}">
            <div class="parent-icon"><i class='bx bx-book-open'></i></div>
            <div class="menu-title">MASTER KELAS</div>
        </a>
    </li>
    <li>
        <a href="{{ route('whatsapp-api.index') }}">
            <div class="parent-icon"><i class='bx bx-message-square-dots'></i></div>
            <div class="menu-title">WHATSAPP API</div>
        </a>
    </li>
    <li>
        <a href="{{ route('pengumuman.index') }}">
            <div class="parent-icon"><i class='bx bx-message-square-dots'></i></div>
            <div class="menu-title">PENGUMUMAN</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->role == 'wali_kelas')
    <li>
        <a href="{{ route('orang-tua-wali-dan-siswa.index') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
            <div class="menu-title">DATA ORANG TUA/WALI DAN SISWA</div>
        </a>
    </li>
    <li>
        <a href="{{ route('hafalan-tahfiz.index') }}">
            <div class="parent-icon"><i class='bx bx-book-alt'></i></div>
            <div class="menu-title">PROGRESS HAFAALAN TAHFIZ</div>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'bendahara')
    <li>
        <a href="{{ route('spp.index') }}">
            <div class="parent-icon"><i class='bx bx-book-alt'></i></div>
            <div class="menu-title">SPP SISWA</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'kepala_sekolah')
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-book-alt'></i></div>
            <div class="menu-title">LAPORAN</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('laporan.pembayaran.spp') }}">
                    <i class='bx bx-right-arrow-alt'></i>
                    LAPORAN PEMBAYARAN SPP
                </a>
            </li>
            <li>
                <a href="{{ route('laporan.data.orang.tua.dan.siswa') }}">
                    <i class='bx bx-right-arrow-alt'></i>
                    LAPORAN DATA ORANG TUA DAN SISWA
                </a>
            </li>
        </ul>
    </li>
    @endif
 
</ul>
