@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت تنوع قیمت ها','route'=>route('product_warranties.index','?product_id='.$product->id)],
            ['title'=>'ویرایش تنوع قیمت','route'=>route('product_warranties.edit',[
                $productWarranty->id,
                'product_id'=>$product->id])],
            ]])

    <div class="panel">

        <div class="header">ویرایش تنوع قیمت برای - {{$product->title}}</div>

        <div class="panel_content">
            @include('include.warning')
            {!! Form::model($productWarranty,['url' => route('product_warranties.update',[
                $productWarranty->id,
                'product_id'=>$product->id])
            ]) !!}

            {{method_field('PUT')}}

            <div class="mb-3 form-group">
                {{ Form::label('warranty_id','انتخاب گارانتی :',['class'=>'form-label form-label-admin'])}}
                {{ Form::select('warranty_id',$warranties,null,['class'=>'form-label form-label-admin form-select',
'data-live-search'=>'true'])}}

                @if($errors->has('warranty_id'))
                    <span class="has_errors">{{$errors->first('warranty_id')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                <label for="product_color_id" class="form-label form-label-admin">انتخاب رنگ </label>
                <select name="color_id" class="form-label form-label-admin form-select" data-live-search="true">
                    @foreach($product_colors as $product_color)
                        <option value="{{$product_color->color_id}}"
                                @if($product_color->color_id===$productWarranty->color_id)
                                selected="selected"
                                @endif
                                data-content="<span style='background:{{$product_color->getColor->code}}'>{{$product_color->getColor->name}}</span>">{{$product_color->getColor->name}}</option>
                    @endforeach
                </select>
                @if($errors->has('color_id'))
                    <span class="has_errors">{{$errors->first('color_id')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('real_product_price','قیمت محصول :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('real_product_price',null,['class'=>'form-control form-control-admin left real_product_price'])}}
                @if($errors->has('real_product_price'))
                    <span class="has_errors">{{$errors->first('real_product_price')}}</span>
                @endif
            </div>


            <div class="mb-3 form-group">
                {{ Form::label('sale_product_price','قیمت محصول برای فروش :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('sale_product_price',null,['class'=>'form-control form-control-admin left sale_product_price'])}}
                @if($errors->has('sale_product_price'))
                    <span class="has_errors">{{$errors->first('sale_product_price')}}</span>
                @endif
            </div>


            <div class="mb-3 form-group">
                {{ Form::label('product_number','تعداد موجودی محصول :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('product_number',null,['class'=>'form-control form-control-admin left product_number'])}}
                @if($errors->has('product_number'))
                    <span class="has_errors">{{$errors->first('product_number')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('product_number_cart','تعداد سفارش توی هر سبد خرید :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('product_number_cart',null,['class'=>'form-control form-control-admin left product_number_cart'])}}
                @if($errors->has('product_number_cart'))
                    <span class="has_errors">{{$errors->first('product_number_cart')}}</span>
                @endif
            </div>

            <div class="mb-3 form-group">
                {{ Form::label('send_time','زمان آماده سازی محصول :',['class'=>'form-label form-label-admin'])}}
                {{ Form::text('send_time',null,['class'=>'form-control form-control-admin left send_time'])}}
                @if($errors->has('send_time'))
                    <span class="has_errors">{{$errors->first('send_time')}}</span>
                @endif
            </div>


            <button class="btn btn-info">ویرایش تنوع قیمت</button>


            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/cleave.min.js"></script>

    <script>


        var cleave1 = new Cleave('.real_product_price', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });

        var cleave2 = new Cleave('.sale_product_price', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });

        var cleave3 = new Cleave('.product_number', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });

        var cleave4 = new Cleave('.product_number_cart', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });

        var cleave5 = new Cleave('.send_time', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });


    </script>
@endsection
