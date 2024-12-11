@extends('layouts.mahasiswa')

@section('content')
<h1 class="py-3 mb-2 text-2xl">Form Tersubmit
</h1>

<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header"></h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Acara</th>
          <th>Barang</th>
          <th>Tgl Peminjaman</th>
          <th>Tgl Pengembalian</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @if($peminjaman && $peminjaman->isNotEmpty())
        @php
            $no = 1;
        @endphp
        @foreach ($peminjaman as $item)    
        <tr>
          <td><span class="fw-medium">{{ $no++ }}</span></td>
          <td>{{ $item->nama_acara }}</td>
          <td>{{ $item->barang->nama_barang }}</td>
          <td>{{ $item->tanggal_pinjam }}</td>
          <td>{{ $item->tanggal_kembali }}</td>
          <td>
            <span class="badge rounded-pill px-2 py-1
            {{ $item->status == 'pending' ? 'bg-label-warning' : '' }}
            {{ $item->status == 'approved' ? 'bg-label-success' : '' }}
            {{ $item->status == 'rejected' ? 'bg-label-danger' : '' }}"
            id="status">
            {{ $item->status }}
        </span>
          </td>
        </tr>
        @endforeach
        @else
            <tr>
            <td colspan="6" class="text-center">Belum ada peminjaman.</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endsection