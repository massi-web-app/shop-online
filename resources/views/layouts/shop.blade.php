<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> فروشگاه اینترنتی</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/shop.css')}}">
    @yield('css')
</head>
<body>

<div class="app">

    <header class="header">
        <a href="/">
            <img src="{{asset('/files/images/digikala.svg')}}" class="shop_logo" alt="shop-online">
        </a>
        <div class="header_row">
            <div class="input-group index_header_search">
                <input type="text" class="form-control"
                       placeholder="نام کالا، برند ویا دسته مورد نظر خودرا جستجو کنید..."
                       aria-describedby="basic-addon1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="fa fa-search"></span>
                    </span>
                </div>
            </div>

            <div class="header_action">
                <div class="dropdown">

                    <div class="index_auth_div" role="button" data-toggle="dropdown">
                        <span>
                            ورود / ثبت نام
                        </span>
                        <span class="fa fa-angle-down"></span>
                    </div>
                    <div class="dropdown-menu header-auth-box" aria-labelledby="dropdownMenuButton">
                        @if(auth()->check())
                            <a class="dropdown-item admin" href="/">
                                پنل مدیریت
                            </a>
                        @else

                            <a class="btn btn-primary" href="{{route('login')}}">
                                ورود به دیجی کالا
                            </a>
                            <div class="register-link">
                                <span>کاربر جدید هستید ؟</span>
                                <a href="/register" class="link">ثبت نام</a>
                            </div>
                            <div class="dropdown-divider"></div>

                        @endif

                        <a href="#" class="dropdown-item profile ">
                            پروفایل
                        </a>
                        <a href="#" class="dropdown-item orders">پیگیری سفارشات
                        </a>
                        @if(auth()->check())
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item logout">
                                خروج از حساب کاربری
                            </a>
                        @endif
                    </div>
                </div>

                <div class="header_divider"></div>

                <div class="cart-header-box">
                    <div class="bt-cart">
                         <span id="cart-product-count" data-counter="10">سبد خرید شما</span>
                    </div>
                </div>
            </div>

        </div>
    </header>
</div>

<script src="{{asset('/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('/js/font-awesome.js')}}"></script>
<script src="{{asset('/js/popper.min.js')}}"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/app.js')}}"></script>

@yield('script')
</body>
</html>
