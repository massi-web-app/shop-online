@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت رنگ ها','route'=>route('color.index')],
            ['title'=>'افزودن رنگ جدید','route'=>route('color.create')],
            ]])

    <div class="panel">
        <div class="header">افزودن رنگ جدید</div>

        <div class="panel_content">
            {!! Form::open(['url' => route('color.store')]) !!}

            <div class="mb-3 form-group">
                {{ Form::label('name','نام رنگ :',['class'=>'form-label form-label-admin'])}}
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

            <button class="btn btn-success">ثبت رنگ</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection


@section('js')
    <script src="/js/jscolor.js"></script>
@endsection
