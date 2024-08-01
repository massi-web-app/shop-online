@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت اسلایدر ها','route'=>route('sliders.index')],
            ['title'=>'افزودن اسلایدر جدید','route'=>route('sliders.create')],
            ]])

    <div class="panel">

        <div class="header">افزودن اسلایدر جدید</div>

        <div class="panel_content">
            {!! Form::open(['url' => route('sliders.store'),'files'=>true]) !!}

            <div class="mb-3 form-group">
                {{ Form::label('title','عنوان :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('title',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('title'))
                    <span class="has_errors">{{$errors->first('title')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('url','آدرس (url):',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('url',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('url'))
                    <span class="has_errors">{{$errors->first('url')}}</span>
                @endif
            </div>



            <div class="mb-3 form-group">
                <input type="file" name="image_url" id="image" style="display: none;" onchange="loadFile(event)">
                {{ Form::label('image','تصویر اسلایدر :',['class'=>'form-label form-label-admin'])}}
                <img src="/files/images/pic_1.png" alt="select image" onclick="select_file()" id="output_image" width="150px" class="slider_img">
                @if($errors->has('image_url'))
                    <span class="has_errors">{{$errors->first('image_url')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                <input type="file" name="mobile_image_url" id="mobile_image_url" style="display: none;" onchange="loadFile2(event)">
                {{ Form::label('image','انتخاب تصویر اسلایدر برای موبایل :',['class'=>'form-label form-label-admin'])}}
                <img src="/files/images/pic_1.png" alt="select mobile_image_url" onclick="select_file2()" id="output_image2" width="150px" class="slider_img">
                @if($errors->has('mobile_image_url'))
                    <span class="has_errors">{{$errors->first('mobile_image_url')}}</span>
                @endif
            </div>



            <button class="btn btn-success">ثبت اسلایدر</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
