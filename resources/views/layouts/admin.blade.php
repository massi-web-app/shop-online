<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>پنل مدیریت</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/css/admin.css')}}">

</head>
<body>

<div class="container-fluid">
    <div class="page_sidebar">

        <span class="fa fa-bars" id="sidebarToggle"></span>
        <ul id="sidebar_menu">
            <li>
                <a href="#">
                    <span class="fa fa-shopping-cart"></span>
                    <span class="sidebar_menu_text">محصولات</span>
                    <span class="fa fa-angle-left"></span>
                </a>
                <div class="child_menu">
                    <a href="">مدیریت محصولات</a>
                    <a href="">افزودن محصول</a>
                    <a href="">مدیریت دسته ها</a>
                </div>
            </li>

            <li>
                <a href="#">
                    <span class="fa fa-sliders"></span>
                    <span class="sidebar_menu_text">مدیریت اسلایدرها</span>
                    <span class="fa fa-angle-left"></span>
                </a>
                <div class="child_menu">
                    <a href="">مدیریت اسلایدرها</a>
                    <a href="">افزودن اسلایدر جدید</a>
                </div>
            </li>


        </ul>
    </div>
    <div class="page_content">
        <div class="content_box" id="app">
            @yield('content')
        </div>
    </div>
</div>


<div class="message_div">
    <div class="message_box">
        <p id="msg"></p>
        <a class="alert alert-success" onclick="confirm_operation()">بلی</a>
        <a class="alert alert-danger" onclick="cancel_operation()">خیر</a>
    </div>
</div>


<script src="{{asset('js/font-awesome.js')}}"></script>
<script src="{{asset('/js/jquery-3.2.1.slim.min.js')}}"></script>
<script src="{{asset('/js/app.js')}}"></script>
<script src="{{asset('/js/admin.js')}}"></script>
</body>
</html>
