<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="product-cart-wrap style-2">
        <div class="product-img-action-wrap">
            <div class="product-img">
                <a href="/{{$p['slug']}}">
                    <img src="{{$p?->defaultImage->getFullUrl()}}" alt="" />
                </a>
            </div>
        </div>
        <div class="product-content-wrap">
            <div class="deals-countdown-wrap">
                <div class="deals-countdown" data-countdown="{{ $countDownStartAt }}"></div>
            </div>
            <div class="deals-content">
                <h2><a href="/{{$p['slug']}}">{{$p['name']}}</a></h2>
                <div class="product-rate-cover">
                    <div class="product-rate d-inline-block">
                        <div class="product-rating" style="width: 90%"></div>
                    </div>
                    <span class="font-small ml-5 text-muted"> (4.5)</span>
                </div>
                <div>
                    <span class="font-small text-muted">By <a href="{{ $p['shop']['slug'] }}">{{ $p['shop']['name'] }}</a></span>
                </div>
                <div class="product-card-bottom">
                    <div class="product-price">
                        <span>Rp {{number_format($p['final_price'], 0, ',', '.')}}</span>
                        <span class="old-price">Rp {{number_format($p['price'], 0, ',', '.')}}</span>
                    </div>
                    <div class="add-cart">
                        <a class="add" href="#" onclick="addToCart('{{ $p['id'] }}', 1, '{{ csrf_token() }}')"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
