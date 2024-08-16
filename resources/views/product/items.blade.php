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
                <form action="{{route('products.add.items',$product->id)}}" method="post">
                    @csrf
                    @foreach($product_items as $key_item=>$value_item)
                        <div class="item_groups" style="margin-bottom: 20px;">
                            <p class="title">{{$value_item->title}}</p>
                            @foreach($value_item->getChild as $key_child_item=>$child_value_item)
                                  <div class="form-group">
                                      <label for="title">{{$child_value_item->title}} :</label>
                                      <input type="text" class="form-control form-control-admin" name="item_value{{$child_value_item->id}}[]"  id="title">
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
