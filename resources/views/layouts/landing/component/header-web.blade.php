@php
    use App\Models\Category;
    $categories = Category::with(['icon'])->get();
@endphp
<header class="header-area header-style-1 header-height-2">
    <div class="mobile-promotion">
        <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
    </div>
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href="/"><img src="/assets/imgs/theme/logo.svg" alt="logo"/></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="#">
                            <select class="select-active">
                                <option>All Categories</option>
                                @foreach($categories as $category)
                                    <option>{{$category['name']}}</option>
                                @endforeach
                            </select>
                            <input type="text" placeholder="Search for items..."/>
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="search-location">
                                <form action="#">
                                    <select class="select-active">
                                        <option>Your Location</option>
                                        <option>Alabama</option>
                                        <option>Alaska</option>
                                        <option>Arizona</option>
                                        <option>Delaware</option>
                                        <option>Florida</option>
                                        <option>Georgia</option>
                                        <option>Hawaii</option>
                                        <option>Indiana</option>
                                        <option>Maryland</option>
                                        <option>Nevada</option>
                                        <option>New Jersey</option>
                                        <option>New Mexico</option>
                                        <option>New York</option>
                                    </select>
                                </form>
                            </div>
                            @if(auth()->user())
                                @php
                                    $authUser = auth()->user()->load(['wishlist','cart']);
                                    $wishlistPopUp = $authUser->wishlist;
                                    $cartPopUp = $authUser->cart;
                                    $cartPopUpSubTotal = 0;
                                @endphp
                            @endif

                            <div class="header-action-icon-2">
                                <a href="/wishlist">
                                    <img class="svgInject" alt="Nest" src="/assets/imgs/theme/icons/icon-heart.svg"/>
                                    @if (auth()->user() && $wishlistPopUp && count(json_decode($wishlistPopUp->items, true)) > 0)
                                        <span class="pro-count blue">{{ count(json_decode($wishlistPopUp->items, true)) }}</span>
                                    @endif
                                </a>
                                <a href="/wishlist"><span class="lable">Wishlist</span></a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="/cart">
                                    <img alt="Nest" src="/assets/imgs/theme/icons/icon-cart.svg"/>
                                    @if(auth()->user() && $cartPopUp && count(json_decode($cartPopUp->items, true)) > 0)
                                        <span class="pro-count blue">{{ count(json_decode($cartPopUp->items, true)) }}</span>
                                    @endif
                                </a>
                                <a href="/cart"><span class="lable">Cart</span></a>
                                @if(auth()->user())
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        @if($cartPopUp)
                                        <ul>
                                            @foreach(json_decode($cartPopUp->items, true) as $i => $cartPopUpItem)
                                                @php $cartPopUpSubTotal += ($cartPopUpItem['price'] * $cartPopUpItem['quantity']) @endphp
                                                @if($i < 2)
                                                    <li>
                                                        <div class="shopping-cart-img">
                                                            <a href="/{{ $cartPopUpItem['slug'] }}"><img alt="Nest"
                                                                                                   src="{{ $cartPopUpItem['image'] }}"/></a>
                                                        </div>
                                                        <div class="shopping-cart-title">
                                                            <h4><a href="/{{ $cartPopUpItem['slug'] }}">{{ $cartPopUpItem['name'] }}</a></h4>
                                                            <h4><span>{{ $cartPopUpItem['quantity'] }} × </span>Rp. {{ number_format($cartPopUpItem['price']) }}</h4>
                                                        </div>
                                                        <div class="shopping-cart-delete">
                                                            <form id="delete-cart-pop-up-{{ $cartPopUpItem['id'] }}" style="display: none" action="/cart/{{ $cartPopUpItem['id'] }}" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                            </form>
                                                            <a href="#" onclick="document.getElementById('delete-cart-pop-up-{{ $cartPopUpItem['id'] }}').submit()"><i class="fi-rs-cross-small"></i></a>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach

                                            @if (count(json_decode($cartPopUp->items, true)) > 2)
                                                <li><a href="/cart">And {{ count(json_decode($cartPopUp->items, true)) - 2 }} more</a></li>
                                            @endif
                                        </ul>
                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                                <h4>Total <span>Rp. {{ number_format($cartPopUpSubTotal) }}</span></h4>
                                            </div>
                                            <div class="shopping-cart-button">
                                                <a href="/cart" class="outline">View cart</a>
                                                <a href="/cart">Checkout</a>
                                            </div>
                                        </div>
                                        @else
                                            <p>No Data</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="header-action-icon-2">
                                <a href="/me">
                                    <img class="svgInject" alt="Nest" src="/assets/imgs/theme/icons/icon-user.svg"/>
                                </a>
                                <a href="/me"><span class="lable ml-0">Account</span></a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                    <ul>
                                        <li><a href="/me"><i class="fi fi-rs-user mr-10"></i>My
                                                Account</a></li>
                                        <li><a href="/me/orders"><i class="fi fi-rs-location-alt mr-10"></i>Order
                                                Tracking</a></li>
                                        <li><a href="/me/vouchers"><i class="fi fi-rs-label mr-10"></i>My
                                                Voucher</a></li>
                                        <li><a href="/me/wishlist"><i class="fi fi-rs-heart mr-10"></i>My Wishlist</a>
                                        </li>
                                        <li><a href="/me/setting"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                        </li>
                                        @if(auth()->user())
                                            <li><a href="#" onclick="document.getElementById('form-logout').submit();"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @if(auth()->user())
                                    <form style="display: none" id="form-logout" action="/logout" method="POST">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="/"><img src="/assets/imgs/theme/logo.svg" alt="logo"/></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categories-button-active" href="#">
                            <span class="fi-rs-apps"></span> <span class="et">Browse</span> All Categories
                            <i class="fi-rs-angle-down"></i>
                        </a>
                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="d-flex categori-dropdown-inner">
                                <ul>
                                    @foreach ($categories->take(5) as $category)
                                        <li>
                                            <a href="shop-grid-right.html">
                                                <img src="{{ $category->icon->getFullUrl() }}" alt=""/>
                                                {{ $category['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <ul class="end">
                                    @foreach ($categories->slice(5, 5) as $category)
                                        <li>
                                            <a href="shop-grid-right.html">
                                                <img src="{{ $category->icon->getFullUrl() }}" alt=""/>
                                                {{ $category['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>
                                <li class="hot-deals"><img src="/assets/imgs/theme/icons/icon-hot.svg" alt="hot deals"/><a
                                        href="#">Deals</a></li>
                                <li>
                                    <a href="/">Home</a>
                                </li>
                                <li>
                                    <a href="/products">Products</a>
                                </li>
                                <li>
                                    <a href="#">Shop</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="hotline d-none d-lg-flex">
                    <img src="/assets/imgs/theme/icons/icon-headphone.svg" alt="hotline"/>
                    <p>1900 - 888<span>24/7 Support Center</span></p>
                </div>
                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2">
                            <a href="shop-wishlist.html">
                                <img alt="Nest" src="/assets/imgs/theme/icons/icon-heart.svg"/>
                                <span class="pro-count white">4</span>
                            </a>
                        </div>
                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="shop-cart.html">
                                <img alt="Nest" src="/assets/imgs/theme/icons/icon-cart.svg"/>
                                <span class="pro-count white">2</span>
                            </a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                <ul>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Nest"
                                                                                   src="/assets/imgs/shop/thumbnail-3.jpg"/></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">Plain Striola Shirts</a></h4>
                                            <h3><span>1 × </span>$800.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="shop-product-right.html"><img alt="Nest"
                                                                                   src="/assets/imgs/shop/thumbnail-4.jpg"/></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="shop-product-right.html">Macbook Pro 2024</a></h4>
                                            <h3><span>1 × </span>$3500.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span>$383.00</span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="shop-cart.html">View cart</a>
                                        <a href="shop-checkout.html">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
