<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', env('APP_NAME') . ' - Your Trusted Marketplace')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="@yield('description', 'Discover quality products from trusted sellers in our marketplace. Shop with confidence and enjoy great deals on electronics, fashion, home & garden, and more.')" />
    <meta name="keywords" content="@yield('keywords', 'marketplace, online shopping, electronics, fashion, home garden, deals, trusted sellers')" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="@yield('robots', 'index, follow')" />
    <link rel="canonical" href="@yield('canonical', request()->url())" />
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', env('APP_NAME') . ' - Your Trusted Marketplace')" />
    <meta property="og:description" content="@yield('og_description', 'Discover quality products from trusted sellers in our marketplace. Shop with confidence and enjoy great deals on electronics, fashion, home & garden, and more.')" />
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:url" content="@yield('og_url', request()->url())" />
    <meta property="og:image" content="@yield('og_image', asset('/assets/imgs/theme/logo.png'))" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:locale" content="en_US" />
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')" />
    <meta name="twitter:title" content="@yield('twitter_title', env('APP_NAME') . ' - Your Trusted Marketplace')" />
    <meta name="twitter:description" content="@yield('twitter_description', 'Discover quality products from trusted sellers in our marketplace. Shop with confidence and enjoy great deals on electronics, fashion, home & garden, and more.')" />
    <meta name="twitter:image" content="@yield('twitter_image', asset('/assets/imgs/theme/logo.png'))" />
    
    <!-- Product Schema (for product pages) -->
    @stack('schema')
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/imgs/theme/favicon.svg" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="/assets/css/main.css?v=6.0" />
    <link rel="stylesheet" href="/assets/toastr/toastr.min.css"/>
    @stack('head')
</head>

<body>
    @yield('modal')

    @include('layouts.landing.component.header-web')
    @include('layouts.landing.component.header-mobile')

    @yield('content')

    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="/assets/imgs/theme/loading.gif" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    <script src="/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="/assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="/assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/plugins/slick.js"></script>
    <script src="/assets/js/plugins/jquery.syotimer.min.js"></script>
    <script src="/assets/js/plugins/wow.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.js"></script>
    <script src="/assets/js/plugins/magnific-popup.js"></script>
    <script src="/assets/js/plugins/select2.min.js"></script>
    <script src="/assets/js/plugins/waypoints.js"></script>
    <script src="/assets/js/plugins/counterup.js"></script>
    <script src="/assets/js/plugins/jquery.countdown.min.js"></script>
    <script src="/assets/js/plugins/images-loaded.js"></script>
    <script src="/assets/js/plugins/isotope.js"></script>
    <script src="/assets/js/plugins/scrollup.js"></script>
    <script src="/assets/js/plugins/jquery.vticker-min.js"></script>
    <script src="/assets/js/plugins/jquery.theia.sticky.js"></script>
    <script src="/assets/js/plugins/jquery.elevatezoom.js"></script>
    <script src="/assets/js/plugins/slider-range.js"></script>
    <!-- Template  JS -->
    <script src="/assets/js/main.js?v=6.0"></script>
    <script src="/assets/js/shop.js?v=6.0"></script>
    <script src="/assets/toastr/toastr.min.js"></script>
    <script>
        toastr.options = {
            "debug": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "preventDuplicates": true,
        }
    </script>
    @include('layouts.landing.component.toastr')
    
    <!-- Location Selector Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationSelector = document.getElementById('location-selector');
            
            if (locationSelector) {
                locationSelector.addEventListener('change', function() {
                    const selectedValue = this.value;
                    
                    if (selectedValue === 'manage') {
                        // Redirect to address management page
                        window.location.href = '{{ route("addresses.index") }}';
                    } else if (selectedValue === 'login') {
                        // Redirect to login page
                        window.location.href = '{{ route("login") }}';
                    } else if (selectedValue && selectedValue !== '') {
                        // Set as primary address via AJAX
                        @auth
                        fetch('{{ route("addresses.setPrimary") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ address_id: selectedValue })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                toastr.success('Location updated successfully!');
                                // Optionally reload the page to update UI
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                toastr.error(data.error || 'Failed to update location');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('An error occurred while updating location');
                        });
                        @endauth
                    }
                });
            }
        });
    </script>
    
    @stack('script')
</body>

</html>
