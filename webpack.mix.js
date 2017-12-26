let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/assets/js/app.js')
    .sass('resources/assets/sass/app.scss', 'public/assets/css/app.css')
    .sass('resources/assets/sass/admin/main.scss', 'public/assets/admin/css/main.css')
    .js('resources/assets/js/admin/main.js', 'public/assets/admin/js/main.js')
    .sass('resources/assets/sass/front/main.scss', 'public/assets/css/main.css');
