let toggle = false;

$("#sidebar_menu li").click(function () {

    if (!$(this).hasClass("active")) {
        $("#sidebar_menu li").removeClass('active');
        $(this).addClass('active');
        $(".child_menu").slideUp();
        $(".fa-angle-left").removeClass("active");
        $(".fa-angle-left", this).addClass("active");
        if (!toggle) {
            $(".child_menu", this).slideDown(500);
        } else {
            $(".child_menu", this).show();
        }
    }

})


$("#sidebarToggle").click(function () {

    if ($(".page_sidebar").hasClass("toggled")) {
        toggle = false;
        $(".page_sidebar").removeClass("toggled");
        $("#sidebar_menu").find(".active .child_menu").css('display', 'block');
        $(".page_content").css('margin-right', '240px');
    } else {
        toggle = true;
        $(".page_content").css('margin-right', '50px');
        $(".page_sidebar").addClass("toggled");
        $(".child_menu").hide();
    }
});
