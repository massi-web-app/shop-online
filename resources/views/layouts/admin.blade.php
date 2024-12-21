<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>پنل مدیریت</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap-select.min.css')}}">
    @yield('head')
</head>
<body>

<div class="container-fluid">
    <div class="page_sidebar">
        @include('include.sidebar')
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


<div id="loading_box">
    <div class="loading_div">
        <div class="loading"></div>
        <span>در حال ارسال اطلاعات</span>
    </div>
</div>


<script src="{{asset('/js/font-awesome.js')}}"></script>
<script src="{{asset('/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('/js/app.js')}}"></script>
<script src="{{asset('/js/admin.js')}}"></script>
<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('/js/defaults-fa_IR.js')}}"></script>

<script>
    $('select').selectpicker();
</script>

@yield('js')
</body>
</html>
