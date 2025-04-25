@extends('layout')

@section('content')
    <h2>Data Order</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-group mb-4">
        @foreach ($orders as $order)
            <li class="list-group-item">
                Siswa ID: {{ $order->siswa_id }} - Produk ID: {{ $order->produk_id }} - Jumlah: {{ $order->jumlah }} - Total Harga: Rp{{ number_format($order->total_harga, 0, ',', '.') }}
            </li>
        @endforeach
    </ul>

    <h3>Tambah Order</h3>
    <form method="POST" action="/orders" class="row g-3">
        @csrf
        <div class="col-md-4">
            <select name="siswa_id" class="form-select">
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa['id'] }}">{{ $siswa['nama'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <select name="produk_id" class="form-select">
                @foreach ($produks as $produk)
                    <option value="{{ $produk['id'] }}">{{ $produk['nama'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <input name="jumlah" type="number" class="form-control" placeholder="Jumlah" min="1">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Tambah Order</button>
        </div>
    </form>
@endsection
