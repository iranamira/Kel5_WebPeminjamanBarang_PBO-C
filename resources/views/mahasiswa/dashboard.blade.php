@extends('layouts.mahasiswa')

@section('content')
<div class="container">
    <div class="card mt-4 p-3">
        <h5 class="text-xl card-header">Daftar Barang</h5>
        <div class="table-responsive text-wrap mb-2">
          <table class="table" id="barangTable">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Detail</th>
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
        <div class="p-3 mt-3">
            <h3 class="mb-2">*Jika terdapat barang yang tidak tersedia, dapat menghubungi :</h3>
            <ul>
                <li >Tri Susilo w - +62xxxxxxxxxxx</li>
                <li >Ratna Risanti - +62xxxxxxxxxxx</li>    
            </ul>
        </div>
    </div>
</div>
@endsection