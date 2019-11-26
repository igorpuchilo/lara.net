//Change product qnt
// $(document).ready(function () {
$('.resp-qnt').on('click','.btn-number-cart',function (e) {
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
$('.resp-qnt').on('focusin','.input-number-cart',function () {
    $(this).data('oldValue', $(this).val());
});
$('.resp-qnt').on('change','.input-number-cart',function () {

    minValue = parseInt($(this).attr('min'));
    maxValue = parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    name = $(this).attr('name');
    if (valueCurrent >= minValue) {
        $(".btn-number-cart[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if (valueCurrent <= maxValue) {
        $(".btn-number-cart[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    changePrice(valueCurrent, name);
});
$('.resp-qnt').on('keydown','.input-number-cart',function (e) {
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
        document.getElementById('table-cart').style.visibility = "hidden";
        $('#loading-cart').css('display', 'block');
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        $.ajax({
            url: '/cart/ajax-change-prod-qty',
            data: { product_id: product_id, order_id: order_id, qty:value},
            type: 'POST',
            success: function (data) {
                $('#loading-cart').css('display', 'none');
                $("#table-cart").load(location.href+" #table-cart>*","");
                document.getElementById('table-cart').style.visibility = "visible";
            },
            error: function (xhr, status, error) {
                alert(xhr.responeText);
                $('#loading-cart').css('display', 'none');
            }
        });
    }

}
// });