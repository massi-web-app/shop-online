let toggle = false;
let delete_url = null;
let token = null;
let send_array_data = false;
let _method = 'DELETE';
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
    } else if (toggle) {
        $(".child_menu").slideUp();
        $(".child_menu", this).show();
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


$(window).resize(function () {
    set_sidebar_width();
});

$(document).ready(function () {
    set_sidebar_width();
});

function set_sidebar_width() {
    const width = document.body.offsetWidth;
    if (width < 850) {
        $(".page_sidebar").addClass('toggled');
        $(".page_content").css('margin-right', '50px');
        $(".child_menu").hide();
    } else {
        if (!toggle) {
            $(".page_sidebar").removeClass("toggled");
            $(".page_content").css('margin-right', '240px');
        }

    }
}


function select_file() {
    $("#image").click()
}


function loadFile(event) {
    const file_reader = new FileReader();

    file_reader.onload = function () {
        const output = document.getElementById("output_image");
        output.src = file_reader.result;
    }

    file_reader.readAsDataURL(event.target.files[0]);
}


function delete_row(url, token_form, message_text) {

    _method = 'DELETE';
    delete_url = url;
    token = token_form;

    $(".message_div #msg").text(message_text);
    $(".message_div").show();

}

function confirm_operation() {


    if (send_array_data) {
        $("#data_form_table").submit();
    } else {
        let form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', delete_url);

        const methodField = document.createElement('input');
        methodField.setAttribute('name', '_method');
        methodField.setAttribute('value', _method);

        form.append(methodField);


        const tokenField = document.createElement('input');
        tokenField.setAttribute('name', '_token');
        tokenField.setAttribute('value', token);
        form.append(tokenField);

        document.body.appendChild(form);
        form.submit();

        document.body.removeChild(form);
    }

}


function cancel_operation() {
    token = null;
    delete_url = null;
    $(".message_div #msg").text('');
    $(".message_div").hide();

}


$(".check_box_item").click(function () {
    send_array_data = false;
    const $checkBoxes = $('table td input[type="checkbox"]');
    const $checkboxes_selected = $checkBoxes.filter(':checked').length;

    if ($checkboxes_selected > 0) {
        $("#remove_items").removeClass('off');
        $("#restore_items").removeClass('off');
    } else {
        $("#remove_items").addClass('off');
        $("#restore_items").addClass('off');
    }
})


$(".item_form").click(function () {
    send_array_data = true;
    const $checkBoxes = $('table td input[type="checkbox"]');
    const $checkboxes_selected = $checkBoxes.filter(':checked').length;
    if ($checkboxes_selected > 0) {
        let href = window.location.href.split('?');
        let action = href[0] + '/' + $(this).attr('id');

        if (href.length === 2) {
            action = action + '?' + href[1];
        }
        $("#data_form_table").attr('action', action);
        $(".message_div #msg").text($(this).attr('msg'));
        $(".message_div").show();
    }
});


function restore_row(url, token_form, message_text) {

    delete_url = url;
    _method = 'POST'
    token = token_form;

    $(".message_div #msg").text(message_text);
    $(".message_div").show();

}

