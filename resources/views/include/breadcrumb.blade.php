<div class="breadcrumb">
    <ul class="list-inline">
        <li>
            <a href="{{route('admin.index')}}">
                <span class="fa fa-home"></span>
                <span>پیشخوان</span>
                @if(isset($data))
                    <span class="fa fa-angle-left"></span>
                @endif
            </a>
        </li>

        @if(isset($data) && is_array($data))
            @foreach($data as $key=>$value)
                <li>
                    <a href="{{$value['route']}}">
                        <span>{{$value['title']}}</span>
                        @if($key!==sizeof($data)-1 || isset($_GET['trashed']))
                            <span class="fa fa-angle-left"></span>
                        @endif
                    </a>
                </li>
            @endforeach
        @endif

        @if(isset($_GET['trashed']))
            <li>
                <a>
                    <span>سطل زباله</span>
                </a>
            </li>
        @endif
        <li class="breadcrumb_date">
            <span class="fa fa-calendar"></span>
            <span>امروز</span>
            <span>{{\App\Helper\Helper::date()->jdate('l')}}</span>
            <span>{{\App\Helper\Helper::date()->jdate('j')}}</span>
            <span>{{\App\Helper\Helper::date()->jdate('F')}}</span>
            <span>{{\App\Helper\Helper::date()->jdate('Y')}}</span>
            <span></span>
            <span></span>
        </li>

    </ul>
</div>
