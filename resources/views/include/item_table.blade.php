<div class="dropdown">
    <button class="btn  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
            aria-expanded="false">
        گزینه ها
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

        <a class="dropdown-item" href="{{route($route.'.index')}}">
            <span class="fa fa-list "></span>
            <span>مشاهده {{$title}} </span>
        </a>

        <a class="dropdown-item" href="{{route($route.'.create')}}">
            <span class="fa fa-pencil"></span>
            <span>افزودن {{$title}} جدید</span>
        </a>
        <a class="dropdown-item" href="{{route($route.'.index',['trashed'=>'true'])}}">
            <span class="fa fa-trash"></span>
            <span>سطل زباله ({{$trashed_count}})</span>
        </a>

        <a class="dropdown-item off item_form" id="remove_items" msg="آیا از حذف {{$title}} های انتخابی مطئمن هستید؟">
            <span class="fa fa-remove"></span>
            <span>حذف {{$title}}</span>
        </a>


        @if(isset($_GET['trashed']) && $_GET['trashed']==='true')
            <a class="dropdown-item off item_form" id="restore_items"
               msg="آیا از بازیابی {{$title}} های انتخابی مطئمن هستید؟">
                <span class="fa fa-refresh"></span>
                <span>بازیابی {{$title}}</span>
            </a>
        @endif

    </div>
</div>
