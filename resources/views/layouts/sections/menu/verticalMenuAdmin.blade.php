<aside id="layout-menu" class="layout-menu menu-vertical menu bg-sky-950 w-[20rem]">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo justify-center">
      <a href="{{ route('dashboard.admin') }}" class="app-brand-link mt-4">
        <span class="app-brand-text demo menu-text fw-semibold ms-2" style="color: #f5f5f5;">Dashboard Admin</span>
      </a>
    </div>
  
    <ul class="menu-inner py-1">
      <li class="menu-item mt-5 ms-4">
        <a href="{{ route('dashboard.admin') }}" class="menu-link">
          <i class=" fa-solid fa-list fa-sm text-2xl mr-10" style="color: #f5f5f5;"></i>
          <span style="color: #f5f5f5;">Daftar Pengajuan</span>
        </a>
      </li>
      <li class="menu-item ms-4">
        <a href="{{ route('barang.admin') }}" class="menu-link">
          <i class="fa-solid fa-boxes-stacked fa-sm text-2xl mr-10" style="color: #f5f5f5;"></i>
          <span style="color: #f5f5f5;">Manage Barang</span>
        </a>
      </li>
    </ul>
  
    <div class="mb-10 ms-4">
      <ul class="menu-inner py-1">
        <li class="menu-item ms-4">
          <form id="logoutForm" class="inline">
            @csrf
            <button type="submit">
                <i class="fa-solid fa-arrow-right-from-bracket text-2xl mr-10" style="color: #f5f5f5;"></i>
                <span style="color: #f5f5f5;">Logout</span>
            </button>
        </form>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#logoutForm').on('submit', function (e) {
                    e.preventDefault();
        
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Anda akan keluar dari aplikasi.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, logout!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('logout.admin') }}',
                                method: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    // Tampilkan SweetAlert sukses logout
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Anda berhasil logout.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Redirect ke halaman login setelah logout
                                        window.location.href = '/login-admin';  // Ganti sesuai dengan URL login Anda
                                    });
                                },
                                error: function () {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat logout.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>
        </li>
      </ul>
    </div>
  </aside>