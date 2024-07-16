@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت گارانتی ها','route'=>route('warranty.index')]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">مدیریت گارانتی ها</span>

            @include('include.item_table',['trashed_count'=>$trashed_warranty_count,
                       'route'=>'warranty','title'=>'گارانتی'])
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
                        <th>نام گارانتی</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($warranties as $key_warranty=>$warranty)
                        @php($counterRow++)
                        <tr>
                            <td>
                                <input type="checkbox" class="check_box_item" name="warranty_id[]"
                                       value="{{$warranty->id}}">
                            </td>

                            <td>
                                {{$counterRow}}
                            </td>
                            <td>{{$warranty->name}}</td>
                            <td>
                                @if(!$warranty->trashed())
                                    <a href="{{route('warranty.edit',$warranty->id)}}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="right"
                                              title="ویرایش گارانتی" class="fa fa-edit"></span>
                                    </a>
                                @endif

                                @if($warranty->trashed())
                                    <span class="fa fa-refresh"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="بازیابی گارانتی"
                                          onclick="restore_row('{{route('warranty.destroy',$warranty->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از بازیابی این گارانتی مطئمن هستید؟')"></span>
                                @endif

                                @if(!$warranty->trashed())

                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف گارانتی"
                                          onclick="delete_row('{{route('warranty.destroy',$warranty->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این گارانتی برای انتقال به سطل زباله مطئمن هستید؟')"></span>
                                @else
                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف گارانتی"
                                          onclick="delete_row('{{route('warranty.destroy',$warranty->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این گارانتی برای همیشه مطئمن هستید؟')"></span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($warranties)===0)
                        <tr>
                            <td colspan="4">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </form>
            {{$warranties->links()}}
        </div>
    </div>
@endsection
