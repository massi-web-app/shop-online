<span class="fa fa-bars" id="sidebarToggle"></span>
<ul id="sidebar_menu">
    <li>
        <a href="#">
            <span class="fa fa-shopping-cart"></span>
            <span class="sidebar_menu_text">محصولات</span>
            <span class="fa fa-angle-left"></span>
        </a>
        <div class="child_menu">
            <a href="{{route('product.index')}}">مدیریت محصولات</a>
            <a href="{{route('product.create')}}">افزودن محصول</a>
            <a href="{{route('category.index')}}">مدیریت دسته ها</a>
        </div>
    </li>

    <li>
        <a href="#">
            <span class="fa fa-sliders"></span>
            <span class="sidebar_menu_text">مدیریت اسلایدرها</span>
            <span class="fa fa-angle-left"></span>
        </a>
        <div class="child_menu">
            <a href="">مدیریت اسلایدرها</a>
            <a href="">افزودن اسلایدر جدید</a>
        </div>
    </li>


</ul>
