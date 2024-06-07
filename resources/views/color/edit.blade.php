@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت رنگ ها','route'=>route('color.index')],
            ['title'=>'ویرایش رنگ','route'=>route('color.edit',$color->id)],
            ]])

    <div class="panel">
        <div class="header">ویرایش رنگ</div>

        <div class="panel_content">
            {!! Form::model($color,['url' => route('color.update',$color->id)]) !!}

            {{method_field('PUT')}}
            <div class="mb-3 form-group">
                {{ Form::label('name','نام برند :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('name',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('name'))
                    <span class="has_errors">{{$errors->first('name')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('code','کد رنگ:',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('code',null,['class'=>'form-control form-control-admin','data-jscolor'=>'{}'])}}
                @if($errors->has('code'))
                    <span class="has_errors">{{$errors->first('code')}}</span>
                @endif
            </div>

            <button class="btn btn-success">ویرایش رنگ</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection


@section('js')
    <script src="/js/jscolor.js"></script>
@endsection
