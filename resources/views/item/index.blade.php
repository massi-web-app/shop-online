@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت ویژگی ها','route'=>route('category.items',$category->id)]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">
                مدیریت ویژگی های دسته - {{$category->title}}
            </span>
        </div>

        <div class="panel_content">
            @include('include.alert')

            <form method="post" action="{{route('category.items.add_item',$category->id)}}">
                @csrf
                <div class="category_items">
                    @if(sizeof($items)>0)
                        @foreach($items as $key=>$item)
                            <div class="mb-3 item_groups align-items-center" id="item_{{$item->id}}">
                                <div class="align-items-center">
                                    <input type="text" class="form-control form-control-admin item_input"
                                           style="display: inline-block"
                                           name="item[{{$item->id}}]" value="{{$item->title}}" placeholder="نام گروه ویژگی">
                                    <span class="fa fa-plus-circle" onclick="add_child_input({{$item->id}})"></span>

                                    <span class="item_remove_message" onclick="delete_row('{{route('category.items.remove_item',$item->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این ویژگی ها مطئمن هستید؟')">حذف کلی آیتم های گروه {{$item->title}}</span>
                                </div>

                                <div class="child_item_box">
                                    <?php
                                    $counter = 1;
                                    ?>
                                    @foreach($item->getChild as $key_child_item=>$value_child_item)
                                        <div class="item_child child_{{$item->id}}">
                                            {{$counter}}- <input type="checkbox"
                                                                 @if($value_child_item->item_important)
                                                                 checked="checked"
                                                                 @endif
                                                                 name="check_box_item[{{$item->id}}][{{$value_child_item->id}}]">
                                            <input type="text" value="{{$value_child_item->title}}" name="child_item[{{$item->id}}][{{$value_child_item->id}}]"
                                                   class="form-control  form-control-admin child_input_item"
                                                   placeholder="نام ویژگی">

                                            <span class="child_item_remove_message" onclick="delete_row('{{route('category.items.remove_item',$value_child_item->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این ویژگی مطئمن هستید؟')">حذف ویژگی</span>
                                        </div>
                                        <?php
                                        $counter++;
                                        ?>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    @else
                        <div class="mb-3 item_groups align-items-center" id="item_-1">
                            <div class="align-items-center">
                                <input type="text" class="form-control form-control-admin item_input"
                                       style="display: inline-block"
                                       name="item[-1]" value="" placeholder="نام گروه ویژگی">
                                <span class="fa fa-plus-circle" onclick="add_child_input(-1)"></span>
                            </div>

                            <div class="child_item_box">

                            </div>
                        </div>
                    @endif
                </div>

                <div id="item_box"></div>
                <span class="fa fa-plus-square" onclick="add_item_input()"></span>
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
