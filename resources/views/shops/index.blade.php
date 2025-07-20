@extends('layouts.landing.component.app')

@section('content')
    <main class="main pages mb-80">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shops List
                </div>
            </div>
        </div>
        <div class="page-content pt-50">
            <div class="container">
                <div class="archive-header-2 text-center">
                    <h1 class="display-2 mb-50">Our Shops</h1>
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <div class="sidebar-widget-2 widget_search mb-50">
                                <div class="search-form">
                                    <form action="#" method="GET">
                                        <input type="text" name="search" placeholder="Search shops (by name)..." value="{{ request('search') }}" />
                                        <button type="submit"><i class="fi-rs-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-50">
                    <div class="col-12 col-lg-8 mx-auto">
                        <div class="shop-product-fillter">
                            <div class="totall-product">
                                <p>We have <strong class="text-brand">{{ $shops->total() }}</strong> shops now</p>
                            </div>
                            <div class="sort-by-product-area">
                                <div class="sort-by-cover mr-10">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps"></i>Show:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> {{ request('per_page', 12) }} <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{ request('per_page') == '12' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 12]) }}">12</a></li>
                                            <li><a class="{{ request('per_page') == '24' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 24]) }}">24</a></li>
                                            <li><a class="{{ request('per_page') == '36' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['per_page' => 36]) }}">36</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sort-by-cover">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> {{ ucfirst(request('sort', 'name')) }} <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{ request('sort') == 'name' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}">Name A-Z</a></li>
                                            <li><a class="{{ request('sort') == 'name_desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}">Name Z-A</a></li>
                                            <li><a class="{{ request('sort') == 'products_count' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'products_count']) }}">Most Products</a></li>
                                            <li><a class="{{ request('sort') == 'newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row vendor-grid">
                    @foreach($shops as $shop)
                        @include('layouts.landing.component.shop.card', ['shop' => $shop])
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($shops->hasPages())
                    <div class="pagination-area mt-20 mb-20">
                        <nav aria-label="Page navigation">
                            {{ $shops->withQueryString()->links() }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script>
        // Handle dropdown toggles
        document.querySelectorAll('.sort-by-dropdown-wrap').forEach(function (dropdownToggle) {
            dropdownToggle.addEventListener('click', function () {
                const dropdown = this.closest('.sort-by-cover').querySelector('.sort-by-dropdown');
                document.querySelectorAll('.sort-by-dropdown').forEach(d => {
                    if (d !== dropdown) d.classList.remove('active');
                });
                dropdown.classList.toggle('active');
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.sort-by-cover')) {
                document.querySelectorAll('.sort-by-dropdown').forEach(d => d.classList.remove('active'));
            }
        });
    </script>
@endpush
