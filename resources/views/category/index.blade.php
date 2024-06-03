@extends('layouts.admin')

@section('content')
    <div class="panel">

        <div class="header">
            <span class="title_page">مدیریت دسته بندی ها</span>

            @include('include.item_table',['trashed_count'=>$trashed_category_count,
                       'route'=>'category','title'=>'دسته'])
        </div>

        <?php $counterRow = (isset($_GET['page'])) ? ($_GET['page'] - 1) * $paginate : 0 ?>
        <div class="panel_content">
            @include('include.alert')
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام دسته</th>
                    <th>دسته والد</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $key_category=>$category)
                    @php($counterRow++)
                    <tr>
                        <td>
                            {{$counterRow}}
                        </td>
                        <td>{{$category->title}}</td>
                        <td>{{$category->getParent->title}}</td>
                        <td>
                            <a href="{{route('category.edit',$category->id)}}"><span class="fa fa-edit"></span></a>
                            <span class="fa fa-remove" onclick="delete_row('{{route('category.destroy',$category->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این دسته مطئمن هستید؟')"></span>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            {{$categories->links()}}
        </div>
    </div>
@endsection
