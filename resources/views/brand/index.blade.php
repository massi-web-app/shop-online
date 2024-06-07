@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت برند ها','route'=>route('brand.index')]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">مدیریت برند ها</span>

            @include('include.item_table',['trashed_count'=>$trashed_brand_count,
                       'route'=>'brand','title'=>'برند'])
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
                        <th>نام برند</th>
                        <th>نام لاتین</th>
                        <th>آیکون برند</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($brands as $key_category=>$brand)
                        @php($counterRow++)
                        <tr>
                            <td>
                                <input type="checkbox" class="check_box_item" name="brand_id[]"
                                       value="{{$brand->id}}">
                            </td>
                            <td>
                                {{$counterRow}}
                            </td>
                            <td>{{$brand->name}}</td>
                            <td>{{$brand->ename}}</td>
                            <td>
                                <img src="/files/upload/{{$brand->icon}}" alt="">
                            </td>
                            <td>
                                @if(!$brand->trashed())
                                    <a href="{{route('brand.edit',$brand->id)}}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="right"
                                              title="ویرایش برند" class="fa fa-edit"></span>
                                    </a>
                                @endif

                                @if($brand->trashed())
                                    <span class="fa fa-refresh"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="بازیابی برند"
                                          onclick="restore_row('{{route('brand.destroy',$brand->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از بازیابی این برند مطئمن هستید؟')"></span>
                                @endif

                                @if(!$brand->trashed())

                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف برند"
                                          onclick="delete_row('{{route('brand.destroy',$brand->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این برند برای انتقال به سطل زباله مطئمن هستید؟')"></span>
                                @else
                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف برند"
                                          onclick="delete_row('{{route('brand.destroy',$brand->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این برند برای همیشه مطئمن هستید؟')"></span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($brands)===0)
                        <tr>
                            <td colspan="6">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </form>
            {{$brands->links()}}
        </div>
    </div>
@endsection
