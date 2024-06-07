@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت رنگ ها','route'=>route('color.index')]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">مدیریت رنگ ها</span>

            @include('include.item_table',['trashed_count'=>$trashed_color_count,
                       'route'=>'color','title'=>'رنگ'])
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
                        <th>نام رنگ</th>
                        <th>کد رنگ</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($colors as $key_category=>$color)
                        @php($counterRow++)
                        <tr>
                            <td>
                                <input type="checkbox" class="check_box_item" name="color_id[]"
                                       value="{{$color->id}}">
                            </td>
                            <td>
                                {{$counterRow}}
                            </td>
                            <td>{{$color->name}}</td>
                            <td>
                                <span class="color" style="background: {{$color->code}};{{$color->code==='#FFFFFF' ? 'color:#000' :''}}">{{$color->code}}</span>
                            </td>

                            <td>
                                @if(!$color->trashed())
                                    <a href="{{route('color.edit',$color->id)}}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="right"
                                              title="ویرایش رنگ" class="fa fa-edit"></span>
                                    </a>
                                @endif

                                @if($color->trashed())
                                    <span class="fa fa-refresh"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="بازیابی رنگ"
                                          onclick="restore_row('{{route('color.destroy',$color->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از بازیابی این رنگ مطئمن هستید؟')"></span>
                                @endif

                                @if(!$color->trashed())

                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف رنگ"
                                          onclick="delete_row('{{route('color.destroy',$color->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این رنگ برای انتقال به سطل زباله مطئمن هستید؟')"></span>
                                @else
                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف رنگ"
                                          onclick="delete_row('{{route('color.destroy',$color->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این رنگ برای همیشه مطئمن هستید؟')"></span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($colors)===0)
                        <tr>
                            <td colspan="6">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </form>
            {{$colors->links()}}
        </div>
    </div>
@endsection
