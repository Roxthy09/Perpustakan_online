<header class="topbar">
  <div class="with-vertical"><!-- ---------------------------------- -->
    <!-- Start Vertical Layout Header -->
    <!-- ---------------------------------- -->
    <nav class="navbar navbar-expand-lg p-0">
      <ul class="navbar-nav">
        <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2">
          <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item nav-icon-hover-bg rounded-circle d-none d-lg-flex">
          <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="ti ti-search"></i>
          </a>
        </li>
      </ul>

      <ul class="navbar-nav quick-links d-none d-lg-flex align-items-center">
        <!-- ------------------------------- -->

        <!-- ------------------------------- -->

        <li class="nav-item dropdown-hover d-none d-lg-block">
          <a class="nav-link" href="{{route('calendar.index')}}">Calendar</a>
        </li>

      </ul>

      <div class="d-block d-lg-none py-4">
        <a href="./main/index.html" class="text-nowrap logo-img">
          <img src="./assets/images/logos/dark-logo.svg" class="dark-logo" alt="Logo-Dark" />
          <img src="./assets/images/logos/light-logo.svg" class="light-logo" alt="Logo-light" />
        </a>
      </div>
      <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="ti ti-dots fs-7"></i>
      </a>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <div class="d-flex align-items-center justify-content-between">
          <a href="javascript:void(0)" class="nav-link nav-icon-hover-bg rounded-circle mx-0 ms-n1 d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
            <i class="ti ti-align-justified fs-7"></i>
          </a>
          <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
            <!-- ------------------------------- -->
            <!-- start notification Dropdown -->
            @include('layouts.components.notifikasi')
            <!-- end notification Dropdown -->


            <!-- start profile Dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false" data-bs-toggle="dropdown">
                <div class="d-flex align-items-center">
                  <div class="user-profile-img">
                    <img src="{{ asset('admin/assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="35" height="35" alt="profile-img" />
                  </div>
                </div>
              </a>

              <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                <div class="profile-dropdown position-relative" data-simplebar>
                  <div class="py-3 px-7 pb-0">
                    <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                  </div>
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

                  <!-- Tambahkan Menu -->
                  <a href="{{ route('profile.show') }}" class="dropdown-item px-4 py-2">
                    <i class="ti ti-user me-2"></i> Profile
                  </a>
                </div>
              </div>
            </li>
            <!-- end profile Dropdown -->

          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>