<article class="row align-items-center hover-up">
    <figure class="col-md-4 mb-0">
        <a href="/{{$p['slug']}}"><img src="{{$p?->defaultImage?->getFullUrl()}}" alt="" /></a>
    </figure>
    <div class="col-md-8 mb-0">
        <h6>
            <a href="/{{$p['slug']}}">{{$p['name']}}</a>
        </h6>
        <div class="product-rate-cover">
            <div class="product-rate d-inline-block">
                <div class="product-rating" style="width: 90%"></div>
            </div>
            <span class="font-small ml-5 text-muted"> (4.5)</span>
        </div>
        <div class="product-price">
            <span>Rp {{number_format($p['final_price'], 0, ',', '.')}}</span>
            <span class="old-price">Rp {{number_format($p['price'], 0, ',', '.')}}</span>
        </div>
    </div>
</article>
