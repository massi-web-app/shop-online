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


                <div id="item_box"></div>
                <span class="fa fa-plus-square" onclick="add_item_input()"></span>
                <div class="form-group">
                    <button class="btn btn-primary">ثبت اطلاعات</button>
                </div>
            </form>
        </div>
    </div>
@endsection
