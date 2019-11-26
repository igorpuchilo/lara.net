// MY JS
//
//
// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */
//
// require('./bootstrap');
//
// window.Vue = require('vue');
//
// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */
//
// // const files = require.context('./', true, /\.vue$/i);
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
//
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// const app = new Vue({
//     el: '#app',
// });
//
//
//
// Delete order confirm
$('.delete').click(function () {
    var res = confirm('Are u really want delete this item?');
    if (!res) return false;
});
// Delete from DB order confirm
$('.deletedb').click(function () {
    var res = confirm('Are u really want delete this item from database?');
    if (!res) {
        return false;
    }
});

//Menu Active

$('.sidebar-menu a').each(function () {
    var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var link = this.href;
    if (link === location) {
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});

//KCEditor
$('#editor1').ckeditor();

//Filter Reset
$('#reset-filter').click(function () {
    $('#filter input[type=radio]').prop('checked', false);
    return false;
});
//select category
$('#add').on('submit', function () {
    if (!isNum($('#parent_id').val())) {
        alert('Choose category');
        return false;
    }
});

//Is number function
function isNum(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

//Search
var route = "http://lara.net/admin/autocomplete";
$('#search').typeahead({
    source: function (term, process) {
        return $.get(route, {term: term}, function (data) {
            return process(data);
        });
    },
    minLength: 1,
    items: 5,
    delay: 400,
    autoSelect: false,

});
//Change product qnt
// $(document).ready(function () {
    $('.resp-qnt').on('click','.btn-number',function (e) {
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
            changePrice(input.val(), fieldName);
        } else {
            input.val(0);
        }
    });
    $('.resp-qnt').on('focusin','.input-number',function () {
        $(this).data('oldValue', $(this).val());
    });
    $('.resp-qnt').on('change','.input-number',function () {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        changePrice(valueCurrent, name);
    });
    $('.resp-qnt').on('keydown','.input-number',function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 49 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    function changePrice(value, name) {
        if (value>0){
            var order_id = document.getElementById('order_id').value;
            var product_id = document.getElementById('prod_'+ name).value;
            document.getElementById('table').style.visibility = "hidden";
            $('#loading').css('display', 'block');
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            $.ajax({
                url: '/admin/orders/ajax-change-prod-qty',
                data: { product_id: product_id, order_id: order_id, qty:value},
                type: 'POST',
                success: function (data) {
                    $('#loading').css('display', 'none');
                    $("#table").load(location.href+" #table>*","");
                    document.getElementById('table').style.visibility = "visible";
                },
                error: function (xhr, status, error) {
                    alert(xhr.responeText);
                    $('#loading').css('display', 'none');
                }
            });
        }

    }
// });