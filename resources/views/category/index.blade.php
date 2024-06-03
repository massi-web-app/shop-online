@extends('layouts.admin')

@section('content')
    <div class="panel">

        <div class="header">مدیریت دسته بندی ها</div>

        <?php $counterRow = (isset($_GET['page'])) ? ($_GET['page'] - 1) * $paginate : 0 ?>
        <div class="panel_content">
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
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            {{$categories->links()}}
        </div>
    </div>
@endsection
