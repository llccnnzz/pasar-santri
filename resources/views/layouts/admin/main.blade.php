<!doctype html>
<html lang="zxx">
<head>
    <!--=== Required meta tags ===-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--=== CSS Link ===-->
    <link rel="stylesheet" href="/admin-assets/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/remixicon.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/font-awesome-pro.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/metisMenu.min.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/simplebar.min.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/prism.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/admin-assets/assets/css/style.css">

    <!--=== Favicon ===-->
    <link rel="icon" type="image/png" href="/admin-assets/assets/images/favicon.png">
    <!--=== Title ===-->
    @stack('head')
    <title>Admin Dashboard - at Pasar Santri</title>
</head>

<body>
<!--=== Start Preloader Section ===-->
<div class="preloader">
    <div class="content">
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
    </div>
</div>
<!--=== End Preloader Section ===-->

<!--=== Start Sidebar Menu Area ===-->
<div class="sidebar-menu-area" id="metismenu" data-simplebar>
    <div class="d-flex justify-content-between align-items-center border-bottom border-color bg-white position-sticky top-0 z-1 main-logo-wrap">
        <a href="index.html" class="main-logo d-flex align-items-center text-decoration-none">
            <img class="logo" src="/admin-assets/assets/images/logo.png" style="height: 80px; width: auto" alt="logo">
        </a>
        <div class="responsive-burger-menu d-block d-xl-none">
            <span class="top-bar"></span>
            <span class="middle-bar"></span>
            <span class="bottom-bar"></span>
        </div>
    </div>
    <ul class="sidebar-menu o-sortable">
        <li><span class="cat">MAIN</span></li>

        <!-- Dashboard -->
        <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-title">
                <span class="icon"><i data-feather="grid"></i></span>
                <span class="title">Dashboard</span>
            </a>
        </li>

        <li><span class="cat">USER MANAGEMENT</span></li>

        <!-- Sellers -->
        <li class="{{ request()->routeIs('admin.sellers.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.sellers.index') }}" class="menu-title">
                <span class="icon"><i data-feather="users"></i></span>
                <span class="title">Sellers</span>
            </a>
        </li>

        <!-- Customers (commented out) -->
        {{--
        <li class="{{ request()->routeIs('admin.customers.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.customers.index') }}" class="menu-title">
                <span class="icon"><i data-feather="user"></i></span>
                <span class="title">Customers</span>
            </a>
        </li>
        --}}

        <!-- KYC Applications -->
        <li class="{{ request()->routeIs('admin.kyc.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.kyc.index') }}" class="menu-title">
                <span class="icon"><i data-feather="user-check"></i></span>
                <span class="title">KYC Applications</span>
                @if(($pendingKycCount ?? 0) > 0)
                    <span class="badge bg-primary ms-2">{{ $pendingKycCount }}</span>
                @endif
            </a>
        </li>

        <li><span class="cat">PRODUCT MANAGEMENT</span></li>

        <!-- Products -->
        <li class="{{ request()->routeIs('admin.products.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.products.index') }}" class="menu-title">
                <span class="icon"><i data-feather="package"></i></span>
                <span class="title">Products</span>
            </a>
        </li>

        <!-- Product Ads -->
        <li class="{{ request()->routeIs('admin.ads.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.ads.index') }}" class="menu-title">
                <span class="icon"><i data-feather="trending-up"></i></span>
                <span class="title">Product Ads</span>
            </a>
        </li>

        <li><span class="cat">ORDER MANAGEMENT</span></li>

        <!-- Orders -->
        <li class="{{ request()->routeIs('admin.orders.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.orders.index') }}" class="menu-title">
                <span class="icon"><i data-feather="shopping-cart"></i></span>
                <span class="title">Orders</span>
            </a>
        </li>

        <!-- Shipping -->
        <li class="{{ request()->routeIs('admin.shipping.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.shipping.index') }}" class="menu-title">
                <span class="icon"><i data-feather="truck"></i></span>
                <span class="title">Shipping Methods</span>
            </a>
        </li>

        <li><span class="cat">MARKETING</span></li>

        <!-- Banners -->
        <li class="{{ request()->routeIs('admin.banners.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.banners.index') }}" class="menu-title">
                <span class="icon"><i data-feather="image"></i></span>
                <span class="title">Banners</span>
            </a>
        </li>

        <!-- Promotions -->
        <li class="{{ request()->routeIs('admin.promos.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.promos.index') }}" class="menu-title">
                <span class="icon"><i data-feather="percent"></i></span>
                <span class="title">Promotions</span>
            </a>
        </li>

        <li><span class="cat">FINANCIAL</span></li>

        <!-- Service Fees -->
        <li class="{{ request()->routeIs('admin.service-fees.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.service-fees.index') }}" class="menu-title">
                <span class="icon"><i data-feather="dollar-sign"></i></span>
                <span class="title">Service Fees</span>
            </a>
        </li>

        <li><span class="cat">SYSTEM</span></li>

        <!-- Settings -->
        <li class="{{ request()->routeIs('admin.settings.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.settings.index') }}" class="menu-title">
                <span class="icon"><i data-feather="settings"></i></span>
                <span class="title">Settings</span>
            </a>
        </li>

        <!-- Reports -->
        <li class="{{ request()->routeIs('admin.analytics.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.analytics.dashboard') }}" class="menu-title">
                <span class="icon"><i data-feather="bar-chart-2"></i></span>
                <span class="title">Reports</span>
            </a>
        </li>
    </ul>
