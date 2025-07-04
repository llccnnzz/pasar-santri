@extends('layouts.landing.component.app')

@push('head')
    <style>
        .variant-option.disabled {
            pointer-events: none;
            opacity: 0.4;
        }
        .variant-option.active {
            font-weight: bold;
            border-bottom: 2px solid #333;
        }

        input.variant-qty-val {
            border: 0;
            border-radius: 0;
            height: unset;
            padding: 0 !important;
        }

        .variant-qty {
            max-width: 80px;
            padding: 9px 20px;
            position: relative;
            width: 100%;
            border-radius: 5px;
        }
        .variant-qty > a {
            font-size: 16px;
            position: absolute;
            right: 8px;
            color: #3BB77E;
        }
        .variant-qty > a:hover {
            color: #29A56C;
        }
        .variant-qty > a.variant-qty-up {
            top: 0;
        }
        .variant-qty> a.variant-qty-down {
            bottom: -4px;
        }

        .detail-extralink .variant-qty {
            margin: 0 6px 15px 0;
            background: #fff;
            border: 2px solid #3BB77E !important;
            font-size: 16px;
            font-weight: 700;
            color: #3BB77E;
            border-radius: 5px;
            padding: 11px 20px 11px 30px;
            max-width: 90px;
        }
    </style>
