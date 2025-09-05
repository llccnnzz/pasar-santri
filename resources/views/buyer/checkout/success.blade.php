@extends('layouts.landing.component.app')

@section('title', 'Pesanan Berhasil')
@section('description', 'Halaman sukses checkout')

@section('content')
<main class="main">
    <div class="container text-center my-5">
        <h2 class="mb-3">🎉 Pesanan Berhasil Dibuat!</h2>
        <h5 class="text-muted mb-4">Terima kasih sudah berbelanja di toko kami.</h5>

        <p class="text-muted">
            Silahkan melanjutkan pembayaran pada aplikasi <strong>emaal</strong>.<br>
            Berikut kode billing Anda:
        </p>

        @if($payments->count())
            <ul class="list-unstyled mt-3">
                @foreach($payments as $payment)
                    <li>
                        <span class="d-block fw-bold text-primary display-6">
                            {{ $payment->reference_id }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('account') }}" class="btn btn-primary mt-4">
            Lihat Pesanan Saya
        </a>
    </div>
</main>
@endsection