</div>
<!--=== End Sidebar Menu Area ===-->

<!--=== Start Main Content Area ===-->
<div class="main-content-area">
    <div class="container-fluid">
        <!--=== Start Header Area ===-->
        <header class="header-area bg-white mb-24">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="header-left-content">
                        <ul class="list-unstyled ps-0 mb-0 d-flex justify-content-center justify-content-lg-start justify-content-md-start align-items-center">
                            <li>
                                <div class="burger-menu d-none d-lg-block">
                                    <span class="top-bar"></span>
                                    <span class="middle-bar"></span>
                                    <span class="bottom-bar"></span>
                                </div>
                                <div class="responsive-burger-menu d-block d-lg-none">
                                    <span class="top-bar"></span>
                                    <span class="middle-bar"></span>
                                    <span class="bottom-bar"></span>
                                </div>
                            </li>
                            <li>
                                <form class="src-form position-relative z-1">
                                    <input type="text" class="form-control" placeholder="Search Here">
                                    <button class="bg-transparent position-absolute position-absolute top-50 end-0 translate-middle border-0 ps-0 pe-1">
                                        <i data-feather="search"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="header-right-content float-lg-end float-md-end">
                        <ul class="list-unstyled ps-0 mb-0 d-flex justify-content-center justify-content-lg-end justify-content-md-end align-items-center">


                            <li class="ms-lg-4 ms-md-4 ms-2">
                                <div class="dropdown mail">
                                    <button class="btn btn-secondary fullscreen-btn border-0 p-0 position-relative" id="fullscreen-button">
												<span class="maximize">
													<i data-feather="maximize"></i>
												</span>
                                        <span class="minimize top-50 start-50 translate-middle position-absolute">
													<i data-feather="minimize"></i>
												</span>
                                    </button>
                                </div>
                            </li>

                            <li class="ms-lg-4 ms-md-4 ms-2">
                                <div class="dropdown mail apps">
                                    <button class="btn btn-secondary border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i data-feather="grid"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-lg p-0 border-0 box-shadow">
                                        <h6 class="dropdown-item-text fs-15 fw-semibold m-0 py-3 border-bottom border-color d-flex justify-content-between align-items-center">
                                            Apps
                                            <span class="text-white bg-danger fs-12 py-1 px-1 rounded-1 fw-normal">12</span>
                                        </h6>

                                        <div class="h-255" data-simplebar>
                                            <div class="apps-menu d-flex flex-wrap align-items-center justify-content-center">
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/gmail.png" alt="gmail">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Gmail</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/playstore.png" alt="playstore">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Play Store</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/drive.png" alt="drive">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Drive</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/account.png" alt="account">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Account</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/calender.png" alt="calender">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Calender</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/figma.png" alt="figma">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Figma</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/google-sheets.png" alt="google-sheets">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Sheets</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/google.png" alt="google">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Google</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/microsoft-word.png" alt="microsoft-word">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Microsoft</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/powerpoint.png" alt="powerpoint">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Powerpoint</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/sketch.png" alt="sketch">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Sketch</span>
                                                </a>
                                                <a href="javascript:;" class="dropdown-item m-2 border-1">
                                                    <img src="/admin-assets/assets/images/apps/translate.png" alt="translate">
                                                    <span class="d-block fs-14 fw-medium text-dark mt-2">Translate</span>
                                                </a>
                                            </div>
                                        </div>
                                        <a href="javascript:;" class="dropdown-item text-center text-white border-top border-color py-2 d-block bg-primary rounded-bottom z-1 position-relative fs-15">
                                            View all
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="ms-lg-4 ms-md-4 ms-2">
                                <div class="dropdown notifications">
                                    <button class="btn btn-secondary border-0 p-0 position-relative badge" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i data-feather="bell"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-lg p-0 border-0 box-shadow">
                                        <h6 class="dropdown-item-text fs-15 fw-semibold m-0 py-3 border-bottom border-color d-flex justify-content-between align-items-center">
                                            Notifications
                                            <span class="text-white bg-danger fs-12 py-1 px-1 rounded-1 fw-normal">08</span>
                                        </h6>

                                        <div class="notification-menu h-400" data-simplebar>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">6 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="check-circle"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Order Placed <span class="text-success">ID: #1116773</span></h6>
                                                        <small class="mb-0 text-body fs-12">Order Placed Successfully</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">8 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="clock"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Order Delayed <span class="text-danger">ID: 7731116</span></h6>
                                                        <small class="mb-0 text-body fs-12">Order Delayed Unfortunately</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">1 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="shopping-bag"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Your Order Has Been Shipped</h6>
                                                        <small class="mb-0 text-body fs-12">Order No: 123456 Has Shipped To Your Delivery Address</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">3 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="percent"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Discount Available</h6>
                                                        <small class="mb-0 text-body fs-12">Discount Available On Selected Products</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">4 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="user-check"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Account Has Been Verified</h6>
                                                        <small class="mb-0 text-body fs-12">Your Account Has Been Verified Sucessfully</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">6 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="check-circle"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Order Placed <span class="text-success">ID: #1116773</span></h6>
                                                        <small class="mb-0 text-body fs-12">Order Placed Successfully</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">8 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="clock"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Order Delayed <span class="text-danger">ID: 7731116</span></h6>
                                                        <small class="mb-0 text-body fs-12">Order Delayed Unfortunately</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">1 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="shopping-bag"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Your Order Has Been Shipped</h6>
                                                        <small class="mb-0 text-body fs-12">Order No: 123456 Has Shipped To Your Delivery Address</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">3 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="percent"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Discount Available</h6>
                                                        <small class="mb-0 text-body fs-12">Discount Available On Selected Products</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="notifications.html" class="dropdown-item py-3">
                                                <small class="float-end ps-2 text-body fs-12">4 min ago</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md rounded-circle text-center flex-shrink-0">
                                                        <i data-feather="user-check"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fs-14 fw-medium">Account Has Been Verified</h6>
                                                        <small class="mb-0 text-body fs-12">Your Account Has Been Verified Sucessfully</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="notification.html" class="dropdown-item text-center text-white border-top border-color pt-2 pb-2 d-block bg-primary rounded-bottom fs-15">
                                            View all
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="ms-lg-4 ms-md-4 ms-2">
                                <div class="dropdown user-profile">
                                    <div class="btn border-0 p-0 d-flex align-items-center text-start" data-bs-toggle="dropdown">
                                        <div class="flex-shrink-0">
                                            <img class="rounded-circle user" src="/admin-assets/assets/images/user/user.png" alt="user">
                                        </div>
                                        <div class="flex-grow-1 ms-2 d-none d-xxl-block">
                                            <h3 class="fs-14 mb-0">{{ auth()->user()->name }}</h3>
                                            <span class="fs-13 text-body">{{ auth()->user()->shop->name ?? 'Unknown' }}</span>
                                        </div>
                                    </div>
                                    <ul class="dropdown-menu border-0 rounded box-shadow">
                                        <li>
                                            <div class=" text-center border-bottom border-color pb-10 mb-10 d-xxl-none">
                                                <h3 class="fs-14 mb-0">{{ auth()->user()->name }}</h3>
                                                <span class="fs-13 text-body">{{ auth()->user()->role ?? 'Unknown' }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center text-body" href="/seller/profile">
                                                <i data-feather="user"></i>
                                                <span class="ms-2 fs-14">Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center text-body" href="#" onclick="document.getElementById('form-logout').submit();">
                                                <i data-feather="log-out"></i>
                                                <span class="ms-2 fs-14">Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!--=== End Header Area ===-->
        @if(auth()->user())
            <form style="display: none" id="form-logout" action="/logout" method="POST">
                @csrf
            </form>
        @endif

        @yield('content')
    </div>

    <div class="flex-grow-1"></div>

    <!--=== Start CopyRight Area ===-->
    <div class="footer-area bg-white">
        <div class="footer-content text-center p-4">
            <p>Copyright © <span class="fw-medium text-primary">Pasar Santri</span> {{ now()->format('Y') }}</p>
        </div>
    </div>
    <!--=== End CopyRight Area ===-->
</div>
<!--=== End Main Content Area ===-->

<!--=== Start Theme Setting Area ===-->
<button class="setting-btn position-fixed bottom-0 end-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
    <i data-feather="settings"></i>
</button>

<div class="offcanvas offcanvas-end them-setting-content border-0" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header switcher-head">
        <h5 class="offcanvas-title fs-16" id="offcanvasScrollingLabel">Theme System</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="ps-0 mb-0 list-unstyled option-list">
            <li>
                <a href="https://croptheme.com/tm/dess/dess-rtl/" class="btn btn-primary w-100 d-block">RTL</a>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Theme Light And Dark</h4>
                <button class="option-btn dark-light-btn active">
                    <span class="dark-themes">Light</span>
                    <span class="light-theme">Dark</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Header Light And Dark</h4>
                <button class="option-btn header-dark-light-btn active">
                    <span class="dark-themes">Light</span>
                    <span class="light-theme">Dark</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Sidebar Light And Dark</h4>
                <button class="option-btn sidebar-dark-light-btn active">
                    <span class="dark-themes">Light</span>
                    <span class="light-theme">Dark</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Sidebar Default Color And Theme Color</h4>
                <button class="option-btn sidebar-theme-color-btn active">
                    <span class="dark-themes">Default Color</span>
                    <span class="light-theme">Theme Color</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Footer Light And Dark</h4>
                <button class="option-btn footer-dark-light-btn active">
                    <span class="dark-themes">Light</span>
                    <span class="light-theme">Dark</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Card Style Radius And Square</h4>
                <button class="option-btn card-style-btn active">
                    <span class="dark-themes">Radius</span>
                    <span class="light-theme">Square</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Card Style Without Border And Border</h4>
                <button class="option-btn card-style-border-btn active">
                    <span class="dark-themes">Without Border</span>
                    <span class="light-theme">Border</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Preloader Show And Hide</h4>
                <button class="option-btn preloader-btn active">
                    <span class="dark-themes">Show</span>
                    <span class="light-theme">Hide</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Sidebar Menu Default And Icon</h4>
                <button class="option-btn icon-sidebar-btn active">
                    <span class="dark-themes">Default Sidebar</span>
                    <span class="light-theme">Icon Sidebar</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Header Sticky And Fixed</h4>
                <button class="option-btn header-fixed-sticky-btn active">
                    <span class="dark-themes">Sticky</span>
                    <span class="light-theme">Fixed</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Back To Top Button Show And Hide</h4>
                <button class="option-btn back-top-btn active">
                    <span class="dark-themes">Show</span>
                    <span class="light-theme">Hide</span>
                </button>
            </li>
            <li>
                <h4 class="fs-15 fw-medium">Layout Width Style</h4>
                <button class="option-btn layout-width-btn active">
                    <span class="dark-themes">Full Width</span>
                    <span class="light-theme">Boxed</span>
                </button>
            </li>
        </ul>
    </div>
</div>
<!--=== End Theme Setting Area ===-->

<!-- Start Go Top Area -->
<div class="go-top">
    <i class="ri-arrow-up-s-line"></i>
</div>
<!-- End Go Top Area -->

<!--=== JS Link ===-->
<script src="/admin-assets/assets/js/jquery.min.js"></script>
<script src="/admin-assets/assets/js/bootstrap.bundle.min.js"></script>
<script src="/admin-assets/assets/js/owl.carousel.min.js"></script>
<script src="/admin-assets/assets/js/metisMenu.min.js"></script>
<script src="/admin-assets/assets/js/countdown.min.js"></script>
<script src="/admin-assets/assets/js/feather.min.js"></script>
<script src="/admin-assets/assets/js/simplebar.min.js"></script>
<script src="/admin-assets/assets/js/prism.js"></script>
<script src="/admin-assets/assets/js/html5sortable.js"></script>
<script src="/admin-assets/assets/js/members-list.js"></script>
<script src="/admin-assets/assets/js/jquery-ui.min.js"></script>
<script src="/admin-assets/assets/js/jquery.dataTables.js"></script>
<script src="/admin-assets/assets/js/magnific-popup.min.js"></script>
<script src="/admin-assets/assets/js/sweetalert2.all.min.js"></script>
<script src="/admin-assets/assets/js/kanban-board.js"></script>
<!--=== Apex Charts ===-->
<script src="/admin-assets/assets/js/apex/apexcharts.js"></script>
<!--=== Amcharts ===-->
<script src="/admin-assets/assets/js/amcharts/index.js"></script>
<script src="/admin-assets/assets/js/amcharts/map.js"></script>
<script src="/admin-assets/assets/js/amcharts/worldLow.js"></script>
<script src="/admin-assets/assets/js/amcharts/Animated.js"></script>
<script src="/admin-assets/assets/js/apex/ecommerce-chart.js"></script>
<script src="/admin-assets/assets/js/custom.js"></script>

<!-- Flash Messages -->
<script>
@if(session('success'))
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK'
    });
@endif

@if(session('warning'))
    Swal.fire({
        title: 'Warning!',
        text: '{{ session('warning') }}',
        icon: 'warning',
        confirmButtonText: 'OK'
    });
@endif

@if(session('info'))
    Swal.fire({
        title: 'Info',
        text: '{{ session('info') }}',
        icon: 'info',
        confirmButtonText: 'OK'
    });
@endif
</script>

@stack('scripts')
</body>
</html>
