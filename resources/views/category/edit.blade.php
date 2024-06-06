@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
        ['title'=>'مدیریت دسته ها','route'=>route('category.index')],
        ['title'=>'ویرایش دسته','route'=>route('category.edit',$category->id)],
        ]])

    <div class="panel">

        <div class="header">
            ویرایش دسته بندی - {{$category->title}}
        </div>

        <div class="panel_content">
            {!! Form::model($category,['url' => route('category.update',$category->id),'files'=>true]) !!}

            {{method_field('PUT')}}
            <div class="mb-3 form-group">
                {{ Form::label('title','نام دسته :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('title',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('title'))
                    <span class="has_errors">{{$errors->first('title')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('ename','نام لاتین :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('ename',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('ename'))
                    <span class="has_errors">{{$errors->first('ename')}}</span>
                @endif
            </div>


            <div class="mb-3 form-group">
                {{ Form::label('search_url','دسته url :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('search_url',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('search_url'))
                    <span class="has_errors">{{$errors->first('search_url')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('parent_id','دسته والد :',['class'=>'form-label form-label-admin'])}}
                {{ Form::select('parent_id',$parent_categories,null,['class'=>'form-label form-label-admin form-select',
'data-live-search'=>'true'])}}
            </div>


            <div class="mb-3 form-group">
                <input type="file" name="image" id="image" style="display: none;" onchange="loadFile(event)">
                {{ Form::label('image','تصویر دسته :',['class'=>'form-label form-label-admin'])}}
                <img src="/files/images/pic_1.png" alt="select image" onclick="select_file()" id="output_image" width="150px">
                @if($errors->has('image'))
                    <span class="has_errors">{{$errors->first('image')}}</span>
                @endif
            </div>



            <div class="mb-3 form-group">
                {{ Form::label('notShow','عدم نمایش در لیست اصلی :',['class'=>'form-label form-label-admin'])}}
                {{ Form::checkbox('notShow', false)}}
                @if($errors->has('notShow'))
                    <span class="has_errors">{{$errors->first('notShow')}}</span>
                @endif
            </div>

            <button class="btn btn-primary">ویرایش دسته بندی</button>


            {!! Form::close() !!}
        </div>
    </div>
@endsection
