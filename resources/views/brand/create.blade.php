@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت برند ها','route'=>route('category.index')],
            ['title'=>'افزودن برند جدید','route'=>route('category.create')],
            ]])

    <div class="panel">

        <div class="header">افزودن برند جدید</div>

        <div class="panel_content">
            {!! Form::open(['url' => route('brand.store'),'files'=>true]) !!}

            <div class="mb-3 form-group">
                {{ Form::label('name','نام برند :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('name',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('name'))
                    <span class="has_errors">{{$errors->first('name')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('ename','نام لاتین برند:',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('ename',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('ename'))
                    <span class="has_errors">{{$errors->first('ename')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('description','توضیحات:',['class'=>'form-label form-label-admin'])}}
                {{ Form::textarea('description',null,['class'=>'form-control form-control-admin textarea_description'])}}
                @if($errors->has('description'))
                    <span class="has_errors">{{$errors->first('description')}}</span>
                @endif
            </div>


            <div class="mb-3 form-group">
                <input type="file" name="image" id="image" style="display: none;" onchange="loadFile(event)">
                {{ Form::label('image','تصویر برند :',['class'=>'form-label form-label-admin'])}}
                <img src="/files/images/pic_1.png" alt="select image" onclick="select_file()" id="output_image" width="150px">
                @if($errors->has('image'))
                    <span class="has_errors">{{$errors->first('image')}}</span>
                @endif
            </div>


            <button class="btn btn-success">ثبت برند</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
