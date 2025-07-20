<div class="col-lg-6 col-md-6 col-12 col-sm-6">
    <div class="vendor-wrap style-2 mb-40">
        @if($shop->is_featured)
            <div class="product-badges product-badges-position product-badges-mrg">
                <span class="hot">Featured</span>
            </div>
        @endif
        <div class="vendor-img-action-wrap">
            <div class="vendor-img">
                <a href="/s/{{ $shop->slug }}">
                    @if($shop->logo)
                        <img class="default-img" src="{{ $shop->logo->getFullUrl() }}" alt="{{ $shop->name }}" />
                    @else
                        <img class="default-img" src="/assets/imgs/vendor/vendor-{{ (($loop->index % 8) + 1) }}.png" alt="{{ $shop->name }}" />
                    @endif
                </a>
            </div>
            <div class="mt-10">
                <span class="font-small total-product">{{ $shop->products_count }} products</span>
            </div>
        </div>
        <div class="vendor-content-wrap">
            <div class="mb-30">
                <div class="product-category">
                    <span class="text-muted">Since {{ $shop->created_at->format('Y') }}</span>
                </div>
                <h4 class="mb-5"><a href="/s/{{ $shop->slug }}">{{ $shop->name }}</a></h4>
                <div class="product-rate-cover">
                    <div class="product-rate d-inline-block">
                        <div class="product-rating" style="width: 90%"></div>
                    </div>
                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                </div>
                <div class="vendor-info d-flex justify-content-between align-items-end mt-30">
                    <ul class="contact-infor text-muted">
                        @if($shop->address)
                            <li><img src="/assets/imgs/theme/icons/icon-location.svg" alt="" /><strong>Address: </strong> <span>{{ Str::limit($shop->address, 50) }}</span></li>
                        @endif
                        @if($shop->phone)
                            <li><img src="/assets/imgs/theme/icons/icon-contact.svg" alt="" /><strong>Call Us:</strong><span>{{ $shop->phone }}</span></li>
                        @endif
                    </ul>
                    <a href="/s/{{ $shop->slug }}" class="btn btn-xs">Visit Store <i class="fi-rs-arrow-small-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>