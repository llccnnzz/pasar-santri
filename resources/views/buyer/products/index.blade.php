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
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span>
                    @if(isset($searchQuery) && isset($selectedCategory) && $searchQuery && $selectedCategory)
                        Search: "{{ $searchQuery }}" in {{ $selectedCategory->name }}
                    @elseif(isset($searchQuery) && $searchQuery)
                        Search: "{{ $searchQuery }}"
                    @elseif(isset($selectedCategory) && $selectedCategory)
                        {{ $selectedCategory->name }}
                    @else
                        Products
                    @endif
                </div>
            </div>
        </div>
        <div class="container mb-30 mt-30">
            <div class="row">
                <div class="col-lg-12">
                    <a class="shop-filter-toogle" href="#">
                        <span class="fi-rs-filter mr-5"></span>
                        Filters
                        <i class="fi-rs-angle-small-down angle-down"></i>
                        <i class="fi-rs-angle-small-up angle-up"></i>
                    </a>
                    <div class="shop-product-fillter-header" style="display: none">
                        <div class="row">
                            <div class="col-xl-2 col-lg-4 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">Search Products</h5>
                                    <div class="search-wrap">
                                        <input type="text"
                                               id="filter-search-input"
                                               class="form-control"
                                               placeholder="Search products..."
                                               value="{{ $searchQuery ?? '' }}">
                                        <button type="button" class="btn btn-primary btn-sm mt-2 w-100" id="apply-search-filter">
                                            Search
                                        </button>
                                        @if(isset($searchQuery) && $searchQuery)
                                            <button type="button" class="btn btn-outline-secondary btn-sm mt-1 w-100" id="clear-search-filter">
                                                Clear Search
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">By Categories</h5>
                                    <div class="categories-dropdown-wrap font-heading">
                                        <div class="row">
                                            @foreach($categories as $category)
                                                <div class="col-12">
                                                    <div class="custome-checkbox d-flex align-items-start">
                                                        <input class="form-check-input category-filter me-2 mt-1"
                                                               type="checkbox"
                                                               value="{{ $category['id'] }}"
                                                               id="checkbox-category-{{ $category['id'] }}"
                                                               {{ (isset($selectedCategory) && $selectedCategory && $selectedCategory->id == $category['id']) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="checkbox-category-{{ $category['id'] }}">
                                                            {{ $category['name'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">By Brands</h5>
                                    <div class="brands-dropdown-wrap font-heading">
                                        <div class="row">
                                            @foreach($brands as $index => $shop)
                                                <div class="col-12">
                                                    <div class="custome-checkbox d-flex align-items-start">
                                                        <input class="form-check-input brand-filter me-2 mt-1"
                                                               type="checkbox"
                                                               value="{{ $shop['id'] }}"
                                                               id="checkbox-brand-{{ $index }}">
                                                        <label class="form-check-label"
                                                               for="checkbox-brand-{{ $index }}">
                                                            {{ $shop['name'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">By Tags</h5>
                                    <div class="brands-dropdown-wrap font-heading">
                                        <div class="row">
                                            @foreach($tags as $index => $tag)
                                                <div class="col-12">
                                                    <div class="custome-checkbox d-flex align-items-start">
                                                        <input class="form-check-input tag-filter me-2 mt-1"
                                                               type="checkbox"
                                                               value="{{ $tag }}"
                                                               id="checkbox-tag-{{ $index }}">
                                                        <label class="form-check-label"
                                                               for="checkbox-tag-{{ $index }}">
                                                            {{ $tag }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">By Price Range</h5>
                                    <div class="price-range-wrap">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="min-price" class="form-label">Min Price</label>
                                                <input type="number"
                                                       id="min-price"
                                                       class="form-control form-control-sm"
                                                       placeholder="{{ $minPrice }}"
                                                       min="{{ $minPrice }}"
                                                       max="{{ $maxPrice }}">
                                            </div>
                                            <div class="col-6">
                                                <label for="max-price" class="form-label">Max Price</label>
                                                <input type="number"
                                                       id="max-price"
                                                       class="form-control form-control-sm"
                                                       placeholder="{{ $maxPrice }}"
                                                       min="{{ $minPrice }}"
                                                       max="{{ $maxPrice }}">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2 w-100" id="apply-price-filter">
                                            Apply Price Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <div id="loading-indicator" style="display: none;">
                                <div class="spinner-border spinner-border-sm me-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                Loading products...
                            </div>
                            <div id="product-count">
                                <h4></h4>
                                <p>We found <strong class="text-brand">0</strong> items for you!</p>
                            </div>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> 20 <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown per-page">
                                    <ul>
                                        <li><a class="active" href="#">20</a></li>
                                        <li><a href="#">50</a></li>
                                        <li><a href="#">100</a></li>
                                        <li><a href="#">150</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> Default <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">Default</a></li>
                                        <li><a href="#">Price: Low to High</a></li>
                                        <li><a href="#">Price: High to Low</a></li>
                                        <li><a href="#">Name: A-Z</a></li>
                                        <li><a href="#">Name: Z-A</a></li>
                                        <li><a href="#">Oldest</a></li>
                                        <li><a href="#">Newest</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product-grid">
                    </div>
                    <!--product grid-->
                    <div class="pagination-area mt-20 mb-20">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    @include('layouts.landing.component.product.card-handler')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const baseUrl = '/api/products';

            let state = {
                categories: [],
                tags: [],
                brands: [],
                priceRange: { min: null, max: null },
                sort: 'created_at',
                perPage: 20,
                currentPage: 1,
                search: ''
            };

            // Initialize state from URL parameters and server data
            const urlParams = new URLSearchParams(window.location.search);

            // Set search from URL or server data
            @if(isset($searchQuery) && $searchQuery)
                state.search = {!! json_encode($searchQuery) !!};
            @else
                if (urlParams.get('search')) {
                    state.search = urlParams.get('search');
                }
            @endif

            // Set category from server data
            @if(isset($selectedCategory) && $selectedCategory)
                state.categories.push({!! json_encode($selectedCategory->id) !!});
            @endif

            let debounceTimer = null;

            // === Helper: Build Query Parameters ===
            function buildQuery() {
                const params = new URLSearchParams();

                state.categories.forEach(cat => params.append('filter[categories][]', cat));
                state.tags.forEach(tag => params.append('filter[tags][]', tag));
                state.brands.forEach(brand => params.append('filter[brands][]', brand));

                // Add search filter
                if (state.search && state.search.trim() !== '') {
                    params.set('filter[search]', state.search.trim());
                }

                // Add price range filter
                if (state.priceRange.min || state.priceRange.max) {
                    if (state.priceRange.min) params.set('filter[price_range][min]', state.priceRange.min);
                    if (state.priceRange.max) params.set('filter[price_range][max]', state.priceRange.max);
                }

                if (state.sort) params.set('sort', state.sort);
                params.set('page[number]', state.currentPage);
                params.set('page[size]', state.perPage);

                return params.toString();
            }

            // === Update URL without reload ===
            function updateUrlWithoutReload() {
                const url = new URL(window.location);
                url.search = buildQuery();
                window.history.pushState({}, '', url);
            }

                        // === Fetch & Render Products ===
            async function fetchProducts() {
                try {
                    showLoading(true);

                    const res = await fetch(`${baseUrl}?${buildQuery()}`);
                    if (!res.ok) throw new Error('Failed to fetch products');

                    const data = await res.json();
                    renderProducts(data.data);
                    renderPagination(data.meta, data.links);
                    renderTotal(data.meta);
                } catch (error) {
                    console.error('Error fetching products:', error);
                    showError('Failed to load products. Please try again.');
                } finally {
                    showLoading(false);
                }
            }

            function showLoading(show) {
                document.getElementById('loading-indicator').style.display = show ? 'block' : 'none';
                document.getElementById('product-count').style.display = show ? 'none' : 'block';
            }

            function showError(message) {
                const container = document.querySelector('.product-grid');
                container.innerHTML = `<div class="col-12 text-center p-4"><div class="alert alert-danger">${message}</div></div>`;
            }

            function debouncedFetch() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(fetchProducts, 300);
            }

            // === Render Product Cards ===
            function renderProducts(products) {
                const container = document.querySelector('.product-grid');
                container.innerHTML = '';

                products.forEach(product => {
                    const outOfStock = product.stock <= 0;
                    container.innerHTML += `
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 ${outOfStock ? 'out-of-stock' : ''}">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="/${product.slug}">
                                            <img class="default-img" src="${product.default_image.url}" alt="" />
                                            <img class="hover-img" src="${product.hover_image.url}" alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="#" onclick="addToWishlist('${product.id}', '{{ csrf_token() }}')"><i class="fi-rs-heart"></i></a>
                                    </div>
                                    ${outOfStock ? '<div class="product-badges product-badges-position product-badges-mrg"><span class="out-of-stock-badge">Out of Stock</span></div>' : ''}
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">${product?.tags?.[0]}</a>
                                    </div>
                                    <h2><a href="/${product.slug}">${product.name}</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.5)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a href="/s/${product.shop_slug}">${product.shop_name}</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                        ${parseInt(product.final_price) > 0 && parseInt(product.final_price) < parseInt(product.price) ?
                                            `<span>Rp ${formatPrice(product.final_price)}</span><br>
                                            <span class="old-price">Rp ${formatPrice(product.price)}</span>` :
                                            `<span>Rp ${formatPrice(product.price)}</span>`
                                        }
                                        </div>
                                        <div class="add-cart">
                                            ${outOfStock ?
                                                '<a class="add" href="#" style="background: none; color: red; font-size: 12px" onclick="return false;">Out of Stock</a>' :
                                                '<a class="add" href="#" onclick="addToCart(\'' + product.id + '\', 1, \'{{ csrf_token() }}\')"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>'
                                            }
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });
            }

            function formatPrice(price) {
                return Number(price).toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
            }

            // === Render Pagination ===
            function renderPagination(meta, links) {
                const container = document.querySelector('.pagination');
                container.innerHTML = '';

                if (links.prev) {
                    container.innerHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${meta.current_page - 1}"><i class="fi-rs-arrow-small-left"></i></a></li>`;
                }

                for (let i = 1; i <= meta.last_page; i++) {
                    container.innerHTML += `<li class="page-item ${i === meta.current_page ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
                }

                if (links.next) {
                    container.innerHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${meta.current_page + 1}"><i class="fi-rs-arrow-small-right"></i></a></li>`;
                }
            }

            function renderTotal(meta) {
                const totalElement = document.querySelector('#product-count .text-brand');
                if (totalElement) {
                    totalElement.textContent = meta.total;
                }
            }

            // === Event Listeners ===
            function setupListeners() {
                // Search filters
                const applySearchBtn = document.getElementById('apply-search-filter');
                if (applySearchBtn) {
                    applySearchBtn.addEventListener('click', () => {
                        const searchInput = document.getElementById('filter-search-input');
                        state.search = searchInput.value.trim();
                        state.currentPage = 1;

                        // Update URL to reflect search
                        const url = new URL(window.location);
                        if (state.search) {
                            url.searchParams.set('search', state.search);
                        } else {
                            url.searchParams.delete('search');
                        }
                        window.history.pushState({}, '', url);

                        debouncedFetch();
                    });
                }

                // Clear search filter
                const clearSearchBtn = document.getElementById('clear-search-filter');
                if (clearSearchBtn) {
                    clearSearchBtn.addEventListener('click', () => {
                        const searchInput = document.getElementById('filter-search-input');
                        searchInput.value = '';
                        state.search = '';
                        state.currentPage = 1;

                        // Update URL to remove search
                        const url = new URL(window.location);
                        url.searchParams.delete('search');
                        window.history.pushState({}, '', url);

                        debouncedFetch();
                    });
                }

                // Allow Enter key to trigger search
                const searchInput = document.getElementById('filter-search-input');
                if (searchInput) {
                    searchInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            document.getElementById('apply-search-filter').click();
                        }
                    });
                }

                // Category filters
                document.querySelectorAll('.category-filter').forEach(el => {
                    el.addEventListener('change', () => {
                        const categoryId = el.value;

                        if (el.checked && !state.categories.includes(categoryId)) {
                            state.categories.push(categoryId);
                        } else if (!el.checked) {
                            const index = state.categories.indexOf(categoryId);
                            if (index > -1) {
                                state.categories.splice(index, 1);
                            }
                        }

                        state.currentPage = 1;
                        debouncedFetch();
                        updateUrlWithoutReload();
                    });
                });

                // Brand and Tag filters (keeping original logic for other filters)
                document.querySelectorAll('[id^="checkbox-brand"], [id^="checkbox-tag"]').forEach(el => {
                    el.addEventListener('change', () => {
                        const id = el.id;
                        const label = el.value;

                        const isBrand = id.includes('checkbox-brand');
                        const isTag = id.includes('checkbox-tag');
                        const list = isBrand ? state.brands : isTag ? state.tags : null;

                        if (!list) return;

                        const value = label;
                        if (el.checked && !list.includes(value)) list.push(value);
                        else if (!el.checked) list.splice(list.indexOf(value), 1);

                        state.currentPage = 1;
                        debouncedFetch();
                        updateUrlWithoutReload();
                    });
                });

                // Tag filters
                document.querySelectorAll('.widget-tags a').forEach(el => {
                    el.addEventListener('click', e => {
                        e.preventDefault();
                        const tag = el.innerText.trim();
                        if (!state.tags.includes(tag)) state.tags.push(tag);
                        state.currentPage = 1;
                        debouncedFetch();
                    });
                });

                // Price range filter
                document.getElementById('apply-price-filter').addEventListener('click', () => {
                    const minPrice = document.getElementById('min-price').value;
                    const maxPrice = document.getElementById('max-price').value;

                    state.priceRange.min = minPrice ? parseInt(minPrice) : null;
                    state.priceRange.max = maxPrice ? parseInt(maxPrice) : null;
                    state.currentPage = 1;
                    debouncedFetch();
                });


                // Handle toggle dropdown
                document.querySelectorAll('.sort-by-dropdown-wrap').forEach(function (dropdownToggle) {
                    dropdownToggle.addEventListener('click', function () {
                        const dropdown = this.closest('.sort-by-cover').querySelector('.sort-by-dropdown');
                        document.querySelectorAll('.sort-by-dropdown').forEach(d => {
                            if (d !== dropdown) d.classList.remove('active');
                        });
                        dropdown.classList.toggle('active');
                    });
                });

                // Handle option selection
                document.querySelectorAll('.sort-by-dropdown ul li a').forEach(function (option) {
                    option.addEventListener('click', function (e) {
                        e.preventDefault();

                        const value = this.textContent.trim();
                        const wrapper = this.closest('.sort-by-cover');
                        const dropdownWrap = wrapper.querySelector('.sort-by-dropdown-wrap span');

                        // Set selected value
                        dropdownWrap.innerHTML = `${value} <i class="fi-rs-angle-small-down"></i>`;

                        // Remove active class from all, then add to current
                        wrapper.querySelectorAll('.sort-by-dropdown ul li a').forEach(el => el.classList.remove('active'));
                        this.classList.add('active');

                        // Close dropdown
                        wrapper.querySelector('.sort-by-dropdown').classList.remove('active');

                    });
                });

                // Close dropdown if clicking outside
                document.addEventListener('click', function (e) {
                    if (!e.target.closest('.sort-by-cover')) {
                        document.querySelectorAll('.sort-by-dropdown').forEach(d => d.classList.remove('active'));
                    }
                });


                // Sort by
                document.querySelectorAll('.sort-by-dropdown ul li a').forEach(el => {
                    el.addEventListener('click', e => {
                        e.preventDefault();
                        const sortText = el.innerText.trim().toLowerCase();
                        if (sortText.includes('low to high')) state.sort = 'final_price';
                        else if (sortText.includes('high to low')) state.sort = '-final_price';
                        else if (sortText.includes('a-z')) state.sort ='name';
                        else if (sortText.includes('z-a')) state.sort ='-name';
                        else if (sortText.includes('ewest')) state.sort = '-created_at';
                        else if (sortText.includes('ldest')) state.sort = 'created_at';
                        else state.sort = 'created_at';
                        state.currentPage = 1;
                        debouncedFetch();
                    });
                });

                document.querySelectorAll('.per-page ul li a').forEach(el => {
                    el.addEventListener('click', e => {
                        e.preventDefault();
                        const count = parseInt(el.innerText.trim());
                        state.perPage = isNaN(count) ? 20 : count;
                        state.currentPage = 1;
                        console.log(state)
                        debouncedFetch();
                    });
                });

                document.querySelector('.pagination').addEventListener('click', e => {
                    if (e.target.closest('a')?.dataset.page) {
                        e.preventDefault();
                        state.currentPage = parseInt(e.target.closest('a').dataset.page);
                        fetchProducts();
                    }
                });
            }

            setupListeners();
            fetchProducts();
        });
    </script>
@endpush
