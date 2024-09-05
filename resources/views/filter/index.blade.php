@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت فیلتر ها','route'=>route('category.filters',$category->id)]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">
                مدیریت  فیلتر های - {{$category->title}}
            </span>
        </div>

        <div class="panel_content">
            @include('include.alert')

            <form method="post" action="{{route('category.filters.add_item',$category->id)}}">
                @csrf
                <div class="category_filters">
                    @foreach($filters as $key_filter=>$filter_item)
                        <div class="mb-3 item_groups" id="filter_{{$filter_item->id}}">
                            <div class="form-group" >
                                <input type="text" class="form-control form-control-admin filter_input"
                                        value="{{$filter_item->title}}"
                                        name="filter[{{$filter_item->id}}]" placeholder="نام گروه فیلتر ">
                                <span class="fa fa-plus-circle m-1" onclick="add_filter_child({{$filter_item->id}})"></span>
                            </div>
                            <div class="child_filter_box"></div>
                        </div>
                    @endforeach
                </div>

                <div id="filter_box"></div>
                <span class="fa fa-plus-square" onclick="add_filter_input()"></span>
                <div class="form-group">
                    <button class="btn btn-primary">ثبت اطلاعات</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('js')

    <script type="text/javascript" src="{{asset('/js/jquery-ui.js')}}"></script>
    <script>
        $(document).ready(function (){
            $(".category_items").sortable();
            $(".child_item_box").sortable();
        })
    </script>

@endsection
