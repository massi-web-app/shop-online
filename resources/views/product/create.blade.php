@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','route'=>route('products.index')],
            ['title'=>'افزودن محصول جدید','route'=>route('products.create')],
            ]])

    <div class="panel">

        <div class="header">افزودن محصول جدید</div>

        <div class="panel_content">
            {!! Form::open(['url' => route('products.store'),'files'=>true]) !!}

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
                        <label for="product_color_id" class="form-label">انتخاب رنگ محصول</label>
                        <select name="product_color_id[]" class="total_with_input form-select" data-live-search="true"
                                multiple>
                            <option value="-1" selected="selected">لطفا رنگ های محصول را انتخاب کنید</option>
                            @foreach($colors as $color)
                                <option value="{{$color->id}}"
                                        data-content="<span style='background:{{$color->code}}'>{{$color->name}}</span>">{{$color->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('product_color_id'))
                            <span class="has_errors">{{$errors->first('product_color_id')}}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        {{ Form::label('status','وضعیت محصول :',['class'=>'form-label'])}}
                        {{ Form::select('status',$status,1,['class'=>'total_with_input form-select','data-live-search'=>'true'])}}
                        @if($errors->has('status'))
                            <span class="has_errors">{{$errors->first('status')}}</span>
                        @endif
                    </div>


                </div>
                <div class="col-12 col-md-6">
                    <div class="choice_pic_box">
                        <span class="title">انتخاب تصویر محصول</span>
                        <input type="file" name="image_url" id="image" style="display: none;" onchange="loadFile(event)">
                        <img src="/files/images/pic_1.png" alt="select image" class="output_image"
                             onclick="select_file()" id="output_image" width="150px">
                    </div>
                </div>
            </div>

            <div class="row">
                <p class="message_text">برچسب ها با استفاده از (،) ازهم جدا میشوند</p>
                <div class="mb-3 form-group">
                    <input type="text" name="tag_list" id="tag_list" class="form-control total_with_input" placeholder="برچسب های محصول">
                    <div class="btn btn-success" style="font-size: 10px;line-height: 20px;" onclick="add_tag()">افزودن </div>
                    <input type="hidden" name="keywords" id="keywords">
                </div>
                <div id="tag_box"></div>
            </div>

            <div class="mb-3">
                {{ Form::label('description','توضیحات مختصر محصول: (حداکثر 155 کاراکتر)',['class'=>'form-label form-label-admin '])}}
                {{ Form::textarea('description',null,['class'=>'form-control total_with_input'])}}
                @if($errors->has('description'))
                    <span class="has_errors">{{$errors->first('description')}}</span>
                @endif
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
