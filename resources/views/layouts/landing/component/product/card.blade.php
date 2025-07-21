<div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
    <div class="product-cart-wrap mb-30 {{ $p['stock'] <= 0 ? 'out-of-stock' : '' }}">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="/{{$p['slug']}}">
                    <img class="default-img" src="{{$p?->defaultImage?->getFullUrl()}}" alt="" />
                    <img class="hover-img" src="{{$p?->hoverImage?->getFullUrl()}}" alt="" />
                </a>
                @if($p['stock'] <= 0)
                    <div class="product-badges product-badges-position product-badges-mrg">
                        <span class="out-of-stock-badge">Out of Stock</span>
                    </div>
                @endif
            </div>
            <div class="product-action-1">
                <a aria-label="Add To Wishlist" class="action-btn" href="#" onclick="addToWishlist('{{ $p['id'] }}', '{{ csrf_token() }}')"><i class="fi-rs-heart"></i></a>
            </div>
        </div>
        <div class="product-content-wrap">
            <div class="product-category">
                <a href="#">{{$p['tags'][0] ?? null}}</a>
            </div>
            <h2><a href="/{{$p['slug']}}">{{$p['name']}}</a></h2>
            <div class="product-rate-cover">
                <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width: 90%"></div>
                </div>
                <span class="font-small ml-5 text-muted"> (4.5)</span>
            </div>
            <div>
                <span class="font-small text-muted">By <a href="/s/{{ $p['shop']['slug'] }}">{{$p['shop']['name']}}</a></span>
            </div>
            <div class="product-card-bottom">
                <div class="product-price">
                    @if($p->final_price && $p->final_price < $p->price)
                        <span>Rp. {{ number_format($p->final_price) }}</span><br>
                        <span class="old-price">Rp. {{ number_format($p->price) }}</span>
                    @else
                        <span>Rp. {{ number_format($p->price) }}</span>
                    @endif
                </div>
                <div class="add-cart">
                    @if($p['stock'] <= 0)
                        <a class="add" href="#" style="background: none; color: red; font-size: 12px" onclick="return false;">Out of Stock</a>
                    @else
                        <a class="add" href="#" onclick="addToCart('{{ $p['id'] }}', 1, '{{ csrf_token() }}')"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
