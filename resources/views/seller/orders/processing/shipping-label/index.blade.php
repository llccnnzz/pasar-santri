@extends('layouts.seller.main')

@section('title', 'Orders - Seller Dashboard')

@section('content')
    <!-- Section title -->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Orders</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="/seller/dashboard">Seller Dashboard</a>
                </li>
                <li class="breadcrumb-item fs-14">
                    <a class="text-decoration-none"
                        href="{{ route('seller.orders.index', ['status' => 'processing']) }}">Processing</a>
                </li>
                <li class="breadcrumb-item fs-14">
                    <a class="text-decoration-none"
                        href="{{ route('seller.orders.show', ['order' => $order]) }}">{{$order['invoice']}}</a>
                </li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Shipping Label</li>
            </ol>
        </nav>
    </div>

    <div class="card rounded-3 border-0 products-card mb-24 table-edit-area">
        <div class="card-body text-body p-25">
            {{-- Preview label --}}
            <div class="pdf-preview border rounded" style="height: 80vh;">
                <iframe src="{{ route('seller.orders.label.pdf', $order->id) }}"
                        width="100%"
                        height="100%"
                        frameborder="0"></iframe>
            </div>
        </div>
    </div>
@endsection
