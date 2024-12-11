@extends('layouts.admin')

@section('content')
<h1 class="py-3 mb-2 text-2xl">Daftar Pengajuan</h1>

<div class="card">
  <h5 class="card-header"></h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Acara</th>
          <th>Nama Peminjam</th>
          <th>NIM</th>
          <th>Barang</th>
          <th>Tgl Peminjaman</th>
          <th>Tgl Pengembalian</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @if($peminjaman && $peminjaman->isNotEmpty())
        @php $no = 1; @endphp
        @foreach ($peminjaman as $item)    
        <tr>
          <td><span class="fw-medium">{{ $no++ }}</span></td>
          <td>{{ $item->nama_acara }}</td>
          <td>{{ $item->mahasiswa->nama }}</td>
          <td>{{ $item->mahasiswa->NIM }}</td>
          <td>{{ $item->barang->nama_barang }}</td>
          <td>{{ $item->tanggal_pinjam }}</td>
          <td>{{ $item->tanggal_kembali }}</td>
          <td>
            <select 
                class="badge rounded-pill px-1 form-control status-dropdown
                {{ $item->status == 'pending' ? 'bg-label-warning' : '' }}
                {{ $item->status == 'approved' ? 'bg-label-success' : '' }}
                {{ $item->status == 'rejected' ? 'bg-label-danger' : '' }}" 
                data-id="{{ $item->id }}" data-prev-value="{{ $item->status }}"
                style="cursor: pointer;">
              <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="approved" {{ $item->status == 'approved' ? 'selected' : '' }}>Approved</option>
              <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
          </td>
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="8" class="text-center">Belum ada peminjaman.</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function () {
    // Event listener untuk perubahan status
    $(document).on('change', '.status-dropdown', function () {
      var status = $(this).val();
      var peminjamanId = $(this).data('id');
      var prevValue = $(this).data('prev-value'); // Ambil nilai sebelumnya

      // Konfirmasi berdasarkan status
      var title = '';
      if (status === 'approved') {
        title = 'Yakin ingin menyetujui peminjaman ini?';
      } else if (status === 'rejected') {
        title = 'Yakin ingin menolak peminjaman ini?';
      } else {
        title = 'Apakah Anda ingin mengubah status ke Pending?';
      }

      Swal.fire({
        title: title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          // Kirim AJAX ke server
          $.ajax({
            url: '{{ route('peminjaman.updateStatus') }}',
            method: 'POST',
            data: {
              _token: $('meta[name="csrf-token"]').attr('content'),
              id: peminjamanId,
              status: status
            },
            success: function (response) {
              if (response.success) {
                Swal.fire({
                  title: 'Berhasil!',
                  text: response.message,
                  icon: 'success',
                });
                // Simpan status baru sebagai nilai sebelumnya
                $(`.status-dropdown[data-id="${peminjamanId}"]`).data('prev-value', status);

                // Ubah kelas bg-label berdasarkan status baru
                var dropdown = $(`.status-dropdown[data-id="${peminjamanId}"]`);
                dropdown.removeClass('bg-label-warning bg-label-success bg-label-danger'); // Hapus semua kelas
                if (status === 'pending') {
                  dropdown.addClass('bg-label-warning');
                } else if (status === 'approved') {
                  dropdown.addClass('bg-label-success');
                } else if (status === 'rejected') {
                  dropdown.addClass('bg-label-danger');
                }
              } else {
                Swal.fire({
                  title: 'Gagal!',
                  text: response.message,
                  icon: 'error',
                });
                // Kembalikan ke nilai sebelumnya jika gagal
                $(`.status-dropdown[data-id="${peminjamanId}"]`).val(prevValue);
              }
            },
            error: function (xhr) {
              var errorMessage = 'Terjadi kesalahan. Coba lagi nanti.';
              if (xhr.responseJSON && xhr.responseJSON.message) {
                  errorMessage = xhr.responseJSON.message;
              }
              Swal.fire({
                  title: 'Error!',
                  text: errorMessage,
                  icon: 'error',
              });
              // Kembalikan dropdown ke nilai sebelumnya jika error
              $(`.status-dropdown[data-id="${peminjamanId}"]`).val(prevValue);
          }
          });
        } else {
          // Kembalikan dropdown ke nilai sebelumnya jika dibatalkan
          $(this).val(prevValue);
        }
      });
    });
  });
</script>


@endsection
