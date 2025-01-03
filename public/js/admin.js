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

    const url = window.location.href.split('?')[0];

    const tagSidebar = $(`#sidebar_menu a[href="${url}"]`);
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


function add_item_input() {


    const id = document.getElementsByClassName("item_input").length + 1;

    const html = `<div class="mb-3 item_groups align-items-center" id="item_-${id}">
                    <div class="align-items-center input-group-custom" >
                       <input type="text" style="display: inline-block" class="form-control form-control-admin item_input" name="item[-${id}]" placeholder="نام گروه ویژگی">
                       <span class="fa fa-plus-circle" onclick="add_child_input(-${id})"></span>
                    </div>

                   <div class="child_item_box"></div>
                </div>`;
    $("#item_box").append(html);
}


function add_child_input(id) {

    const child_count = document.getElementsByClassName("child_input_item").length + 1;
    const counter = document.getElementsByClassName(`child_${id}`).length + 1;
    const html = `<div class="item_child child_${id}">
                    ${counter}- <input type="checkbox" name="check_box_item[${id}][-${child_count}]">
                    <input type="text" name="child_item[${id}][-${child_count}]" class="form-control  form-control-admin child_input_item" placeholder="نام ویژگی" >
                </div>`;

    $(`#item_${id}`).find(".child_item_box").append(html);
}


function add_item_value_input(child_item_id) {

    const html = `
       <div class="form-group">
        <label for="title"></label>
         <input type="text" name="item_value[${child_item_id}][]" class="form-control form-control-admin" id="title" >
       </div>
    `;
    $(`#input_item_box_${child_item_id}`).append(html);
}


function add_filter_input() {
    const id = document.getElementsByClassName('filter_input').length + 1;
    const html = `
        <div class="mb-3 item_groups" id="filter_-${id}">
            <div class="form-group" >
                <input type="text" class="form-control form-control-admin filter_input" name="filter[-${id}]" placeholder="نام گروه فیلتر ">
                <span class="fa fa-plus-circle m-1" onclick="add_filter_child(-${id})"></span>
            </div>
            <div class="child_filter_box"></div>
        </div>
    `;
    $("#filter_box").append(html);
}


function add_filter_child(id) {
    const child_count = document.getElementsByClassName("child_input_filter").length + 1;
    const counter = document.getElementsByClassName(`child_${id}`).length + 1;
    const html = `<div class="item_child child_${id}">
                    ${counter} - <input type="text" name="child_filter[${id}][-${child_count}]" class="form-control  form-control-admin child_input_filter" placeholder="نام فیلتر" >
                </div>`;

    $(`#filter_${id}`).find(".child_filter_box").append(html);
}


$(".item_filter_box  ul li input[type='checkbox']").click(function () {

    const filter = $(this).parent().parent().parent().parent().find('.filter_value');
    const input = $(this).parent().parent().parent().parent().find('.item_value');
    const text = $(this).parent().text().trim();
    let value = input.val();
    let filter_value = filter.val();

    if ($(this).is(':checked')) {
        if (value.trim() === '') {
            value = text;
            filter_value = $(this).val();
        } else {
            value = value + ',' + text;
            filter_value = filter_value + '@' + $(this).val();
        }
        input.val(value);
        filter.val(filter_value);
    } else {
        value = value.replace("," + text, "");
        value = value.replace(text+",", "");
        value = value.replace(text, "");
        filter_value = filter_value.replace("@" + $(this).val(), "");
        filter_value = filter_value.replace($(this).val(), "");
        input.val(value);
        filter.val(filter_value);
    }

});

$(".show_filter_box").click(function(){
    const element=$(this).parent().find(".item_filter_box ul");
    const display=element.css("display");
    if (display=='block'){
        element.slideUp(200);
    }else{
        element.slideDown(500);
    }
})


