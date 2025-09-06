@extends('layouts.landing.component.app')

@section('content')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 pr-30 d-none d-lg-block">
                                <img class="border-radius-15" src="{{ \App\Models\GlobalVariable::where('key', 'banner_promotion_login')->first()['value'] ?? null }}" alt="" />
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-5">Login</h1>
                                            <p class="mb-30">Don't have an account? <a href="/register">Create here</a></p>
                                        </div>
                                        <form method="post" action="/login">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" required="" name="email" placeholder="Email *" />
                                            </div>
                                            <div class="form-group">
                                                <input required="" type="password" name="password" placeholder="Your password *" />
                                            </div>
                                            <div class="login_footer form-group">
                                                <div class="chek-form">
                                                    <input type="text" required="" name="code" placeholder="Security code *" />
                                                </div>
                                                <span class="security-code">
                                                    @php $color = ['new','hot','sale','best']; $captchaKey = '' @endphp
                                                    @for($i = 0; $i < 4; $i++)
                                                        @php $key = rand(0,9); $captchaKey .= $key @endphp
                                                        <b class="text-{{ $color[rand(0,3)] }}">{{ $key }}</b>
                                                    @endfor
                                                </span>
                                            </div>
                                            <input type="hidden" name="captcha_token" value="{{ \Illuminate\Support\Facades\Hash::make($captchaKey) }}">
                                            <div class="login_footer form-group mb-50">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="" />
                                                        <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                                    </div>
                                                </div>
                                                <a class="text-muted" href="#">Forgot password?</a>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up">Log in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
