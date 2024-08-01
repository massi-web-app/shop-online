@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت اسلایدر ها','route'=>route('sliders.index')]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">مدیریت اسلایدر ها</span>

            @include('include.item_table',['trashed_count'=>$sliders_trashed_count,
                       'route'=>'sliders','title'=>'اسلایدر'])
        </div>

        <?php $counterRow = (isset($_GET['page'])) ? ($_GET['page'] - 1) * $paginate : 0 ?>
        <div class="panel_content">
            @include('include.alert')

            <form id="data_form_table" method="post">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>عنوان</th>
                        <th>تصویر</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sliders as $key_category=>$slider)
                        @php($counterRow++)
                        <tr>
                            <td>
                                <input type="checkbox" class="check_box_item" name="slider_id[]"
                                       value="{{$slider->id}}">
                            </td>
                            <td>
                                {{$counterRow}}
                            </td>
                            <td>{{$slider->title}}</td>
                            <td>
                                <img src="/files/slider/{{$slider->image_url}}" alt="">
                            </td>
                            <td>
                                @if(!$slider->trashed())
                                    <a href="{{route('sliders.edit',$slider->id)}}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="right"
                                              title="ویرایش اسلایدر" class="fa fa-edit"></span>
                                    </a>
                                @endif

                                @if($slider->trashed())
                                    <span class="fa fa-refresh"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="بازیابی اسلایدر"
                                          onclick="restore_row('{{route('sliders.destroy',$slider->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از بازیابی این اسلایدر مطئمن هستید؟')"></span>
                                @endif

                                @if(!$slider->trashed())

                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف اسلایدر"
                                          onclick="delete_row('{{route('sliders.destroy',$slider->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این اسلایدر برای انتقال به سطل زباله مطئمن هستید؟')"></span>
                                @else
                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف اسلایدر"
                                          onclick="delete_row('{{route('sliders.destroy',$slider->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این اسلایدر برای همیشه مطئمن هستید؟')"></span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($sliders)===0)
                        <tr>
                            <td colspan="5">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </form>
            {{$sliders->links()}}
        </div>
    </div>
@endsection
