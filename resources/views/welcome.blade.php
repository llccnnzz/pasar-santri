@php use Carbon\Carbon; @endphp
@extends('layouts.landing.component.app')

@section('content')
    <main class="main">
        <section class="home-slider style-2 position-relative mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div class="home-slide-cover">
                            <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                                <div class="single-hero-slider single-animation-wrap" style="background-image: url(assets/imgs/slider/slider-3.png)">
                                    <div class="slider-content">
                                        <h1 class="display-2 mb-40">
                                            Pure Coffe<br />
                                            Big discount
                                        </h1>
                                        <p class="mb-65">Save up to 50% off on your first order</p>
                                        <form class="form-subcriber d-flex">
                                            <input type="email" placeholder="Your emaill address" />
                                            <button class="btn" type="submit">Subscribe</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="single-hero-slider single-animation-wrap" style="background-image: url(assets/imgs/slider/slider-4.png)">
                                    <div class="slider-content">
                                        <h1 class="display-2 mb-40">
                                            Snacks box<br />
                                            daily save
                                        </h1>
                                        <p class="mb-65">Sign up for the daily newsletter</p>
                                        <form class="form-subcriber d-flex">
                                            <input type="email" placeholder="Your emaill address" />
                                            <button class="btn" type="submit">Subscribe</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="slider-arrow hero-slider-1-arrow"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-xl-block">
                        <div class="banner-img style-3 animated animated">
                            <div class="banner-text mt-50">
                                <h2 class="mb-50">
                                    Delivered <br />
                                    to
                                    <span class="text-brand">your<br />
                                        home</span>
                                </h2>
                                <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End hero slider-->
        <section class="banners mb-25">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img">
                            <img src="/assets/imgs/banner/banner-1.png" alt="" />
                            <div class="banner-text">
                                <h4>
                                    Everyday Fresh & <br />Clean with Our<br />
                                    Products
                                </h4>
                                <a href="/" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img">
                            <img src="/assets/imgs/banner/banner-2.png" alt="" />
                            <div class="banner-text">
                                <h4>
                                    Make your Breakfast<br />
                                    Healthy and Easy
                                </h4>
                                <a href="/" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-md-none d-lg-flex">
                        <div class="banner-img mb-sm-0">
                            <img src="/assets/imgs/banner/banner-3.png" alt="" />
                            <div class="banner-text">
                                <h4>The best Organic <br />Products Online</h4>
                                <a href="/" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End banners-->
        <section class="product-tabs section-padding position-relative">
            <div class="container">
                <div class="section-title style-2">
                    <h3>Popular Products</h3>
                    <ul class="nav nav-tabs links" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">All</button>
                        </li>
                        @foreach($categories->take(5) as $index => $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nav-tab-{{$index}}" data-bs-toggle="tab" data-bs-target="#tab-{{$index}}" type="button" role="tab" aria-controls="tab-{{$index}}" aria-selected="false">{{$category['name']}}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!--End nav-tabs-->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                        <div class="row product-grid-4">
                            @foreach($featured as $product)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="/{{$product['slug']}}">
                                                    <img class="default-img" src="{{$product?->defaultImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" />
                                                    <img class="hover-img" src="{{$product?->hoverImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" class="action-btn" href="{{ route('wishlist.index') }}"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="{{ route('products.index') }}">{{$product['tags'][0] ?? 'Product'}}</a>
                                            </div>
                                            <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href="#">{{$product['brand'] ?? 'Brand'}}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>Rp {{number_format($product['final_price'], 0, ',', '.')}}</span>
                                                    @if($product['price'] != $product['final_price'])
                                                        <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                                    @endif
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="{{ route('cart.index') }}"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!--end product card-->
                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab one-->
                    @foreach($categoryProducts as $index => $category)
                        <div class="tab-pane fade" id="tab-{{$index}}" role="tabpanel" aria-labelledby="tab-{{$index}}">
                            <div class="row product-grid-4">
                                @foreach($category->products as $product)
                                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap mb-30">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="/{{$product['slug']}}">
                                                        <img class="default-img" src="{{$product?->defaultImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" />
                                                        <img class="hover-img" src="{{$product?->hoverImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" />
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Add To Wishlist" class="action-btn" href="{{ route('wishlist.index') }}"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                                    <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="{{ route('products.index') }}">{{$product['tags'][0] ?? 'Product'}}</a>
                                                </div>
                                                <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (4.5)</span>
                                                </div>
                                                <div>
                                                    <span class="font-small text-muted">By <a href="#">{{$product['brand'] ?? 'Brand'}}</a></span>
                                                </div>
                                                <div class="product-card-bottom">
                                                    <div class="product-price">
                                                    <div class="product-price">
                                                        <span>Rp {{number_format($product['final_price'], 0, ',', '.')}}</span>
                                                        @if($product['price'] != $product['final_price'])
                                                            <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="add-cart">
                                                        <a class="add" href="{{ route('cart.index') }}"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!--End product-grid-4-->
                        </div>
                    @endforeach
                </div>
                <!--End tab-content-->
            </div>
        </section>
        <!--Products Tabs-->
        <section class="section-padding pb-5">
            <div class="container">
                <div class="section-title">
                    <h3 class="">Daily Best Sells</h3>
                    <ul class="nav nav-tabs links" id="myTab-2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="nav-tab-one-1" data-bs-toggle="tab" data-bs-target="#tab-one-1" type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-two-1" data-bs-toggle="tab" data-bs-target="#tab-two-1" type="button" role="tab" aria-controls="tab-two" aria-selected="false">Popular</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-three-1" data-bs-toggle="tab" data-bs-target="#tab-three-1" type="button" role="tab" aria-controls="tab-three" aria-selected="false">New added</button>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-lg-3 d-none d-lg-flex">
                        <div class="banner-img style-2">
                            <div class="banner-text">
                                <h2 class="mb-100">Bring nature into your home</h2>
                                <a href="/" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <div class="tab-content" id="myTabContent-1">
                            <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-arrows"></div>
                                    <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                        @foreach($featured->take(5) as $product)
                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="/{{$product['slug']}}">
                                                        <img class="default-img" src="{{$product?->defaultImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" />
                                                        <img class="hover-img" src="{{$product?->hoverImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" />
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="{{ route('wishlist.index') }}"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up" href="#"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="{{ route('products.index') }}">{{$product['tags'][0] ?? 'Product'}}</a>
                                                </div>
                                                <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <div class="product-price mt-10">
                                                    <span>Rp {{number_format($product['final_price'], 0, ',', '.')}} </span>
                                                    @if($product['price'] != $product['final_price'])
                                                        <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                                    @endif
                                                </div>
                                                <div class="sold mt-15 mb-15">
                                                    @php $soldCount = rand(1, min(5, $product['final_stock'])); @endphp
                                                    <div class="progress mb-5">
                                                        <div class="progress-bar" role="progressbar" style="width: {{$product['final_stock'] > 0 ? (($product['final_stock'] - $soldCount) / $product['final_stock'] * 100) : 0}}%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="font-xs text-heading"> Sold: {{$soldCount}}/{{$product['final_stock']}}</span>
                                                </div>
                                                <a href="{{ route('cart.index') }}" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                            </div>
                                        </div>
                                        <!--End product Wrap-->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--End tab-pane-->
                            <div class="tab-pane fade" id="tab-two-1" role="tabpanel" aria-labelledby="tab-two-1">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-2-arrows"></div>
                                    <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns-2">
                                        @foreach($popular->take(5) as $product)
                                            <div class="product-cart-wrap">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a href="/{{$product['slug']}}">
                                                            <img class="default-img" src="{{$product?->defaultImage?->getFullUrl()}}" alt="" />
                                                            <img class="hover-img" src="{{$product?->hoverImage?->getFullUrl()}}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-action-1">
                                                        <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
                                                        <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                        <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product-content-wrap">
                                                    <div class="product-category">
                                                        <a href="shop-grid-right.html">{{$product['tags'][0] ?? null}}</a>
                                                    </div>
                                                    <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <div class="product-price mt-10">
                                                        <span>Rp {{number_format($product['final_price'], 0, ',', '.')}} </span>
                                                        <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                                    </div>
                                                    <div class="sold mt-15 mb-15">
                                                        @php $rand = rand(1,5);@endphp
                                                        <div class="progress mb-5">
                                                            <div class="progress-bar" role="progressbar" style="width: {{(($product['final_stock'] - $rand) / $product['final_stock'] * 100)}}%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="font-xs text-heading"> Sold: {{($product['final_stock'] - $rand)}}/{{$product['final_stock']}}</span>
                                                    </div>
                                                    <a href="shop-cart.html" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                                </div>
                                            </div>
                                            <!--End product Wrap-->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-three-1" role="tabpanel" aria-labelledby="tab-three-1">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-3-arrows"></div>
                                    <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns-3">
                                        @foreach($latest->take(5) as $product)
                                            <div class="product-cart-wrap">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a href="/{{$product['slug']}}">
                                                            <img class="default-img" src="{{$product?->defaultImage?->getFullUrl()}}" alt="" />
                                                            <img class="hover-img" src="{{$product?->hoverImage?->getFullUrl()}}" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="product-action-1">
                                                        <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
                                                        <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                        <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product-content-wrap">
                                                    <div class="product-category">
                                                        <a href="shop-grid-right.html">{{$product['tags'][0] ?? null}}</a>
                                                    </div>
                                                    <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <div class="product-price mt-10">
                                                        <span>Rp {{number_format($product['final_price'], 0, ',', '.')}} </span>
                                                        <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                                    </div>
                                                    <div class="sold mt-15 mb-15">
                                                        @php $rand = rand(1,5);@endphp
                                                        <div class="progress mb-5">
                                                            <div class="progress-bar" role="progressbar" style="width: {{(($product['final_stock'] - $rand) / $product['final_stock'] * 100)}}%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="font-xs text-heading"> Sold: {{($product['final_stock'] - $rand)}}/{{$product['final_stock']}}</span>
                                                    </div>
                                                    <a href="shop-cart.html" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                                </div>
                                            </div>
                                            <!--End product Wrap-->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End tab-content-->
                    </div>
                    <!--End Col-lg-9-->
                </div>
            </div>
        </section>
        <!--End Best Sales-->
        <section class="section-padding pb-5">
            <div class="container">
                <div class="section-title">
                    <h3 class="">Deals Of The Day</h3>
                    <a class="show-all" href="shop-grid-right.html">
                        All Deals
                        <i class="fi-rs-angle-right"></i>
                    </a>
                </div>
                <div class="row">
                    @foreach($featured->take(4) as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="product-cart-wrap style-2">
                            <div class="product-img-action-wrap">
                                <div class="product-img">
                                    <a href="/{{$product['slug']}}">
                                        <img src="{{$product?->defaultImage->getFullUrl()}}" alt="" />
                                    </a>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="deals-countdown-wrap">
                                    <div class="deals-countdown" data-countdown="{{Carbon::now()->addDays(rand(20,50))->startOfDay()}}"></div>
                                </div>
                                <div class="deals-content">
                                    <h2><a href="/{{$product['slug']}}">{{$product['name']}}</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.5)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a href="vendor-details-1.html">{{$product['brand']}}</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>Rp {{number_format($product['final_price'], 0, ',', '.')}}</span>
                                            <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!--End Deals-->
        <section class="section-padding mb-30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0">
                        <h4 class="section-title style-1 mb-30 animated animated">Top Selling</h4>
                        <div class="product-list-small animated animated">
                            @foreach($popular->take(3) as $product)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="/{{$product['slug']}}"><img src="{{$product?->defaultImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="/{{$product['slug']}}">{{$product['name']}}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.5)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>Rp {{number_format($product['final_price'], 0, ',', '.')}}</span>
                                        <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0">
                        <h4 class="section-title style-1 mb-30 animated animated">Trending Products</h4>
                        <div class="product-list-small animated animated">
                            @foreach($featured->take(3) as $product)
                                <article class="row align-items-center hover-up">
                                    <figure class="col-md-4 mb-0">
                                        <a href="/{{$product['slug']}}"><img src="{{$product?->defaultImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" /></a>
                                    </figure>
                                    <div class="col-md-8 mb-0">
                                        <h6>
                                            <a href="/{{$product['slug']}}">{{$product['name']}}</a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.5)</span>
                                        </div>
                                        <div class="product-price">
                                            <span>Rp {{number_format($product['final_price'], 0, ',', '.')}}</span>
                                            <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block">
                        <h4 class="section-title style-1 mb-30 animated animated">Recently added</h4>
                        <div class="product-list-small animated animated">
                            @foreach($latest->take(3) as $product)
                                <article class="row align-items-center hover-up">
                                    <figure class="col-md-4 mb-0">
                                        <a href="/{{$product['slug']}}"><img src="{{$product?->defaultImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" /></a>
                                    </figure>
                                    <div class="col-md-8 mb-0">
                                        <h6>
                                            <a href="/{{$product['slug']}}">{{$product['name']}}</a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.5)</span>
                                        </div>
                                        <div class="product-price">
                                            <span>Rp {{number_format($product['final_price'], 0, ',', '.')}}</span>
                                            <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block">
                        <h4 class="section-title style-1 mb-30 animated animated">Top Rated</h4>
                        <div class="product-list-small animated animated">
                            @foreach($popular->take(3) as $product)
                                <article class="row align-items-center hover-up">
                                    <figure class="col-md-4 mb-0">
                                        <a href="/{{$product['slug']}}"><img src="{{$product?->defaultImage?->getFullUrl()}}" alt="{{$product['name']}}" loading="lazy" /></a>
                                    </figure>
                                    <div class="col-md-8 mb-0">
                                        <h6>
                                            <a href="/{{$product['slug']}}">{{$product['name']}}</a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.5)</span>
                                        </div>
                                        <div class="product-price">
                                            <span>Rp {{number_format($product['final_price'], 0, ',', '.')}}</span>
                                            <span class="old-price">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End 4 columns-->
        <section class="popular-categories section-padding">
            <div class="container">
                <div class="section-title">
                    <div class="title">
                        <h3>Shop by Categories</h3>
                        <a class="show-all" href="/products">
                            All Categories
                            <i class="fi-rs-angle-right"></i>
                        </a>
                    </div>
                    <div class="slider-arrow slider-arrow-2 flex-right carausel-8-columns-arrow" id="carausel-8-columns-arrows"></div>
                </div>
                <div class="carausel-8-columns-cover position-relative">
                    <div class="carausel-8-columns" id="carausel-8-columns">
                        @foreach($categories as $category)
                        <div class="card-1">
                            <figure class="img-hover-scale overflow-hidden">
                                <a href="/{{$product['slug']}}"><img src="{{$category->icon->getFullUrl()}}" alt="" /></a>
                            </figure>
                            <h6>
                                <a href="/{{$product['slug']}}">{{$category['name']}}</a>
                            </h6>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!--End category slider-->
    </main>
