<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>پنل مدیریت</title>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>

<div class="container-fluid">
    <div class="page_sidebar">

        <ul id="sidebar_menu">
            <li>
                <a href="">
                    <span class="fa fa-shopping-cart"></span>
                    <span>محصولات</span>
                    <span class="fa fa-angle-left"></span>
                </a>
                <div class="child_menu">
                    <a href="">مدیریت محصولات</a>
                    <a href="">افزودن محصول</a>
                    <a href="">مدیریت دسته ها</a>
                </div>
            </li>

            <li>
                <a href="">
                    <span class="fa fa-sliders"></span>
                    <span>مدیریت اسلایدرها</span>
                    <span class="fa fa-angle-left"></span>
                </a>
                <div class="child_menu">
                    <a href="">مدیریت اسلایدرها</a>
                    <a href="">افزودن اسلایدر جدید</a>
                </div>
            </li>


        </ul>
    </div>
    <div class="page_content"></div>
</div>


</body>
</html>
