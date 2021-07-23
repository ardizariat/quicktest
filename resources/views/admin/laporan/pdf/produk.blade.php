@extends('admin.laporan.pdf.layouts')

@section('content-pdf')
  <div class="container-fluid bg-white">
    <header>
      <div class="row d-flex justify-content-center">
        <div class="col-md-12">
          <img height="100px" src="{{ asset('images/default/avatar-1.png') }}" class="rounded mx-auto d-block float-right">
          <h1 class="text-bold text-center">Laporan Stok Barang</h1>
          <table>
            <tr>
              <th>Tanggal Ekspor Data</th>
              <th>:</th>
              <td> {{ $now }}</td>
            </tr>
            <tr>    
              <th>Tipe Ekspor</th>
              <th>:</th>
              <td> {{ $typeExport }}</td>
            </tr>
            <tr>
              <th>Pembuat</th>
              <th>:</th>
              <td> {{ auth()->user()->name }}</td>
            </tr>
            <tr>
              <th>Total Item Produk</th>
              <th>:</th>
              <td> {{ number_format($totalItemProduk,0,',','.') }} Item</td>
            </tr>
        </table>
        </div>
      </div>
    </header>
    
    <hr class="bg-dark">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Produk</th>
              <th>Kategori</th>
              <th>Tanggal</th>
              <th>Stok</th>
              <th>Minimal Stok</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $in)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $in->nama_produk }}</td>
              <td>{{ $in->category->kategori }}</td>
              <td>{{ $in->created_at->format('d F Y') }}</td>
              <td @if ($in->stok <= $in->minimal_stok) class="text-danger" @endif>
                {{ $in->stok }} {{ $in->satuan }}
              </td>
              <td>{{ $in->minimal_stok }} {{ $in->satuan }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection