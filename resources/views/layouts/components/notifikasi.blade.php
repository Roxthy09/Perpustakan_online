<!-- start notification Dropdown -->
<li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
  <a class="nav-link position-relative" href="javascript:void(0)" id="drop2"
     aria-expanded="false" data-bs-toggle="dropdown">
    <i class="ti ti-bell-ringing"></i>
    <div id="notif-badge" class="notification rounded-circle d-none"></div>
  </a>

  <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
    <div class="d-flex align-items-center justify-content-between py-3 px-7">
      <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
      <span id="notif-count" class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm d-none"></span>
    </div>

    <div id="notif-body" class="message-body" data-simplebar style="max-height: 250px; overflow-y:auto;">
      <div class="text-center text-muted py-3">Memuat notifikasi...</div>
    </div>

    <div class="py-6 px-7 mb-1">
      <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-primary w-100">Lihat Semua</a>
    </div>
  </div>
</li>
<!-- end notification Dropdown -->

<script>
document.addEventListener("DOMContentLoaded", function () {
    function loadNotifications() {
        fetch("{{ route('notifications.index') }}")
            .then(res => res.json())
            .then(data => {
                let unreadCount = data.unreadCount;
                let notifBody   = document.getElementById("notif-body");
                let notifBadge  = document.getElementById("notif-badge");
                let notifCount  = document.getElementById("notif-count");

                // Tampilkan badge
                if (unreadCount > 0) {
                    notifBadge.classList.remove("d-none");
                    notifBadge.classList.add("bg-primary");
                    notifCount.classList.remove("d-none");
                    notifCount.innerText = unreadCount + " new";
                } else {
                    notifBadge.classList.add("d-none");
                    notifCount.classList.add("d-none");
                }

                // Isi daftar notif
                notifBody.innerHTML = "";
                if (data.notifications.length > 0) {
                    data.notifications.forEach(notif => {
                        let title = "";
                        let desc  = "";
                        let url   = "";

                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
                            title = notif.user?.name ?? "-";
                            desc  = "Mengajukan pinjam: " + (notif.buku?.judul ?? "-");
                            url   = `/peminjaman/${notif.id}`; 
                        @else
                            title = "Buku disetujui";
                            desc  = notif.buku?.judul ?? "-";
                             url   = `/user/peminjaman/${notif.id}`; 
                        @endif

                        notifBody.innerHTML += `
                          <a href="${url}" class="d-flex align-items-center px-3 py-2 dropdown-item">
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" style="width:40px;height:40px;">
                              <i class="ti ti-book text-primary"></i>
                            </div>
                            <div class="ms-3">
                              <h6 class="mb-0 fw-semibold">${title}</h6>
                              <span class="fs-2 text-muted">${desc}</span>
                            </div>
                          </a>`;
                    });
                } else {
                    notifBody.innerHTML = `<div class="text-center text-muted py-3">Tidak ada notifikasi</div>`;
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById("notif-body").innerHTML =
                    `<div class="text-center text-danger py-3">Gagal memuat notifikasi</div>`;
            });
    }

    // Load pertama kali
    loadNotifications();

    // Auto-refresh tiap 30 detik
    setInterval(loadNotifications, 30000);
});
</script>
