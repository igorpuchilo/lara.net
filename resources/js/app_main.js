//Bootstrap 4 multi dropdown navbar
$(document).ready(function () {
    $('.dropdown-menu a.dropdown-toggle').mouseenter(function (e) {
        var $el = $(this);
        $el.toggleClass('active-dropdown');
        var $parent = $(this).offsetParent(".dropdown-menu");
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');

        $(this).parent("li").toggleClass('show');

        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
            $('.dropdown-menu .show').removeClass("show");
            $el.removeClass('active-dropdown');
        });

        if (!$parent.parent().hasClass('navbar-nav')) {
            $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
        }

        return false;
    });

    responsiveFooter();

    window.onresize = function () {
        responsiveFooter();
    };

    function responsiveFooter() {
        if ($(window).height() >= $('body').height() + $('.footerapp').height()) {
            $('.footerapp').addClass('footer-fixed');
        } else {
            $('.footerapp').removeClass('footer-fixed');
        }
    }
    //qnt prod card
    $('.btn-number').click(function(e){
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {

                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
            changePrice(input.val(),fieldName);
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {

        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        changePrice(valueCurrent,name);
    });
    $(".input-number").keydown(function (e) {
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
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    function changePrice(value,name) {
        var input = $("input[id='"+name+"']");
        var output = $("span[id='"+name+"']");
        var price = parseFloat(input.val()), newPrice;
        newPrice = price * value;
        $(output, this).text(function () {
            return newPrice;
        });
    }
});
//Search
var route = "http://lara.net/autocomplete";
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

// Confirm Delete Alert
$('.delete').click(function () {
    var res = confirm('Are u really want delete this item?');
    if (!res){
        return false;
    }
});
// $.ajax({
//     type: 'GET',
//     url: '/category/filter',
//     data: {
//         date: date
//     },
//     success: function(data){
//         console.log(data.data);
//     },
//     error: function(xhr){
//         console.log(xhr.responseText);
//     }
// });