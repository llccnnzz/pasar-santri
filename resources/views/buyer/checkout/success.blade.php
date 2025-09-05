@extends('layouts.landing.component.app')

@section('title', 'Pesanan Berhasil')
@section('description', 'Halaman sukses checkout')

@section('content')
<main class="main">
    <div class="container text-center my-5">
        <h2 class="mb-3">🎉 Pesanan berhasil dibuat!</h2>
        <p class="text-muted">Terima kasih sudah berbelanja di toko kami.</p>

        @if(session('orders'))
            <p class="mt-3">ID Pesanan:</p>
            <ul class="list-unstyled">
                @foreach(session('orders') as $orderId)
                    <li><code>{{ $orderId }}</code></li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('account') }}" class="btn btn-primary mt-4">
            Lihat Pesanan Saya
        </a>
    </div>
</main>
@endsection
