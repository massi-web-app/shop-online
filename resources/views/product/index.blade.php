@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
    ['title'=>'مدیریت محصولات','route'=>route('product.index')]
]])

    <div class="panel">

        <div class="header">
            <span class="title_page">مدیریت محصولات</span>

            @include('include.item_table',['trashed_count'=>$trashed_product_count,
                       'route'=>'product','title'=>'محصول'])
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
                        <th>تصویر محصول</th>
                        <th>نام فروشنده</th>
                        <th>نام محصول</th>
                        <th>وضعیت محصول</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key_product=>$product)
                        @php($counterRow++)
                        <tr>
                            <td>
                                <input type="checkbox" class="check_box_item" name="product_id[]"
                                       value="{{$product->id}}">
                            </td>

                            <td>
                                {{$counterRow}}
                            </td>
                            <td>
                                <img src="{{asset('files/products/'.$product->image_url)}}" alt="image product" class="product_image">
                            </td>
                            <td>
                                -
                            </td>
                            <td>{{$product->title}}</td>
                            <td style="width: 120px;">
                                <span class="alert @if($product->status===1) alert-success @else alert-warning @endif"
                                      style="font-size:13px;padding: 5px 7px; ">
                                  {{$product->productStatus}}
                                </span>
                            </td>
                            <td>
                                @if(!$product->trashed())
                                    <a href="{{route('product.edit',$product->id)}}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="right"
                                              title="ویرایش محصول" class="fa fa-edit"></span>
                                    </a>
                                @endif

                                @if($product->trashed())
                                    <span class="fa fa-refresh"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="بازیابی محصول"
                                          onclick="restore_row('{{route('product.destroy',$product->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از بازیابی این محصول مطئمن هستید؟')"></span>
                                @endif

                                @if(!$product->trashed())

                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف محصول"
                                          onclick="delete_row('{{route('product.destroy',$product->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این محصول برای انتقال به سطل زباله مطئمن هستید؟')"></span>
                                @else
                                    <span class="fa fa-remove"
                                          data-bs-toggle="tooltip" data-bs-placement="right" title="حذف محصول"
                                          onclick="delete_row('{{route('product.destroy',$product->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این محصول برای همیشه مطئمن هستید؟')"></span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($products)===0)
                        <tr>
                            <td colspan="7">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </form>
            {{$products->links()}}
        </div>
    </div>
@endsection
