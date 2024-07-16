@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
        ['title'=>'مدیریت گارانتی ها','route'=>route('warranty.index')],
        ['title'=>'ویرایش گارانتی','route'=>route('warranty.edit',$warranty->id)],
        ]])

    <div class="panel">

        <div class="header">
            ویرایش گارانتی - {{$warranty->name}}
        </div>

        <div class="panel_content">
            {!! Form::model($warranty,['url' => route('warranty.update',$warranty->id)]) !!}

            {{method_field('PUT')}}
            <div class="mb-3 form-group">
                {{ Form::label('name','نام دسته :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('name',null,['class'=>'form-control form-control-admin'])}}
                @if($errors->has('name'))
                    <span class="has_errors">{{$errors->first('name')}}</span>
                @endif
            </div>

            <button class="btn btn-primary">ویرایش گارانتی</button>


            {!! Form::close() !!}
        </div>
    </div>
@endsection
