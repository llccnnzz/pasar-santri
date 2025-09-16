@php use Carbon\Carbon; @endphp
@extends('layouts.landing.component.app')

@section('title'){{ $seoData['title'] }}@endsection
@section('description'){{ $seoData['description'] }}@endsection
@section('keywords'){{ $seoData['keywords'] }}@endsection
@section('canonical'){{ $seoData['canonical'] }}@endsection
@section('og_title'){{ $seoData['title'] }}@endsection
@section('og_description'){{ $seoData['description'] }}@endsection
@section('og_type'){{ 'website' }}@endsection

@section('content')
    <main class="main">
        <div class="container mb-30">
            <div class="row">
                <div class="col-lg-12">

                    <!-- Flash Sale Section -->
                    @if($bestDealData['flash_sale']->count() > 0)
                    <section class="product-tabs section-padding position-relative">
                        <div class="section-title style-2">
                            <h3>⚡ Flash Sale</h3>
                            <p class="font-sm text-muted">Limited time offers - grab them while you can!</p>
                        </div>
                        <div class="row product-grid-4">
                            @foreach($bestDealData['flash_sale'] as $product)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/{{$product['slug']}}">
                                                    <img class="default-img" src="{{$product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                    <img class="hover-img" src="{{$product->hoverImage?->getFullUrl() ?? $product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" class="action-btn" href="#" onclick="addToWishlist('{{ $product['id'] }}', '{{ csrf_token() }}')"><i class="fi-rs-heart"></i></a>
                                            </div>
                                            @if($product->valid_until)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="sale">Sale</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href="/s/{{ $product->shop['slug'] }}">{{$product->shop['name']}}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>Rp {{ number_format($product['final_price']) }}</span>
                                                    @if($product['price'] > $product['final_price'])
                                                        <span class="old-price">Rp {{ number_format($product['price']) }}</span>
                                                    @endif
                                                </div>
                                                <div class="add-cart">
                                                    @if($product['stock'] > 0)
                                                        <a href="#" onclick="addToCart('{{ $product['id'] }}', 1, '{{ csrf_token() }}')" class="add"><i class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                                    @else
                                                        <a href="#" class="add" style="background: #ccc; cursor: not-allowed;"><i class="fi-rs-ban mr-5"></i>Out of Stock</a>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($product->valid_until)
                                                <div class="mt-10">
                                                    <span class="font-xs text-danger">
                                                        <i class="fi-rs-clock"></i> Ends: {{ Carbon::parse($product->valid_until)->format('d M Y H:i') }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- Hot Promo Section -->
                    @if($bestDealData['hot_promo']->count() > 0)
                    <section class="product-tabs section-padding position-relative">
                        <div class="section-title style-2">
                            <h3>🔥 Hot Promo</h3>
                            <p class="font-sm text-muted">Featured promotional products you can't miss!</p>
                        </div>
                        <div class="row product-grid-4">
                            @foreach($bestDealData['hot_promo'] as $product)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/{{$product['slug']}}">
                                                    <img class="default-img" src="{{$product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                    <img class="hover-img" src="{{$product->hoverImage?->getFullUrl() ?? $product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" class="action-btn" href="#" onclick="addToWishlist('{{ $product['id'] }}', '{{ csrf_token() }}')"><i class="fi-rs-heart"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href="/s/{{ $product->shop['slug'] }}">{{$product->shop['name']}}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>Rp {{ number_format($product['final_price']) }}</span>
                                                    @if($product['price'] > $product['final_price'])
                                                        <span class="old-price">Rp {{ number_format($product['price']) }}</span>
                                                    @endif
                                                </div>
                                                <div class="add-cart">
                                                    @if($product['stock'] > 0)
                                                        <a href="#" onclick="addToCart('{{ $product['id'] }}', 1, '{{ csrf_token() }}')" class="add"><i class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                                    @else
                                                        <a href="#" class="add" style="background: #ccc; cursor: not-allowed;"><i class="fi-rs-ban mr-5"></i>Out of Stock</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- Big Discount Section -->
                    @if($bestDealData['big_discount']->count() > 0)
                    <section class="product-tabs section-padding position-relative">
                        <div class="section-title style-2">
                            <h3>💰 Big Discount</h3>
                            <p class="font-sm text-muted">Massive savings on selected products!</p>
                        </div>
                        <div class="row product-grid-4">
                            @foreach($bestDealData['big_discount'] as $product)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/{{$product['slug']}}">
                                                    <img class="default-img" src="{{$product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                    <img class="hover-img" src="{{$product->hoverImage?->getFullUrl() ?? $product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" class="action-btn" href="#" onclick="addToWishlist('{{ $product['id'] }}', '{{ csrf_token() }}')"><i class="fi-rs-heart"></i></a>
                                            </div>
                                            @if($product['price'] > $product['final_price'])
                                                @php
                                                    $discountPercentage = round((($product['price'] - $product['final_price']) / $product['price']) * 100);
                                                @endphp
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="sale">-{{$discountPercentage}}%</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href="/s/{{ $product->shop['slug'] }}">{{$product->shop['name']}}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>Rp {{ number_format($product['final_price']) }}</span>
                                                    @if($product['price'] > $product['final_price'])
                                                        <span class="old-price">Rp {{ number_format($product['price']) }}</span>
                                                    @endif
                                                </div>
                                                <div class="add-cart">
                                                    @if($product['stock'] > 0)
                                                        <a href="#" onclick="addToCart('{{ $product['id'] }}', 1, '{{ csrf_token() }}')" class="add"><i class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                                    @else
                                                        <a href="#" class="add" style="background: #ccc; cursor: not-allowed;"><i class="fi-rs-ban mr-5"></i>Out of Stock</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- Under 10K Section -->
                    @if($bestDealData['less_than_10k']->count() > 0)
                    <section class="product-tabs section-padding position-relative">
                        <div class="section-title style-2">
                            <h3>🏷️ Under 50K</h3>
                            <p class="font-sm text-muted">Budget-friendly products under Rp 50,000!</p>
                        </div>
                        <div class="row product-grid-4">
                            @foreach($bestDealData['less_than_10k'] as $product)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/{{$product['slug']}}">
                                                    <img class="default-img" src="{{$product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                    <img class="hover-img" src="{{$product->hoverImage?->getFullUrl() ?? $product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" class="action-btn" href="#" onclick="addToWishlist('{{ $product['id'] }}', '{{ csrf_token() }}')"><i class="fi-rs-heart"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">Budget</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href="/s/{{ $product->shop['slug'] }}">{{$product->shop['name']}}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>Rp {{ number_format($product['final_price']) }}</span>
                                                    @if($product['price'] > $product['final_price'])
                                                        <span class="old-price">Rp {{ number_format($product['price']) }}</span>
                                                    @endif
                                                </div>
                                                <div class="add-cart">
                                                    @if($product['stock'] > 0)
                                                        <a href="#" onclick="addToCart('{{ $product['id'] }}', 1, '{{ csrf_token() }}')" class="add"><i class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                                    @else
                                                        <a href="#" class="add" style="background: #ccc; cursor: not-allowed;"><i class="fi-rs-ban mr-5"></i>Out of Stock</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- New Products Section -->
                    @if($bestDealData['new_product']->count() > 0)
                    <section class="product-tabs section-padding position-relative">
                        <div class="section-title style-2">
                            <h3>✨ New Arrivals</h3>
                            <p class="font-sm text-muted">Discover the latest products in our collection!</p>
                        </div>
                        <div class="row product-grid-4">
                            @foreach($bestDealData['new_product'] as $product)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/{{$product['slug']}}">
                                                    <img class="default-img" src="{{$product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                    <img class="hover-img" src="{{$product->hoverImage?->getFullUrl() ?? $product->defaultImage?->getFullUrl() ?? '/assets/imgs/theme/placeholder.svg'}}" alt="{{$product['name']}}" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" class="action-btn" href="#" onclick="addToWishlist('{{ $product['id'] }}', '{{ csrf_token() }}')"><i class="fi-rs-heart"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href="/s/{{ $product->shop['slug'] }}">{{$product->shop['name']}}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>Rp {{ number_format($product['final_price']) }}</span>
                                                    @if($product['price'] > $product['final_price'])
                                                        <span class="old-price">Rp {{ number_format($product['price']) }}</span>
                                                    @endif
                                                </div>
                                                <div class="add-cart">
                                                    @if($product['stock'] > 0)
                                                        <a href="#" onclick="addToCart('{{ $product['id'] }}', 1, '{{ csrf_token() }}')" class="add"><i class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                                    @else
                                                        <a href="#" class="add" style="background: #ccc; cursor: not-allowed;"><i class="fi-rs-ban mr-5"></i>Out of Stock</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                </div>
            </div>
        </div>
    </main>

    @include('layouts.landing.component.footer')
@endsection

@push('script')
    @include('layouts.landing.component.product.card-handler')
@endpush
