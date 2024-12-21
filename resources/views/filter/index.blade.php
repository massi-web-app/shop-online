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

                    @if(sizeof($filters)>0)
                        @foreach($filters as $key_filter=>$filter_item)
                            <div class="mb-3 item_groups" id="filter_{{$filter_item->id}}">
                                <div class="form-group">
                                    <select name="item_id[{{$filter_item->id}}]" class="form-label form-label-admin form-select m-3" data-live-search="true">
                                        <option value="0">انتخاب ویژگی(در صورت نیاز)</option>
                                        @foreach($items as $key_item=>$item)
{{--                                            <option value="0">{{$item->title}}</option>--}}
                                            @foreach($item->getChild as $k=>$v)
                                                <option @if($v->id===$filter_item->item_id)  selected="selected" @endif value="{{$v->id}}">{{$v->title}}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control form-control-admin filter_input"
                                           value="{{$filter_item->title}}"
                                           name="filter[{{$filter_item->id}}]" placeholder="نام گروه فیلتر ">
                                    <span class="fa fa-plus-circle m-1"
                                          onclick="add_filter_child({{$filter_item->id}})"></span>
                                    <span class="item_remove_message" onclick="delete_row('{{route('category.filters.remove_item',$filter_item->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این فلیتر ها مطئمن هستید؟')">حذف کلی فیلتر های گروه {{$filter_item->title}}</span>
                                </div>
                                <div class="child_filter_box">
                                    <?php  $i = 1;?>
                                    @foreach($filter_item->getChild as $childFilter)
                                        <div class="item_child child_{{$filter_item->id}}">
                                            {{$i}} -
                                            <input type="text" name="child_item[{{$filter_item->id}}][{{$childFilter->id}}]"
                                                   value="{{$childFilter->title}}"
                                                   class="form-control  form-control-admin child_input_item"
                                                   placeholder="نام ویژگی">
                                            <span class="child_item_remove_message" onclick="delete_row('{{route('category.filters.remove_item',$childFilter->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این فیلتر مطئمن هستید؟')">حذف فیلتر</span>
                                        </div>
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    @else
                        <div class="mb-3 item_groups" id="filter_-1">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-admin filter_input"
                                       value=""
                                       name="filter[-1]" placeholder="نام گروه فیلتر ">
                                <span class="fa fa-plus-circle m-1"
                                      onclick="add_filter_child(-1)"></span>
                            </div>
                            <div class="child_filter_box">
                            </div>
                        </div>
                    @endif

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
        $(document).ready(function () {
            $(".category_filters").sortable();
            $(".child_filter_box").sortable();
        })
    </script>

@endsection
