<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="/"><img src="/assets/imgs/theme/logo.png" alt="logo" /></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Search for items…" value="{{ request('search') }}" />
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href="/">Home</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="/products">Product</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="/shops">Shop</a>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    @if(auth()->user() && auth()->user()->primary_address)
                        <a href="/me?page=address">
                            <i class="fi-rs-marker"></i>
                            {{ auth()->user()->primary_address['subdistrict'] ?? 'Your Location' }}, {{ auth()->user()->primary_address['city'] ?? '' }}, {{ auth()->user()->primary_address['state'] ?? '' }}
                        </a>
                    @else
                        <a href="{{ auth()->user() ? '/me?page=address' : route('login') }}">
                            <i class="fi-rs-marker"></i>
                            {{ auth()->user() ? 'Set Your Location' : 'Login to set location' }}
                        </a>
                    @endif
                </div>
                <div class="single-mobile-header-info">
                    @if(auth()->user())
                        <a href="{{ route('account') }}"><i class="fi-rs-user"></i>{{ auth()->user()->name }}</a>
                    @else
                        <a href="{{ route('login') }}"><i class="fi-rs-user"></i>Log In / Sign Up</a>
                    @endif
                </div>
                <div class="single-mobile-header-info">
                    <a href="#"><i class="fi-rs-headphones"></i>0333-8917529</a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="#"><img src="/assets/imgs/theme/icons/icon-facebook-white.svg" alt="" /></a>
                <a href="#"><img src="/assets/imgs/theme/icons/icon-twitter-white.svg" alt="" /></a>
                <a href="#"><img src="/assets/imgs/theme/icons/icon-instagram-white.svg" alt="" /></a>
                <a href="#"><img src="/assets/imgs/theme/icons/icon-pinterest-white.svg" alt="" /></a>
                <a href="#"><img src="/assets/imgs/theme/icons/icon-youtube-white.svg" alt="" /></a>
            </div>
            <div class="site-copyright">Copyright 2025 © Pasar Santri. All rights reserved.</div>
        </div>
    </div>
</div>
