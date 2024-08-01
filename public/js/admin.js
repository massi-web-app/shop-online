let toggle = false;
let delete_url = null;
let token = null;
let send_array_data = false;
let _method = 'DELETE';

$("#sidebar_menu li").click(function () {
    if (!$(this).hasClass("active")) {
        $("#sidebar_menu li").removeClass('active');
        $(this).addClass('active');
        $(".child_menu").hide(200);
        $(".fa-angle-left").removeClass("active");
        $(".fa-angle-left", this).addClass("active");
        if (!toggle) {
            $(".child_menu", this).show(500);
        } else {
            $(".child_menu", this).show(500);
        }
    } else if (toggle) {
        $(".child_menu").hide(200);
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

    const url=window.location.href.split('?')[0];

    const tagSidebar=$(`#sidebar_menu a[href="${url}"]`);
    tagSidebar.parent().parent().addClass('active');
    tagSidebar.parent().parent().find("a .fa-angle-left").addClass('fa-angle-down');
    tagSidebar.parent().parent().find("a .fa-angle-left").removeClass('fa-angle-left');
    tagSidebar.parent().parent().find(".child_menu").show();

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


function select_file2() {
    $("#mobile_image_url").click()
}


function loadFile(event) {
    const file_reader = new FileReader();

    file_reader.onload = function () {
        const output = document.getElementById("output_image");
        output.src = file_reader.result;
    }

    file_reader.readAsDataURL(event.target.files[0]);
}


function loadFile2(event) {
    const file_reader = new FileReader();

    file_reader.onload = function () {
        const output = document.getElementById("output_image2");
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

function remove_tag(tag_id, tag_name) {

    $(`#tag_div_${tag_id}`).remove();
    const keywords = document.getElementById("keywords").value;
    const tag_first = tag_name + ',';
    const tag_latest = ',' + tag_name;
    let a = keywords.replace(tag_first, "");
    let b = a.replace(tag_latest, "");

    document.getElementById("keywords").value = b;
}

function add_tag() {
    const tag_list = document.getElementById("tag_list").value;
    const tag_list_array = tag_list.split('،');
    const keywords = document.getElementById("keywords").value;
    let count = document.getElementsByClassName('tag_div').length + 1;
    let string = keywords;
    for (let i = 0; i < tag_list_array.length; i++) {
        if (tag_list_array[i].trim() !== '') {
            const check_tag_exists = keywords.search(tag_list_array[i]);
            if (check_tag_exists === -1) {
                const tag_name_row = "'" + tag_list_array[i] + "'";
                string = string + ',' + tag_list_array[i];
                let tag = '<div class="tag_div" id="tag_div_' + count + '">' +
                    '<span class="fa fa-remove" onclick="remove_tag(' + count + ',' + tag_name_row + ')"></span>' + tag_list_array[i] +
                    '</div>';

                count++;
                $("#tag_box").append(tag);
            }
        }
    }

    document.getElementById('keywords').value = string;
    document.getElementById("tag_list").value = '';
}
