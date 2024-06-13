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
                        {{ Form::select('category_id',$categories,null,['class'=>'form-label total_with_input form-select',
        'data-live-search'=>'true'])}}
                        @if($errors->has('category_id'))
                            <span class="has_errors">{{$errors->first('category_id')}}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        {{ Form::label('brand_id','انتخاب برند :',['class'=>'form-label'])}}
                        {{ Form::select('brand_id',$brands,null,['class'=>'form-label total_with_input form-select',
        'data-live-search'=>'true'])}}
                        @if($errors->has('brand_id'))
                            <span class="has_errors">{{$errors->first('brand_id')}}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="color">انتخاب رنگ محصول</label>
                        <select name="product_color[]" class="selectpicker" data-live-search="true" multiple>
                            @foreach($colors as $color)
                                <option value="{{$color->id}}"
                                        data-content="<span style='background=#{{$color->code}}'></span>">{{$color->title}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-12 col-md-6" style="height: 150px;background: blue"></div>
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
