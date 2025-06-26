@extends('layouts.landing.component.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Product
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
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">By Categories</h5>
                                    <div class="categories-dropdown-wrap font-heading">
                                        <div class="row">
                                            @foreach($categories as $category)
                                                <div class="col-6">
                                                    <div class="custome-checkbox d-flex align-items-start">
                                                        <input class="form-check-input category-filter me-2 mt-1"
                                                               type="checkbox"
                                                               value="{{ $category['id'] }}"
                                                               id="checkbox-category-{{ $category['id'] }}">
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
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">By Brands</h5>
                                    <div class="brands-dropdown-wrap font-heading">
                                        <div class="row">
                                            @foreach($brands as $index => $brand)
                                                <div class="col-6">
                                                    <div class="custome-checkbox d-flex align-items-start">
                                                        <input class="form-check-input brand-filter me-2 mt-1"
                                                               type="checkbox"
                                                               value="{{ $brand }}"
                                                               id="checkbox-brand-{{ $index }}">
                                                        <label class="form-check-label"
                                                               for="checkbox-brand-{{ $index }}">
                                                            {{ $brand }}
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
                                                <div class="col-6">
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
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>We found <strong class="text-brand">0</strong> items for you!</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown per-page">
                                    <ul>
                                        <li><a class="active" href="#">50</a></li>
                                        <li><a href="#">100</a></li>
                                        <li><a href="#">150</a></li>
                                        <li><a href="#">200</a></li>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const baseUrl = '/api/products';

            let state = {
                categories: [],
                tags: [],
                brands: [],
                sort: 'created_at',
                perPage: 50,
                currentPage: 1
            };

            // === Helper: Build Query Parameters ===
            function buildQuery() {
                const params = new URLSearchParams();

                state.categories.forEach(cat => params.append('filter[categories][]', cat));
                state.tags.forEach(tag => params.append('filter[tags][]', tag));
                state.brands.forEach(price => params.append('filter[brands][]', price));
                if (state.sort) params.set('sort', state.sort);
                params.set('page[number]', state.currentPage);
                params.set('page[size]', state.perPage);

                return params.toString();
            }

            // === Fetch & Render Products ===
            async function fetchProducts() {
                const res = await fetch(`${baseUrl}?${buildQuery()}`);
                const data = await res.json();
                renderProducts(data.data);
                renderPagination(data.meta, data.links);
                renderTotal(data.meta);
            }

            // === Render Product Cards ===
            function renderProducts(products) {
                const container = document.querySelector('.product-grid');
                container.innerHTML = '';

                products.forEach(product => {
                    container.innerHTML += `
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="/${product.slug}">
                                            <img class="default-img" src="${product.default_image.url}" alt="" />
                                            <img class="hover-img" src="${product.hover_image.url}" alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
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
                                        <span class="font-small text-muted">By <a href="vendor-details-1.html">${product.brand}</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>Rp ${formatPrice(product.final_price)}</span>
                                            <span class="old-price">Rp ${formatPrice(product.price)}</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
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
                const totalElement = document.querySelector('.totall-product strong.text-brand');
                if (totalElement) {
                    totalElement.textContent = meta.total;
                }
            }

            // === Event Listeners ===
            function setupListeners() {
                // Category checkbox
                document.querySelectorAll('[id^="checkbox-"]').forEach(el => {
                    el.addEventListener('change', () => {
                        const id = el.id;
                        const label = el.value;

                        const isCategory = id.includes('checkbox-') && el.closest('.card').querySelector('h5').innerText.includes('Categories');
                        const isBrand = id.includes('checkbox-brand') && el.closest('.card').querySelector('h5').innerText.includes('Brands');
                        const isTag = id.includes('checkbox-tag') && el.closest('.card').querySelector('h5').innerText.includes('Tags');
                        const list = isCategory ? state.categories :
                            isBrand ? state.brands :
                                isTag ? state.tags : null;

                        if (!list) return;

                        const value = label;
                        if (el.checked && !list.includes(value)) list.push(value);
                        else if (!el.checked) list.splice(list.indexOf(value), 1);

                        state.currentPage = 1;
                        fetchProducts();
                    });
                });

                // Tag filters
                document.querySelectorAll('.widget-tags a').forEach(el => {
                    el.addEventListener('click', e => {
                        e.preventDefault();
                        const tag = el.innerText.trim();
                        if (!state.tags.includes(tag)) state.tags.push(tag);
                        state.currentPage = 1;
                        fetchProducts();
                    });
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
                        fetchProducts();
                    });
                });

                document.querySelectorAll('.per-page ul li a').forEach(el => {
                    el.addEventListener('click', e => {
                        e.preventDefault();
                        const count = parseInt(el.innerText.trim());
                        state.perPage = isNaN(count) ? 50 : count;
                        state.currentPage = 1;
                        console.log(state)
                        fetchProducts();
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
