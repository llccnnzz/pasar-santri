@extends('layouts.landing.component.app')

@section('title', 'Pesanan Berhasil')
@section('description', 'Halaman sukses checkout')

@section('content')
<main class="main">
    <div class="container text-center my-5">
        <h5 class="text-muted">🎉 Pesanan Berhasil Dibuat!</h5>
        <h5 class="text-muted mb-4">Terima kasih sudah berbelanja di toko kami.</h5>

        <h2 class="mb-3">
            Silahkan melanjutkan pembayaran pada aplikasi
        </h2>
            <img src="/assets/imgs/theme/emaal.png" style="height: 40px; width: auto">
        <h3 class="mb-3"><br>
            Berikut kode billing Anda:
        </h3>

        @if($payments->count())
            <ul class="list-unstyled mt-3">
                @foreach($payments as $payment)
                    <li>
                        <span class="d-block fw-bold text-primary display-6">
                            {{ $payment->reference_id }}
                        </span>
                    </li>
                    <li>
                        <span class="d-block text-muted display-6">
                            Total Pembayaran
                        </span>
                    </li>
                    <li>
                        <span class="d-block fw-bold text-black-50 display-6">
                            Rp. {{ number_format($payment->total_amount, 0) }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif

        <p class="text-muted"><br>
            Jika anda sudah melakukan pembayaran, silahkan konfirmasi pembayaran pada halaman akun saya.
        </p>

        <a href="{{ route('account') }}" class="btn btn-primary mt-4">
            Lihat Pesanan Saya
        </a>
    </div>
</main>
@endsection
