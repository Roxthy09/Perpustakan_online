<aside class="left-sidebar with-vertical">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
        <img src="{{ asset('admin/assets/images/logos/perpus-logo.png') }}" width="150" alt="Logo-light" />
      </a>
      <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
        <i class="ti ti-x"></i>
      </a>
    </div>

    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">

        {{-- Dashboard --}}
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('dashboard') }}">
            <span><i class="ti ti-aperture"></i></span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        {{-- Admin & Petugas --}}
        @if(in_array(Auth::user()->role, ['admin','petugas']))
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
              <span><i class="ti ti-file-import"></i></span>
              <span class="hide-menu">Pengembalian</span>
            </a>
          </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('denda.index') }}">
                <span><i class="ti ti-file-import"></i></span>
                <span class="hide-menu">Denda</span>
              </a>
            </li>
        @endif

        {{-- User --}}
        @if(Auth::user()->role === 'user')
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
              <span><i class="ti ti-file-import"></i></span>
              <span class="hide-menu">Pengembalian Saya</span>
            </a>
          </li>
           <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('user.denda.index') }}">
              <span><i class="ti ti-file-import"></i></span>
              <span class="hide-menu">Denda Saya</span>
            </a>
          </li>
        @endif

      </ul>
    </nav>

    {{-- Profile + Logout --}}
    <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
      <div class="hstack gap-3">
        <div class="john-img">
          <img src="{{ asset('admin/assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" alt="profile" />
        </div>
        <div class="john-title">
          <h6 class="mb-0 fs-4 fw-semibold">{{ Auth::user()->name }}</h6>
          <span class="fs-2">{{ ucfirst(Auth::user()->role) }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="ms-auto">
          @csrf
          <button type="submit" class="border-0 bg-transparent text-primary" aria-label="logout">
            <i class="ti ti-power fs-6"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</aside>
