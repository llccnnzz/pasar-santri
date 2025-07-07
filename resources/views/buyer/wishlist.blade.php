@extends('layouts.landing.component.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shop <span></span> Wishlist
                </div>
            </div>
        </div>
        <div class="container mb-30 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="mb-50">
                        <h1 class="heading-2 mb-10">Your Wishlist</h1>
                        <h6 class="text-body">There are <span class="text-brand">{{ count($wishlistItems) }}</span> products in this list</h6>
                    </div>
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                            <tr class="main-heading">
                                <th class="custome-checkbox start pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="" />
                                    <label class="form-check-label" for="exampleCheckbox11"></label>
                                </th>
                                <th scope="col" colspan="2">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Stock Status</th>
                                <th scope="col">Action</th>
                                <th scope="col" class="end">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($wishlistItems as $i => $item)
                                <tr class="{{ $i === 0 ? 'pt-30' : '' }}">
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="" />
                                        <label class="form-check-label" for="exampleCheckbox1"></label>
                                    </td>
                                    <td class="image product-thumbnail pt-40"><img src="{{ $item['image'] }}" alt="#" /></td>
                                    <td class="product-des product-name">
                                        <h6><a class="product-name mb-10" href="/{{ $item['slug'] }}">{{ $item['name'] }}</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">Rp. {{ number_format($item['price']) }}</h3>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <span class="stock-status {{ $item['stock'] > 0 ? 'in-stock' : 'out-stock' }} mb-0"> {{ $item['stock'] > 0 ? 'In Stock' : 'Out Stock' }} </span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        @if($item['stock'] > 0)
                                            <form id="add-to-cart-{{ $item['id'] }}" action="/cart" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                                <input type="hidden" name="quantity" value="1">
                                            </form>
                                            <button class="btn btn-sm" onclick="document.getElementById('add-to-cart-{{ $item['id'] }}').submit();">Add to cart</button>
                                        @else
                                            <button class="btn btn-sm btn-secondary">Contact Us</button>
                                        @endif
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <form id="remove-from-wishlist-{{ $item['id'] }}" action="/wishlist/{{ $item['id'] }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="#" onclick="document.getElementById('remove-from-wishlist-{{ $item['id'] }}').submit()" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Your wishlist is empty.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
