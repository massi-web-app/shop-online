@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت گارانتی ها','route'=>route('category.index')],
            ['title'=>'افزودن گارانتی جدید','route'=>route('category.create')],
            ]])

    <div class="panel">

        <div class="header">افزودن گارانتی جدید</div>

        <div class="panel_content">
            {!! Form::open(['url' => route('warranty.store')]) !!}

            <div class="mb-3 form-group">
                {{ Form::label('name','نام گارانتی :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('name',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('name'))
                    <span class="has_errors">{{$errors->first('name')}}</span>
                @endif
            </div>

            <button class="btn btn-success">ثبت گارانتی</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
