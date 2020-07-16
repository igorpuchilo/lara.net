const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
mix.js('resources/js/ajaxupload.js', 'public/js').version();
mix.js('resources/js/app_main.js', 'public/js').version();
mix.js('resources/js/validator.js', 'public/js').version();
mix.js('resources/js/bootstrap-validate.js', 'public/js').version();
mix.js('resources/js/bootstrap.min.js', 'public/js').version();
mix.js('resources/js/jquery.fancybox.min.js', 'public/js').version();
mix.js('resources/js/jquery.js', 'public/js').version();
mix.js('resources/js/popper.min.js', 'public/js').version();
mix.js('resources/js/cart_change_qty.js', 'public/js').version();
mix.styles('resources/sass/css/404.css', 'public/css/404.css').version();
