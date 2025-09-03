@extends('layouts.landing.component.app')

@section('title') Checkout Success @endsection
@section('description') @endsection

@section('content')
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Checkout Success
            </div>
        </div>
    </div>

    <div class="container mb-80 mt-50 text-center">
        <h2 class="mb-20">🎉 Pesanan Berhasil Dibuat</h2>
        <p>Terima kasih, pesanan Anda sudah masuk dan otomatis dibayar.</p>

        <a href="{{ }}" class="btn btn-outline-primary mt-3">Kembali ke Profil</a>
    </div>
</main>
@endsection
