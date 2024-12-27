@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت محصولات','route'=>route('products.index')],
    ['title'=>'ثبت مشخصات فیلتر های محصول','route'=>route('products.show.filters',$product->id)],
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">
                ثبت مشخصات فیلتر های محصول - {{$product->title}}
            </span>
        </div>

        <div class="panel_content" id="filter_product_box">
            @include('include.alert')

            @if(sizeof($product_filters)>0)
                <form  id="product_filters_form"   action="{{route('products.add.filters',$product->id)}}" method="post">
                    @csrf
                    @foreach($product_filters as $key=>$value_product_filter)
                        <div class="item_groups" style="margin-bottom: 20px;">
                            <p class="title">{{$value_product_filter->title}}</p>
                            @foreach($value_product_filter->getChild as $key_child_item=>$child_value_filter)
                             <div class="form-group">
                                  <input type="checkbox"

                                        @if(\App\Helper\Helper::is_selected_filter($value_product_filter->getValue,$child_value_filter->id)) checked="checked" @endif
                                        name="filters[{{$value_product_filter->id}}][]" value="{{$child_value_filter->id}}">
                                 <label for="">{{$child_value_filter->title}}</label>
                             </div>
                            @endforeach
                        </div>
                    @endforeach
                    <button class="btn btn-success">ثبت اطلاعات</button>
                </form>
            @else


            @endif

        </div>
    </div>
@endsection
