//Bootstrap 4 multi dropdown navbar
$( document ).ready( function () {
    $( '.dropdown-menu a.dropdown-toggle' ).mouseenter( function ( e ) {
        var $el = $( this );
        $el.toggleClass('active-dropdown');
        var $parent = $( this ).offsetParent( ".dropdown-menu" );
        if ( !$( this ).next().hasClass( 'show' ) ) {
            $( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
        }
        var $subMenu = $( this ).next( ".dropdown-menu" );
        $subMenu.toggleClass( 'show' );

        $( this ).parent( "li" ).toggleClass( 'show' );

        $( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function ( e ) {
            $( '.dropdown-menu .show' ).removeClass( "show" );
            $el.removeClass('active-dropdown');
        } );

        if ( !$parent.parent().hasClass( 'navbar-nav' ) ) {
            $el.next().css( { "top": $el[0].offsetTop, "left": $parent.outerWidth() - 4 } );
        }

        return false;
    } );

    responsiveFooter();

    window.onresize = function() {
        responsiveFooter();
    };

    function responsiveFooter() {
        if ($(window).height() >= $('body').height() + $('.footerapp').height()) {
            $('.footerapp').addClass('footer-fixed');
        } else {
            $('.footerapp').removeClass('footer-fixed');
        }
    }

    function increaseValue() {
        var value = parseInt(document.getElementById('product-quantity').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById('product-quantity').value = value;
    }

    function decreaseValue() {
        var value = parseInt(document.getElementById('product-quantity').value, 10);
        value = isNaN(value) ? 1 : value;
        value--;
        value < 1 ? value = 1 : '';
        document.getElementById('product-quantity').value = value;
    }

    $('#productQuanIncrease').on('click', increaseValue);
    $('#productQuanDecrease').on('click', decreaseValue);
} );