@endpush

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="/products">Product</a> <span></span> {{$product['name']}}
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50 mt-30">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        <figure class="border-radius-10">
                                            <img src="{{$product?->defaultImage?->getFullUrl()}}" alt="product image" />
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="{{$product?->hoverImage?->getFullUrl()}}" alt="product image" />
                                        </figure>
                                        @foreach($product->images ?? [] as $image)
                                        <figure class="border-radius-10">
                                            <img src="{{$image->getFullUrl()}}" alt="product image" />
                                        </figure>
                                        @endforeach
                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails">
                                        <div><img src="{{$product?->defaultImage?->getFullUrl()}}" alt="product image" /></div>
                                        <div><img src="{{$product?->hoverImage?->getFullUrl()}}" alt="product image" /></div>
                                        @foreach($product->images ?? [] as $image)
                                        <div><img src="{{$image->getFullUrl()}}" alt="product image" /></div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info pr-30 pl-30">
                                    <h2 class="title-detail">{{$product['name']}}</h2>
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
                                            <span class="current-price text-brand">Rp {{number_format($product['final_price'], 0, ',', '.')}}</span>
                                            <span>
                                                <span class="old-price font-md ml-15">Rp {{number_format($product['price'], 0, ',', '.')}}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="short-desc mb-30">
                                        <p class="font-lg">{{$product['meta_description']}}</p>
                                    </div>
                                    @php
                                        $groupedAttributes = [];

                                        foreach ($product->variants ?? [] as $variant) {
                                            foreach ($variant->attributeValues as $attrValue) {
                                                $attrName = $attrValue->attribute->name ?? 'Unknown';
                                                $groupedAttributes[$attrName][] = $attrValue->value;
                                            }
                                        }

                                        foreach ($groupedAttributes ?? [] as $key => $values) {
                                            $groupedAttributes[$key] = array_unique($values);
                                        }
                                    @endphp

                                    @foreach($groupedAttributes as $attributeName => $values)
                                        <div class="attr-detail attr-{{ Str::slug($attributeName) }} mb-30">
                                            <strong class="mr-10">{{ $attributeName }}:</strong>
                                            <ul class="list-filter size-filter font-small">
                                                @foreach($values as $value)
                                                    @php
                                                        $available = $product->variants->filter(function($v) use ($attributeName, $value) {
                                                            return $v->stock > 0 && $v->attributeValues->contains(function($av) use ($attributeName, $value) {
                                                                return $av->attribute->name === $attributeName && $av->value === $value;
                                                            });
                                                        })->isNotEmpty();
                                                    @endphp
                                                    <li>
                                                        <a href="#"
                                                           class="variant-option {{ !$available ? 'disabled' : '' }}"
                                                           data-attribute="{{ $attributeName }}"
                                                           data-value="{{ $value }}">
                                                            {{ $value }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                    <div class="attr-detail">
                                        <label class="me-1">Availability: </label>
                                        <span class="number-items-available text-success" id="stock-available">{{$product['final_stock']}} products available</span>
                                    </div>
                                    <div class="detail-extralink mb-50">

                                            <div class="variant-qty border radius">
                                                <a href="#" class="variant-qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <form id="add-to-cart" action="/cart" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                                    <input type="text" name="quantity" class="variant-qty-val" value="1" min="1">
                                                </form>
                                                <a href="#" class="variant-qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                            <div class="product-extra-link2">
                                                <button type="button" onclick="document.getElementById('add-to-cart').submit()" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>

                                    </div>
                                    <div class="font-xs">
                                        <ul class="mr-50 float-start">
                                            <li class="mb-5">SKU: <a id="variant-sku">{{$product['sku']}}</a></li>
                                            <li class="mb-5">Categories: @foreach($product->categories ?? [] as $category) <a href="#" rel="tag">{{$category['name']}}</a> @if(!$loop->last), @endif @endforeach
                                            </li>
                                            <li class="mb-5">Tags: @foreach($product['tags'] ?? [] as $tag) <a href="#" rel="tag">{{$tag}}</a> @if(!$loop->last), @endif @endforeach
                                            </li>
                                            <li class="mb-5">Brand: <span class="text-brand">{{$product['brand']}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="tab-style3">
                                <ul class="nav nav-tabs text-uppercase">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab" href="#Additional-info">Additional info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab" href="#Vendor-info">Vendor</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews (3)</a>
                                    </li>
                                </ul>
                                <div class="tab-content shop_info_tab entry-main-content">
                                    <div class="tab-pane fade show active" id="Description">
                                        <div class="">
                                            {!! nl2br($product['long_description']) !!}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Additional-info">
                                        @if(count($product['specification'] ?? []) > 0)
                                            <table class="font-md">
                                                <tbody>
                                                @foreach($product['specification'] as $specification)
                                                    <tr class="stand-up">
                                                        <th>{{$specification['name']}}</th>
                                                        <td>
                                                            <p>{{$specification['value']}}</p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="Vendor-info">
                                        <div class="vendor-logo d-flex mb-30">
                                            <img src="assets/imgs/vendor/vendor-18.svg" alt="" />
                                            <div class="vendor-name ml-15">
                                                <h6>
                                                    <a href="vendor-details-2.html">Noodles Co.</a>
                                                </h6>
                                                <div class="product-rate-cover text-end">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="contact-infor mb-50">
                                            <li><img src="assets/imgs/theme/icons/icon-location.svg" alt="" /><strong>Address: </strong> <span>5171 W Campbell Ave undefined Kent, Utah 53127 United States</span></li>
                                            <li><img src="assets/imgs/theme/icons/icon-contact.svg" alt="" /><strong>Contact Seller:</strong><span>(+91) - 540-025-553</span></li>
                                        </ul>
                                        <div class="d-flex mb-55">
                                            <div class="mr-30">
                                                <p class="text-brand font-xs">Rating</p>
                                                <h4 class="mb-0">92%</h4>
                                            </div>
                                            <div class="mr-30">
                                                <p class="text-brand font-xs">Ship on time</p>
                                                <h4 class="mb-0">100%</h4>
                                            </div>
                                            <div>
                                                <p class="text-brand font-xs">Chat response</p>
                                                <h4 class="mb-0">89%</h4>
                                            </div>
                                        </div>
                                        <p>Noodles & Company is an American fast-casual restaurant that offers international and American noodle dishes and pasta in addition to soups and salads. Noodles & Company was founded in 1995 by Aaron Kennedy and is headquartered in Broomfield, Colorado. The company went public in 2013 and recorded a $457 million revenue in 2017.In late 2018, there were 460 Noodles & Company locations across 29 states and Washington, D.C.</p>
                                    </div>
                                    <div class="tab-pane fade" id="Reviews">
                                        <!--Comments-->
                                        <div class="comments-area">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4 class="mb-30">Customer questions & answers</h4>
                                                    <div class="comment-list">
                                                        <div class="single-comment justify-content-between d-flex mb-30">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <img src="assets/imgs/blog/author-2.png" alt="" />
                                                                    <a href="#" class="font-heading text-brand">Sienna</a>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="d-flex justify-content-between mb-10">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="font-xs text-muted">December 4, 2024 at 3:12 pm </span>
                                                                        </div>
                                                                        <div class="product-rate d-inline-block">
                                                                            <div class="product-rating" style="width: 100%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi dignissimos sequi repudiandae minus ab deleniti totam officia id incidunt? <a href="#" class="reply">Reply</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-comment justify-content-between d-flex mb-30 ml-30">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <img src="assets/imgs/blog/author-3.png" alt="" />
                                                                    <a href="#" class="font-heading text-brand">Brenna</a>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="d-flex justify-content-between mb-10">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="font-xs text-muted">December 4, 2024 at 3:12 pm </span>
                                                                        </div>
                                                                        <div class="product-rate d-inline-block">
                                                                            <div class="product-rating" style="width: 80%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi dignissimos sequi repudiandae minus ab deleniti totam officia id incidunt? <a href="#" class="reply">Reply</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-comment justify-content-between d-flex">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <img src="assets/imgs/blog/author-4.png" alt="" />
                                                                    <a href="#" class="font-heading text-brand">Gemma</a>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="d-flex justify-content-between mb-10">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="font-xs text-muted">December 4, 2024 at 3:12 pm </span>
                                                                        </div>
                                                                        <div class="product-rate d-inline-block">
                                                                            <div class="product-rating" style="width: 80%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus, suscipit exercitationem accusantium obcaecati quos voluptate nesciunt facilis itaque modi commodi dignissimos sequi repudiandae minus ab deleniti totam officia id incidunt? <a href="#" class="reply">Reply</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h4 class="mb-30">Customer reviews</h4>
                                                    <div class="d-flex mb-30">
                                                        <div class="product-rate d-inline-block mr-15">
                                                            <div class="product-rating" style="width: 90%"></div>
                                                        </div>
                                                        <h6>4.8 out of 5</h6>
                                                    </div>
                                                    <div class="progress">
                                                        <span>5 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>4 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>3 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>2 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                                                    </div>
                                                    <div class="progress mb-30">
                                                        <span>1 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                                                    </div>
                                                    <a href="#" class="font-xs text-muted">How are ratings calculated?</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--comment form-->
                                        <div class="comment-form">
                                            <h4 class="mb-15">Add a review</h4>
                                            <div class="product-rate d-inline-block mb-30"></div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-12">
                                                    <form class="form-contact comment_form" action="#" id="commentForm">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9" placeholder="Write Comment"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <input class="form-control" name="name" id="name" type="text" placeholder="Name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <input class="form-control" name="email" id="email" type="email" placeholder="Email" />
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <input class="form-control" name="website" id="website" type="text" placeholder="Website" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="button button-contactForm">Submit Review</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-60">
                            <div class="col-12">
                                <h2 class="section-title style-1 mb-30">Related products</h2>
                            </div>
                            <div class="col-12">
                                <div class="row related-products">
                                    @foreach($relatedProducts as $relatedProduct)
                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="/{{$relatedProduct['slug']}}" tabindex="0">
                                                        <img class="default-img" src="{{$relatedProduct?->defaultImage?->getFullUrl()}}" alt="" />
                                                        <img class="hover-img" src="{{$relatedProduct?->hoverImage?->getFullUrl()}}" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="{{$relatedProduct['slug']}}" tabindex="0">{{$relatedProduct['name']}}</a></h2>
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <div class="product-price">
                                                    <span>Rp {{number_format($relatedProduct['final_price'], 0, ',', '.')}}</span>
                                                    <span class="old-price">Rp {{number_format($relatedProduct['price'], 0, ',', '.')}}</span>
                                                </div>
                                            </div>
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
    </main>
@endsection

@php
    $variantData = $product->variants->map(function ($variant) {
        return [
            'sku' => $variant->sku,
            'stock' => $variant->stock,
            'attributes' => $variant->attributeValues->mapWithKeys(function ($val) {
                return [$val->attribute->name => $val->value];
            }),
        ];
    });
@endphp

@php
    $variantData = $product->variants->map(function ($variant) {
        return [
            'sku' => $variant->sku,
            'stock' => $variant->stock,
            'attributes' => $variant->attributeValues->mapWithKeys(function ($val) {
                return [$val->attribute->name => $val->value];
            }),
        ];
    });
@endphp

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allVariants = @json($variantData);
            const selections = {};
            const stockDisplay = document.getElementById('stock-available');
            const skuDisplay = document.getElementById('variant-sku');
            const qtyInput = document.querySelector('.variant-qty-val');
            const btnUp = document.querySelector('.variant-qty-up');
            const btnDown = document.querySelector('.variant-qty-down');

            let currentMaxStock = {{ $product->stock }};

            function sanitizeQty() {
                let val = parseInt(qtyInput.value) || 1;
                if (val > currentMaxStock) val = currentMaxStock;
                if (val < 1) val = 1;
                qtyInput.value = val;
            }

            btnUp.addEventListener('click', function (e) {
                e.preventDefault();
                let val = parseInt(qtyInput.value) || 1;
                if (val < currentMaxStock) {
                    qtyInput.value = val + 1;
                }
            });

            btnDown.addEventListener('click', function (e) {
                e.preventDefault();
                let val = parseInt(qtyInput.value) || 1;
                if (val > 1) {
                    qtyInput.value = val - 1;
                }
            });

            qtyInput.addEventListener('input', sanitizeQty);

            // Handle variant selection
            document.querySelectorAll('.variant-option').forEach(option => {
                option.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (this.classList.contains('disabled')) return;

                    const attr = this.dataset.attribute;
                    const value = this.dataset.value;
                    selections[attr] = value;

                    // Set active
                    this.closest('ul').querySelectorAll('.variant-option').forEach(el => el.classList.remove('active'));
                    this.classList.add('active');

                    const attrCount = Object.keys(allVariants[0]?.attributes || {}).length;
                    if (Object.keys(selections).length < attrCount) {
                        currentMaxStock = {{ $product->stock }};
                        stockDisplay.textContent = '{{ $product->stock }} products available';
                        skuDisplay.textContent = '{{ $product->sku }}';
                        sanitizeQty();
                        return;
                    }

                    const matched = allVariants.find(variant =>
                        Object.keys(selections).every(key => variant.attributes[key] === selections[key])
                    );

                    if (matched) {
                        currentMaxStock = matched.stock;
                        stockDisplay.textContent = matched.stock + ' products available';
                        skuDisplay.textContent = matched.sku;
                        sanitizeQty();
                    } else {
                        currentMaxStock = 0;
                        stockDisplay.textContent = 'Out of stock';
                        skuDisplay.textContent = '{{ $product->sku }}';
                        qtyInput.value = 0;
                    }
                });
            });
        });
    </script>
@endpush
