@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت اسلایدر ها','route'=>route('sliders.index')],
            ['title'=>'ویرایش اسلایدر','route'=>route('sliders.edit',$slider->id)],
            ]])

    <div class="panel">

        <div class="header">
            ویرایش اسلایدر - {{$slider->title}}
        </div>

        <div class="panel_content">
            {!! Form::model($slider,['url' => route('sliders.update',$slider->id),'files'=>true]) !!}

            {{method_field('put')}}
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

                <img src="{{asset('files/slider/'.$slider->image_url)}}" alt="select image" onclick="select_file()" id="output_image" width="150px" class="slider_img">
                @if($errors->has('image_url'))
                    <span class="has_errors">{{$errors->first('image_url')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                <input type="file" name="mobile_image_url" id="mobile_image_url" style="display: none;" onchange="loadFile2(event)">
                {{ Form::label('image','انتخاب تصویر اسلایدر برای موبایل :',['class'=>'form-label form-label-admin'])}}
                <img @if($slider->mobile_image_url) src="{{asset('files/slider/'.$slider->mobile_image_url)}}" @endif
                alt="select mobile_image_url" onclick="select_file2()" id="output_image2" width="150px" class="slider_img">
                @if($errors->has('mobile_image_url'))
                    <span class="has_errors">{{$errors->first('mobile_image_url')}}</span>
                @endif
            </div>



            <button class="btn btn-info">ویرایش اسلایدر</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
