<div class="product-cart-wrap">
    <div class="product-img-action-wrap">
        <div class="product-img product-img-zoom">
            <a href="/{{$p['slug']}}">
                <img class="default-img" src="{{$p?->defaultImage?->getFullUrl()}}" alt="" />
                <img class="hover-img" src="{{$p?->hoverImage?->getFullUrl()}}" alt="" />
            </a>
        </div>
        <div class="product-action-1">
            <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
            <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="#" onclick="addToWishlist('{{ $p['id'] }}')"><i class="fi-rs-heart"></i></a>
        </div>
    </div>
    <div class="product-content-wrap">
        <div class="product-category">
            <a href="#">{{$p['tags'][0] ?? null}}</a>
        </div>
        <h2><a href="/{{$p['slug']}}">{{$p['name']}}</a></h2>
        <div class="product-rate d-inline-block">
            <div class="product-rating" style="width: 90%"></div>
        </div>
        <div class="product-price mt-10">
            <span>Rp {{number_format($p['final_price'], 0, ',', '.')}} </span>
            <span class="old-price">Rp {{number_format($p['price'], 0, ',', '.')}}</span>
        </div>
        <div class="sold mt-15 mb-15">
            @php $rand = rand(1,5);@endphp
            <div class="progress mb-5">
                <div class="progress-bar" role="progressbar" style="width: {{(($p['final_stock'] - $rand) / $p['final_stock'] * 100)}}%" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="font-xs text-heading"> Sold: {{($p['final_stock'] - $rand)}}/{{$p['final_stock']}}</span>
        </div>
        <a href="#" onclick="addToCart('{{ $p['id'] }}', 1, '{{ csrf_token() }}')" class="btn w-100 hover-up"><i class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
    </div>
</div>
