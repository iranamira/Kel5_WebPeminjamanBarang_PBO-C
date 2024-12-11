@extends('layouts.admin')

@section('content')
    <div class="container">
        <button class="btn btn-primary mt-3" id="addBarangBtn">Tambah Barang</button>
        <div class="card mt-4">
            <h5 class="card-header">Daftar Barang</h5>
            <div class="table-responsive text-wrap">
              <table class="table" id="barangTable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Barang</th>
                    <th>Detail</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if($barang && $barang->isNotEmpty())
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($barang as $item)    
                    <tr>
                        <td><span class="fw-medium">{{ $no++ }}</span></td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->jumlah_barang }}</td>
                        <td>{{ $item->detail }}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item editBarangBtn" data-id="{{ $item->barang_id }}"><i class="mdi mdi-pencil-outline me-2"></i> Edit</button>
                                    <button class="dropdown-item deleteBarangBtn" data-id="{{ $item->barang_id }}"><i class="mdi mdi-trash-can-outline me-2"></i> Delete</button>
                                </div>
                            </div>
                        </td>
                      </tr>
                    @endforeach
                      @else
                      <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                  
            </div>
          </div>

    </div>

    <!-- Modal untuk Tambah/Edit Barang -->
        <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="barangModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="barangForm" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" id="barang_id" name="barang_id" value="">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" autofocus required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_barang">Jumlah Barang</label>
                            <input type="number" name="jumlah_barang" id="jumlah_barang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="detail">Detail</label>
                            <textarea name="detail" id="detail" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBarangBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Modal untuk tambah barang
            $('#addBarangBtn').click(function () {
                $('#barangForm')[0].reset();
                $('#barangModalLabel').text('Tambah Barang');
                $('#saveBarangBtn').text('Simpan');
                $('#barangModal').modal('show');
            });

            // Submit form tambah/update barang
            $('#barangForm').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                let url = $('#saveBarangBtn').text() === 'Simpan' ? '/barang' : '/barang/' + $('#barang_id').val();
                let method = $('#saveBarangBtn').text() === 'Simpan' ? 'POST' : 'PUT';

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function (response) {
                if (response.success) {
                    $('#barangModal').modal('hide');
                    // Tampilkan SweetAlert2 sukses
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message || 'Data barang berhasil disimpan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                            }).then(() => {                                
                                $('#barangTable').load(location.href + ' #barangTable');
                            });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan saat menyimpan data.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan pada server.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });

            // Edit barang
            $(document).on('click', '.editBarangBtn', function () {
                let barangId = $(this).data('id');

                $.get('/barang/' + barangId + '/edit', function (response) {
                    $('#barangModalLabel').text('Edit Barang');
                    $('#saveBarangBtn').text('Update');
                    $('#nama_barang').val(response.nama_barang);
                    $('#jumlah_barang').val(response.jumlah_barang);
                    $('#detail').val(response.detail);
                    $('#barang_id').val(response.barang_id);
                    $('#barangModal').modal('show');
                });
            });

            // Delete Barang
            $(document).on('click', '.deleteBarangBtn', function () {
                let barangId = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data barang akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/barang/' + barangId,
                            method: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Berhasil!',
                                        'Barang telah dihapus.',
                                        'success'
                                    );
                                    $('#barang-' + barangId).remove();
                                    $('#barangTable').load(location.href + ' #barangTable');
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Terjadi kesalahan saat menghapus barang.',
                                        'error'
                                    );
                                }
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan pada server.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection