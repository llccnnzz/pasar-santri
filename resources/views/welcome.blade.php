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
        <section class="home-slider style-2 position-relative mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div class="home-slide-cover">
                            <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                                <div class="single-hero-slider single-animation-wrap" style="background-image: url({{ $bannerPromotion['headline_primary'][0] }})">
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
                                <div class="single-hero-slider single-animation-wrap" style="background-image: url({{ $bannerPromotion['headline_primary'][1] }})">
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
                        <div class="banner-img style-3 animated animated" style="background-image: url({{ $bannerPromotion['headline_secondary'] }})">
                            <div class="banner-text mt-50">
                                <h2 class="mb-50">
                                    Delivered <br />
                                    to
                                    <span class="text-brand">your<br />
                                        home</span>
                                </h2>
                                <a href="/products" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
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
                            <img src="{{ $bannerPromotion['headline_child_1'] }}" alt="" />
                            <div class="banner-text">
                                <h4>
                                    Everyday Fresh & <br />Clean with Our<br />
                                    Products
                                </h4>
                                <a href="/products" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img">
                            <img src="{{ $bannerPromotion['headline_child_2'] }}" alt="" />
                            <div class="banner-text">
                                <h4>
                                    Make your Breakfast<br />
                                    Healthy and Easy
                                </h4>
                                <a href="/products" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-md-none d-lg-flex">
                        <div class="banner-img mb-sm-0">
                            <img src="{{ $bannerPromotion['headline_child_3'] }}" alt="" />
                            <div class="banner-text">
                                <h4>The best Organic <br />Products Online</h4>
                                <a href="/products" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
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
                                @include('layouts.landing.component.product.card', ['p' => $product])
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
                                    @include('layouts.landing.component.product.card', ['p' => $product])
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
                        <div class="banner-img style-2" style="background-image: url({{ $bannerPromotion['daily_best_seller'] }})">
                            <div class="banner-text">
                                <h2 class="mb-100">Bring nature into your home</h2>
                                <a href="/products" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
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
                                            @include('layouts.landing.component.product.card2', ['p' => $product])
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
                                            @include('layouts.landing.component.product.card2', ['p' => $product])
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-three-1" role="tabpanel" aria-labelledby="tab-three-1">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-3-arrows"></div>
                                    <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns-3">
                                        @foreach($latest->take(5) as $product)
                                            @include('layouts.landing.component.product.card2', ['p' => $product])
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
                    <a class="show-all" href="/products">
                        All Deals
                        <i class="fi-rs-angle-right"></i>
                    </a>
                </div>
                <div class="row">
                    @foreach($featured->take(4) as $product)
                        @include('layouts.landing.component.product.card-countdown', ['p' => $product, 'countDownStartAt' => Carbon::now()->addDays(rand(20,50))->startOfDay()])
                    @endforeach
                </div>
            </div>
        </section>
        <!--End Deals-->
        <section class="section-padding mb-30">
            <div class="container">
                <div class="row">
                    @foreach(['Top Selling' => $popular, 'Trending Products' => $featured, 'Recently added' => $latest, 'Top Rated' => $popular] as $sectionTitle => $products)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block">
                            <h4 class="section-title style-1 mb-30 animated animated">{{ $sectionTitle }}</h4>
                            <div class="product-list-small animated animated">
                                @foreach($products->take(3) as $product)
                                    @include('layouts.landing.component.product.card-article', ['p' => $product])
                                @endforeach
                            </div>
                        </div>
                    @endforeach
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
                                <a href="/products?filter[categories][]={{$category['id']}}"><img src="{{$category->icon->getFullUrl()}}" alt="{{$category['name']}}" /></a>
                            </figure>
                            <h6>
                                <a href="/products?filter[categories][]={{$category['id']}}">{{$category['name']}}</a>
                            </h6>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!--End category slider-->
    </main>

    @include('layouts.landing.component.footer')
@endsection

@push('script')
    @include('layouts.landing.component.product.card-handler')
@endpush
