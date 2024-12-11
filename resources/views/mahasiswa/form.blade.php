@extends('layouts.mahasiswa')

@section('content')
<div class="card mb-4 p-2">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h2 class="mb-0 text-xl">Form Peminjaman Barang</h2>
    </div>
    <div class="card-body">
      <form id="peminjamanForm" action="">
        @csrf
        <div class="form-floating form-floating-outline mb-4">
            <input type="hidden" value="{{ session('user')->getId() }}" name="user_id">
          <input type="text" class="form-control" id="nama_acara" name="nama_acara" placeholder="The Ace" required />
          <label for="nama_acara">Nama Acara</label>
        </div>
        <div class="form-floating form-floating-outline mb-4">
          <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="{{ session('user')->getName() }}" placeholder="Namira Nurfaliani" required disabled />
          <label for="nama_peminjam">Nama Peminjam</label>
        </div>
        <div class="form-floating form-floating-outline mb-4">
          <input type="text" class="form-control" value="{{ session('user')->getNIM() }}" name="NIM" id="nim" placeholder="21120122140103" required disabled />
          <label for="nim">NIM</label>
        </div>
        <div class="form-floating form-floating-outline mb-4">
            <select class="form-select" id="barang" name="barang_id" aria-label="Nama Barang" required>
                @if($barang)
                    @foreach ($barang as $item)
                    <option value="{{ $item->barang_id }}">{{ $item->nama_barang }}</option>
                    @endforeach
                @endif
            </select>
            <label for="barang">Nama Barang</label>
          </div>
          <div class="form-floating form-floating-outline mb-4">
            <input class="form-control" type="number" placeholder="5" id="jumlah" name="jumlah_pinjam" required />
            <label for="jumlah">Jumlah</label>
          </div>
        <div class="form-floating form-floating-outline mb-4">
            <input class="form-control" type="date" id="tanggal_pinjam" name="tanggal_pinjam" required />
            <label for="tanggal_pinjam">Tanggal Peminjaman</label>
          </div>
        <div class="form-floating form-floating-outline mb-4">
            <input class="form-control" type="date" id="tanggal_kembali" name="tanggal_kembali" required />
            <label for="tanggal_kembali">Tanggal Selesai Peminjaman</label>
          </div>
        <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
  $(document).ready(function () {
    // Handle button click for form submission
    $('#peminjamanForm').on('submit', function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah data sudah benar?',
        text: "Pastikan semua informasi yang Anda masukkan sudah benar.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, kirim!',
        cancelButtonText: 'Tidak, batalkan'
      }).then((result) => {
        if (result.isConfirmed) {
          // Collect form data
          let formData = $(this).serialize();

          // Perform AJAX request to submit form data
          $.ajax({
            url: '{{ route('peminjaman.store') }}',
            type: 'POST',
            data: formData,
            success: function (response) {
              if (response.success) {
                Swal.fire({
                  title: 'Sukses!',
                  text: response.message,
                  icon: 'success'
                }).then(() => {
                  window.location.href = '{{ route('list') }}'; // Redirect ke halaman daftar
                });
              } else {
                Swal.fire({
                  title: 'Gagal!',
                  text: response.message,
                  icon: 'error'
                });
              }
            },
            error: function (xhr, status, error) {
              let errorMessage = 'Terjadi kesalahan, silakan coba lagi.';
              if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
              }
              Swal.fire({
                title: 'Terjadi kesalahan!',
                text: errorMessage,
                icon: 'error'
              });
            }
          });
        }
      });
    });
  });
  </script>
@endpush
@endsection
