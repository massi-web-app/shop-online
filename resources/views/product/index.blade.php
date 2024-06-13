@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت دسته ها','route'=>route('category.index')]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">مدیریت دسته بندی ها</span>

            @include('include.item_table',['trashed_count'=>$trashed_category_count,
                       'route'=>'category','title'=>'دسته'])
        </div>

        <?php $counterRow = (isset($_GET['page'])) ? ($_GET['page'] - 1) * $paginate : 0 ?>
        <div class="panel_content">
            @include('include.alert')

            <form class="search_form" method="get">
                @if(isset($_GET['trashed']) && $_GET['trashed']==='true')
                    <input type="hidden" value="true" name="trashed">
                @endif
                    <input type="text" class="form-control form-control-admin" name="string"
                           value="{{$request->get('string','')}}" placeholder="کلمه مورد ....">
                <button class="btn btn-primary  ">جستجو</button>
            </form>


            <form id="data_form_table" method="post">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
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
                                <input type="checkbox" class="check_box_item" name="category_id[]"
                                       value="{{$category->id}}">
                            </td>

                            <td>
                                {{$counterRow}}
                            </td>
                            <td>{{$category->title}}</td>
                            <td>{{$category->getParent->title}}</td>
                            <td>
                                @if(!$category->trashed())
                                    <a href="{{route('category.edit',$category->id)}}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="right"
                                              title="ویرایش دسته" class="fa fa-edit"></span>
                                    </a>
                                @endif

                                @if($category->trashed())
                                    <span class="fa fa-refresh"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="بازیابی دسته"
                                          onclick="restore_row('{{route('category.destroy',$category->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از بازیابی این دسته مطئمن هستید؟')"></span>
                                @endif

                                @if(!$category->trashed())

                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف دسته"
                                          onclick="delete_row('{{route('category.destroy',$category->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این دسته برای انتقال به سطل زباله مطئمن هستید؟')"></span>
                                @else
                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف دسته"
                                          onclick="delete_row('{{route('category.destroy',$category->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این دسته برای همیشه مطئمن هستید؟')"></span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($categories)===0)
                        <tr>
                            <td colspan="5">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </form>
            {{$categories->links()}}
        </div>
    </div>
@endsection
