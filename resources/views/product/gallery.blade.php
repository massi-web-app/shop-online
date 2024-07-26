@extends('layouts.admin')


@section('head')
    <link rel="stylesheet" href="{{asset('/dropzone/css/dropzone.min.css')}}">
@endsection


@section('content')

    @include('include.breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','route'=>route('product.index')],
            ['title'=>'مدیریت گالری تصاویر محصول','route'=>route('product.gallery',$product->id)],
            ]])

    <div class="panel">

        <div class="header">
            گالری تصاویر - {{$product->title}}
        </div>

        <div class="panel_content">
            @include('include.alert')

            <form method="post" id="upload-file" class="dropzone"
                  action="{{route('product.gallery.upload',$product->id)}}">
                @csrf
                <input type="file" style="display: none" name="file" multiple>
            </form>

            <table class="table table-bordered table-striped" id="table-gallery">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>تصویر</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($galleries as $key=>$gallery)
                        <tr>
                            <td>{{$i}}</td>
                            <td>
                                <img src="{{asset('files/gallery/'.$gallery->image_url)}}" alt="">
                            </td>
                            <td>
                                 <span class="fa fa-remove"
                                       data-bs-toggle="tooltip" data-bs-placement="right" title="حذف تصویر"
                                       onclick="delete_row('{{route('product.gallery.remove',$gallery->id)}}','{{\Illuminate\Support\Facades\Session::token()}}','آیا از حذف این تصویر برای انتقال به سطل زباله مطئمن هستید؟')"></span>
                            </td>
                        </tr>
                        @php($i++)
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection



@section('js')
    <script type="text/javascript" src="{{asset('/dropzone/js/dropzone.min.js')}}"></script>
    <script>
        Dropzone.options.uploadFile = {
            acceptedFiles: '.png,.jpg,.jpeg',
            addRemoveLinks: true,
            init: function () {
                this.options.dictRemoveFile = "حذف";
                this.options.dictInvalidFileType = "امکان آپلود این فایل وجود ندارد";
                this.on("success", function (file, response) {
                    console.log(response);
                    if (Number(response) === 1) {
                        file.previewElement.classList.add('dz-success')
                    } else {
                        file.previewElement.classList.add('dz-error');
                        $(file.previewElement).find(".dz-error-message").text("خطا در آپلود فایل");
                    }
                })
                this.on("error", function (file, response) {
                    file.previewElement.classList.add('dz-error');
                    $(file.previewElement).find(".dz-error-message").text("خطا در آپلود فایل");
                })
            }
        }
    </script>
@endsection