@endsection

@section('modal')
    <div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider">
                                    <figure class="border-radius-10">
                                        <img src="/assets/imgs/shop/product-16-2.jpg" alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="/assets/imgs/shop/product-16-1.jpg" alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="/assets/imgs/shop/product-16-3.jpg" alt="product image" />
                                    </figure>
                                </div>
                                <!-- THUMBNAILS -->
                                <div class="slider-nav-thumbnails">
                                    <div><img src="/assets/imgs/shop/thumbnail-3.jpg" alt="product image" /></div>
                                    <div><img src="/assets/imgs/shop/thumbnail-4.jpg" alt="product image" /></div>
                                    <div><img src="/assets/imgs/shop/thumbnail-5.jpg" alt="product image" /></div>
                                </div>
                            </div>
                            <!-- End Gallery -->
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                <h3 class="title-detail"><a href="shop-product-right.html" class="text-heading">Seeds of Change Organic Quinoa, Brown</a></h3>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        <span class="current-price text-brand">$38</span>
                                        <span>
                                            <span class="old-price font-md ml-15">$52</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-extralink mb-30">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <span class="qty-val">1</span>
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                                <div class="font-xs">
                                    <ul>
                                        <li class="mb-5">Brand: <span class="text-brand">Nest</span></li>
                                        <li class="mb-5">MFG:<span class="text-brand"> Jun 4.2024</span></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Detail Info -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
