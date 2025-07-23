@extends('layouts.landing.component.app')

@section('title'){{ $seoData['title'] }}@endsection
@section('description'){{ $seoData['description'] }}@endsection
@section('keywords'){{ $seoData['keywords'] }}@endsection
@section('canonical'){{ $seoData['canonical'] }}@endsection
@section('og_title'){{ $seoData['title'] }}@endsection
@section('og_description'){{ $seoData['description'] }}@endsection
@section('og_type'){{ 'website' }}@endsection
@section('og_image'){{ $seoData['og_image'] }}@endsection

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('homepage') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="/shops">Shops</a> <span></span> {{ $shop->name }}
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="archive-header-3 mt-30 mb-80" style="background-image: url(/assets/imgs/vendor/vendor-header-bg.png)">
                <div class="archive-header-3-inner">
                    <div class="vendor-logo mr-50">
                        @if($shop->logo)
                            <img src="{{ $shop->logo->getFullUrl() }}" alt="{{ $shop->name }}" />
                        @else
                            <img src="/assets/imgs/vendor/vendor-17.png" alt="{{ $shop->name }}" />
                        @endif
                    </div>
                    <div class="vendor-content">
                        <h3 class="mb-5 text-white"><a href="#" class="text-white">{{ $shop->name }}</a></h3>
                        <div class="product-rate-cover mb-15">
                            <div class="product-rate d-inline-block">
                                <div class="product-rating" style="width: {{ $avgRating * 20 }}%"></div>
                            </div>
                            <span class="font-small ml-5 text-muted"> ({{ number_format($avgRating, 1) }})</span>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="vendor-des mb-15">
                                    <p class="font-sm text-white">{{ $shop->description ?? 'Welcome to our store! We offer high-quality products with excellent customer service.' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="vendor-info text-white mb-15">
                                    <ul class="font-sm">
                                        @if($shop->address)
                                        <li><img class="mr-5" src="/assets/imgs/theme/icons/icon-location.svg" alt="" /><strong>Address: </strong> <span>{{ $shop->address }}</span></li>
                                        @endif
                                        @if($shop->phone)
                                        <li><img class="mr-5" src="/assets/imgs/theme/icons/icon-contact.svg" alt="" /><strong>Call Us:</strong><span>{{ $shop->phone }}</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                @if($socialLinks && count($socialLinks) > 0)
                                <div class="follow-social">
                                    <h6 class="mb-15 text-white">Follow Us</h6>
                                    <ul class="social-network">
                                        @foreach($socialLinks as $link)
                                            @if($link['url'])
                                            <li class="hover-up">
                                                <a href="{{ $link['url'] }}" target="_blank">
                                                    <img src="{{ strtolower($link['logo']) }}" alt="{{ $link['name'] }}" />
                                                </a>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="archive-header-2 text-center">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <div class="sidebar-widget-2 widget_search">
                                <div class="search-form">
                                    <form action="" method="GET">
                                        @foreach(request()->except(['search']) as $key => $value)
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endforeach
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search in this store..." />
                                        <button type="submit"><i class="fi-rs-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row flex-row-reverse">
                <div class="col-lg-4-5">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>We found <strong class="text-brand">{{ $products->total() }}</strong> items for you!</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> {{ request('per_page', 15) }} <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="{{ request('per_page') == '15' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 15]) }}">15</a></li>
                                        <li><a class="{{ request('per_page') == '30' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 30]) }}">30</a></li>
                                        <li><a class="{{ request('per_page') == '60' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 60]) }}">60</a></li>
                                        <li><a class="{{ request('per_page') == '90' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 90]) }}">90</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> 
                                            @switch(request('sort'))
                                                @case('price_low') Price: Low to High @break
                                                @case('price_high') Price: High to Low @break
                                                @case('rating') Avg. Rating @break
                                                @case('newest') Release Date @break
                                                @default Name A-Z
                                            @endswitch
                                            <i class="fi-rs-angle-small-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="{{ !request('sort') || request('sort') == 'name' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}">Name A-Z</a></li>
                                        <li><a class="{{ request('sort') == 'price_low' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}">Price: Low to High</a></li>
                                        <li><a class="{{ request('sort') == 'price_high' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}">Price: High to Low</a></li>
                                        <li><a class="{{ request('sort') == 'newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Release Date</a></li>
                                        <li><a class="{{ request('sort') == 'rating' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}">Avg. Rating</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product-grid">
                        @forelse($products as $product)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 {{ $product->stock <= 0 ? 'out-of-stock' : '' }}">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="/{{ $product->slug }}">
                                            @if($product->defaultImage)
                                                <img class="default-img" src="{{ $product->defaultImage->getUrl() }}" alt="{{ $product->name }}" />
                                            @else
                                                <img class="default-img" src="/assets/imgs/shop/product-1-1.jpg" alt="{{ $product->name }}" />
                                            @endif
                                            @if($product->hoverImage)
                                                <img class="hover-img" src="{{ $product->hoverImage->getUrl() }}" alt="{{ $product->name }}" />
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="{{ route('wishlist.index') }}"><i class="fi-rs-heart"></i></a>
                                    </div>
                                    @if($product->stock <= 0)
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="out-of-stock-badge">Out of Stock</span>
                                    </div>
                                    @elseif($product->is_featured)
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Hot</span>
                                    </div>
                                    @elseif($product->final_price && $product->final_price < $product->price)
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="sale">Sale</span>
                                    </div>
                                    @elseif($product->created_at->isAfter(now()->subDays(7)))
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="new">New</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        @if($product->categories->first())
                                            <a href="{{ route('products.index', ['category' => $product->categories->first()->slug]) }}">{{ $product->categories->first()->name }}</a>
                                        @endif
                                    </div>
                                    <h2><a href="/{{ $product->slug }}">{{ $product->name }}</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 85%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.2)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a href="/s/{{ $product->shop->slug }}">{{ $product->shop->name }}</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            @if($product->final_price && $product->final_price < $product->price)
                                                <span>Rp. {{ number_format($product->final_price) }}</span><br>
                                                <span class="old-price">Rp. {{ number_format($product->price) }}</span>
                                            @else
                                                <span>Rp. {{ number_format($product->price) }}</span>
                                            @endif
                                        </div>
                                        <div class="add-cart">
                                            @if($product->stock <= 0)
                                                <a class="add" href="#" style="background: none; color: red; font-size: 12px" onclick="return false;">Out of Stock</a>
                                            @else
                                                <a class="add" href="{{ route('cart.index') }}"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <h3>No products found</h3>
                                <p>Try adjusting your search or filter criteria.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <!--product grid-->
                    <div class="pagination-area mt-20 mb-20">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
                    <div class="sidebar-widget widget-store-info mb-30 bg-3 border-0">
                        <div class="vendor-logo mb-30">
                            @if($shop->logo)
                                <img src="{{ $shop->logo->getFullUrl() }}" alt="{{ $shop->name }}" />
                            @else
                                <img src="/assets/imgs/vendor/vendor-16.png" alt="{{ $shop->name }}" />
                            @endif
                        </div>
                        <div class="vendor-info">
                            <div class="product-category">
                                <span class="text-muted">Since {{ $shop->created_at->format('Y') }}</span>
                            </div>
                            <h4 class="mb-5"><a href="#" class="text-heading">{{ $shop->name }}</a></h4>
                            <div class="product-rate-cover mb-15">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: {{ $avgRating * 20 }}%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> ({{ number_format($avgRating, 1) }})</span>
                            </div>
                            <div class="vendor-des mb-30">
                                <p class="font-sm text-heading">{{ $shop->description ?? 'Welcome to our store! We offer high-quality products with excellent customer service.' }}</p>
                            </div>
                            @if($socialLinks && count($socialLinks) > 0)
                            <div class="follow-social mb-20">
                                <h6 class="mb-15">Follow Us</h6>
                                <ul class="social-network">
                                    @foreach($socialLinks as $link)
                                        @if($link['url'])
                                        <li class="hover-up">
                                            <a href="{{ $link['url'] }}" target="_blank">
                                                <img src="{{ strtolower($link['logo']) }}" alt="{{ $link['name'] }}" />
                                            </a>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="vendor-info">
                                <ul class="font-sm mb-20">
                                    @if($shop->address)
                                    <li><img class="mr-5" src="/assets/imgs/theme/icons/icon-location.svg" alt="" /><strong>Address: </strong> <span>{{ $shop->address }}</span></li>
                                    @endif
                                    @if($shop->phone)
                                    <li><img class="mr-5" src="/assets/imgs/theme/icons/icon-contact.svg" alt="" /><strong>Call Us:</strong><span>{{ $shop->phone }}</span></li>
                                    @endif
                                </ul>
                                <a href="#" class="btn btn-xs">Contact Seller <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @if($categories->count() > 0)
                    <div class="sidebar-widget widget-category-2 mb-30">
                        <h5 class="section-title style-1 mb-30">Categories</h5>
                        <ul>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug]) }}"> 
                                    @if($category->icon)
                                        <img src="{{ $category->icon->getUrl() }}" alt="{{ $category->name }}" />
                                    @else
                                        <img src="/assets/imgs/theme/icons/category-1.svg" alt="{{ $category->name }}" />
                                    @endif
                                    {{ $category->name }}
                                </a>
                                <span class="count">{{ $category->products_count }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if($priceRange && $priceRange->min_price && $priceRange->max_price)
                    <!-- Filter By Price -->
                    <div class="sidebar-widget price_range range mb-30">
                        <h5 class="section-title style-1 mb-30">Filter by price</h5>
                        <form action="" method="GET">
                            @foreach(request()->except(['min_price', 'max_price']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <div class="price-filter">
                                <div class="price-filter-inner">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="caption">Min: 
                                            <input type="number" name="min_price" value="{{ request('min_price', $priceRange->min_price) }}" 
                                                   min="{{ $priceRange->min_price }}" max="{{ $priceRange->max_price }}" 
                                                   class="form-control form-control-sm d-inline-block" style="width: 80px;">
                                        </div>
                                        <div class="caption">Max: 
                                            <input type="number" name="max_price" value="{{ request('max_price', $priceRange->max_price) }}" 
                                                   min="{{ $priceRange->min_price }}" max="{{ $priceRange->max_price }}" 
                                                   class="form-control form-control-sm d-inline-block" style="width: 80px;">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-default w-100"><i class="fi-rs-filter mr-5"></i>Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
