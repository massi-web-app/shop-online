<div class="dropdown">
    <button class="btn  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
            aria-expanded="false">
        گزینه ها
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="{{route($route.'.create')}}">
            <span class="fa fa-pencil"></span>
            <span>افزودن {{$title}} جدید</span>
        </a>
        <a class="dropdown-item" href="{{route($route.'.index',['trashed'=>'true'])}}">
            <span class="fa fa-trash"></span>
            <span>سطل زباله ({{$trashed_count}})</span>
        </a>

        <a class="dropdown-item">
            <span class="fa fa-pencil"></span>
            <span>افزودن {{$title}} جدید</span>
        </a>
    </div>
</div>
