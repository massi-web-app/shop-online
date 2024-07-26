@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت تنوع قیمت ها','route'=>route('product_warranties.index','product_id='.$product->id)]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">مدیریت تنوع قیمت برای  - {{$product->title}}</span>

            @include('include.item_table',['trashed_count'=>$trashed_product_warranties,
                       'route'=>'product_warranties','title'=>'تنوع قیمت','queryString'=>['params'=>'product_id','value'=>$product->id]])
        </div>

        <?php $counterRow = (isset($_GET['page'])) ? ($_GET['page'] - 1) * $paginate : 0 ?>
        <div class="panel_content">
            @include('include.alert')
            <form id="data_form_table" method="post">
                @csrf
                <table class="table table-bordered table-striped" id="productWarranties">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>نام گارانتی</th>
                        <th>قیمت محصول</th>
                        <th>قیمت برای فروش محصول</th>
                        <th>تعداد موجودی محصول</th>
                        <th>رنگ</th>
                        <th>فروشنده</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productWarranties as $productWarranty)
                        @php($counterRow++)
                        <tr>
                            <td>
                                <input type="checkbox" class="check_box_item" name="product_warranties_id[]"
                                       value="{{$productWarranty->id}}">
                            </td>

                            <td>
                                {{$counterRow}}
                            </td>
                            <td>
                                {{$productWarranty->getWarranty->name}}
                            </td>
                            <td style="min-width: 160px;">
                                <span class="alert alert-success">
                                    {{number_format($productWarranty->real_product_price)}}
                                    تومان
                                </span>
                            </td>
                            <td style="min-width: 160px;">
                                <span class="alert alert-warning">
                                    {{number_format($productWarranty->sale_product_price)}}
                                    تومان
                                </span>
                            </td>
                            <td>
                                {{$productWarranty->product_number}}
                            </td>
                            <td style="width: 140px;">
                                @if($productWarranty->getColor!==null)
                                    <span class="color_td" style="background: {{$productWarranty->getColor->code}}">
                                        <span style="@if($productWarranty->getColor->name!=='سفید')
                                        color:#fff;
                                        @endif">{{$productWarranty->getColor->name}}</span>
                                    </span>
                                @endif
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                @if(!$productWarranty->trashed())
                                    <a href="{{route('product_warranties.edit',$productWarranty->id).'?product_id='.$product->id}}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="right"
                                              title="ویرایش تنوع قیمت" class="fa fa-edit"></span>
                                    </a>
                                @endif

                                @if($productWarranty->trashed())
                                    <span class="fa fa-refresh"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="بازیابی تنوع قیمت"
                                          onclick="restore_row('{{route('product_warranties.destroy',$productWarranty->id).'?product_id='.$product->id}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از بازیابی این تنوع قیمت مطئمن هستید؟')"></span>
                                @endif

                                @if(!$productWarranty->trashed())

                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف تنوع قیمت"
                                          onclick="delete_row('{{route('product_warranties.destroy',$productWarranty->id).'?product_id='.$product->id}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این تنوع قیمت برای انتقال به سطل زباله مطئمن هستید؟')"></span>
                                @else
                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف تنوع قیمت"
                                          onclick="delete_row('{{route('product_warranties.destroy',$productWarranty->id).'?product_id='.$product->id}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این تنوع قیمت برای همیشه مطئمن هستید؟')"></span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($productWarranties)===0)
                        <tr>
                            <td colspan="9">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </form>
            {{$productWarranties->links()}}
        </div>
    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function(){
            $("#sidebarToggle").click();
        })
    </script>
@endsection
