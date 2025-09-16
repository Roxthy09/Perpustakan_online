<aside class="left-sidebar with-vertical">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
        <img src="{{ asset('admin/assets/images/logos/e-perpus.png') }}" alt="Logo Lengkap" class="logo-full" />
        <img src="{{ asset('admin/assets/images/logos/perpus-icon.png') }}" alt="Logo Ikon" class="logo-icon" />
      </a>
      <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
        <i class="ti ti-x"></i>
      </a>
    </div>

    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Home</span>
        </li>
        {{-- Dashboard --}}
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('dashboard') }}">
            <span><i class="ti ti-aperture"></i></span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        {{-- Admin & Petugas --}}
        @if(in_array(Auth::user()->role, ['admin','petugas']))
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Menu Utama</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('users.index') }}">
            <span><i class="ti ti-user me-2"></i></span>
            <span class="hide-menu">User</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('buku.index') }}">
            <span><i class="ti ti-book-2"></i></span>
            <span class="hide-menu">Buku</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('rak.index') }}">
            <span><i class="ti ti-books"></i></span>
            <span class="hide-menu">Rak</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('kategori_buku.index') }}">
            <span><i class="ti ti-category"></i></span>
            <span class="hide-menu">Kategori Buku</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('peminjaman.index') }}">
            <span><i class="ti ti-file-export"></i></span>
            <span class="hide-menu">Peminjaman</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('pengembalian.index') }}">
            <span><i class="ti ti-refresh"></i></span>
            <span class="hide-menu">Pengembalian</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('denda.index') }}">
            <span><i class="ti ti-cash"></i></span>
            <span class="hide-menu">Denda</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Kontak</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('contact') }}">
            <span><i class="ti ti-cash"></i></span>
            <span class="hide-menu">Email</span>
          </a>
        </li>
        @endif

        {{-- User --}}
        @if(Auth::user()->role === 'user')
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Menu Utama</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('user.buku.index') }}">
            <span><i class="ti ti-book-2"></i></span>
            <span class="hide-menu">Buku</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('user.rak.index') }}">
            <span><i class="ti ti-books"></i></span>
            <span class="hide-menu">Rak</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('user.kategori_buku.index') }}">
            <span><i class="ti ti-category"></i></span>
            <span class="hide-menu">Kategori Buku</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('user.peminjaman.index') }}">
            <span><i class="ti ti-file-export"></i></span>
            <span class="hide-menu">Peminjaman Saya</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('user.pengembalian.index') }}">
            <span><i class="ti ti-refresh"></i></span>
            <span class="hide-menu">Pengembalian Saya</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('user.denda.index') }}">
            <span><i class="ti ti-cash"></i></span>
            <span class="hide-menu">Denda Saya</span>
          </a>
        </li>
        @endif
      </ul>
    </nav>

  </div>
</aside>