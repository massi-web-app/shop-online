@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت محصولات','route'=>route('products.index')],
    ['title'=>'ثبت مشخصات فنی','route'=>route('products.show.items',$product->id)],
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">
                ثبت مشخصات فنی - {{$product->title}}
            </span>
        </div>

        <div class="panel_content">
            @include('include.alert')

            @if(sizeof($product_items)>0)
                <form  id="product_items_form"   action="{{route('products.add.items',$product->id)}}" method="post">
                    @csrf
                    @foreach($product_items as $key_item=>$value_item)
                        <div class="item_groups" style="margin-bottom: 20px;">
                            <p class="title">{{$value_item->title}}</p>
                            @foreach($value_item->getChild as $key_child_item=>$child_value_item)
                                <div class="form-group">
                                    <label for="title">{{$child_value_item->title}} :</label>
                                    @if(sizeof($child_value_item->getValue)>0)
                                        <input type="text" value="{{$child_value_item->getValue[0]->value}}"
                                               class="form-control form-control-admin"
                                               name="item_value[{{$child_value_item->id}}][]" id="title">
                                    @else
                                        <input type="text" class="form-control form-control-admin"
                                               name="item_value[{{$child_value_item->id}}][]" id="title">
                                    @endif

                                    <span class="fa fa-plus-square m-1"
                                          onclick="add_item_value_input({{$child_value_item->id}})"></span>
                                </div>

                                <div class="input_item_box" id="input_item_box_{{$child_value_item->id}}">
                                    @if(sizeof($child_value_item->getValue)>1)
                                        @foreach($child_value_item->getValue as $key=>$children_item)
                                            @if($key>0)
                                                <div class="form-group">
                                                    <label for="title"></label>
                                                    <input type="text" value="{{$children_item->value}}"
                                                           class="form-control form-control-admin"
                                                           name="item_value[{{$child_value_item->id}}][]" id="title">
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                            @endforeach
                        </div>
                    @endforeach
                    <button class="btn btn-success">ثبت مشخصات فنی محصول</button>
                </form>
            @else


            @endif

        </div>
    </div>
@endsection
