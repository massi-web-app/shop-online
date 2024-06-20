@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','route'=>route('product.index')],
            ['title'=>'افزودن محصول جدید','route'=>route('product.create')],
            ]])

    <div class="panel">

        <div class="header">افزودن محصول جدید</div>

        <div class="panel_content">
            {!! Form::open(['url' => route('product.store'),'files'=>true]) !!}

            <div class="mb-3 form-group">
                {{ Form::label('title','نام محصول :',['class'=>'form-label form-label-admin '])}}
                {{ Form::text('title',null,['class'=>'form-control total_with_input '])}}
                @if($errors->has('title'))
                    <span class="has_errors">{{$errors->first('title')}}</span>
                @endif
            </div>

            <div class="mb-3">
                {{ Form::label('summery','توضیحات :',['class'=>'form-label form-label-admin '])}}
                {{ Form::textarea('summery',null,['class'=>'form-control total_with_input editor1'])}}
                @if($errors->has('summery'))
                    <span class="has_errors">{{$errors->first('summery')}}</span>
                @endif
            </div>

            <div class="row form-group">
                <div class="col-12 col-md-6" id="col-right">
                    <div class="mb-3">
                        {{ Form::label('ename','نام لاتین محصول :',['class'=>'form-label'])}}
                        {{ Form::text('ename',null,['class'=>'form-control total_with_input left_direction'])}}
                        @if($errors->has('ename'))
                            <span class="has_errors">{{$errors->first('ename')}}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        {{ Form::label('category_id','انتخاب دسته :',['class'=>'form-label'])}}
                        {{ Form::select('category_id',$categories,null,['class'=>'total_with_input form-select',
        'data-live-search'=>'true'])}}
                        @if($errors->has('category_id'))
                            <span class="has_errors">{{$errors->first('category_id')}}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        {{ Form::label('brand_id','انتخاب برند :',['class'=>'form-label'])}}
                        {{ Form::select('brand_id',$brands,null,['class'=>'total_with_input form-select',
        'data-live-search'=>'true'])}}
                        @if($errors->has('brand_id'))
                            <span class="has_errors">{{$errors->first('brand_id')}}</span>
                        @endif
                    </div>


                    <div class="mb-3">
                        <label for="product_color" class="form-label">انتخاب رنگ محصول</label>
                        <select name="product_color[]" class="total_with_input form-select" data-live-search="true" multiple>
                            <option value="-1" selected="selected">لطفا رنگ های محصول را انتخاب کنید</option>
                            @foreach($colors as $color)
                                <option value="{{$color->id}}"
                                        data-content="<span style='background:{{$color->code}}'>{{$color->name}}</span>">{{$color->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                        <div class="choice_pic_box">
                            <span class="title">انتخاب تصویر محصول</span>
                            <input type="file" name="image" id="image" style="display: none;" onchange="loadFile(event)">
                            <img src="/files/images/pic_1.png" alt="select image" class="output_image" onclick="select_file()" id="output_image" width="150px">
                        </div>
                </div>
            </div>


            <button class="btn btn-success">ثبت محصول</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection



@section('js')
    <script type="text/javascript" src="{{asset('/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('summery');
    </script>
@endsection
