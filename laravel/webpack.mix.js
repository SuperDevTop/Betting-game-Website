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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

mix.js('resources/assets/js/app.js', 'public/js/app.js')
    .js('resources/assets/js/forgeapp.js', 'public/js/forgeapp.js')
    .js('resources/assets/js/forge.js', 'public/js/forge.js')
    .js('resources/assets/js/signin.js', 'public/js/signin.js')
    .js('resources/assets/js/init.js', 'public/js/init.js')
    .copy('resources/assets/js/jquery-ui.min.js', 'public/js')
    .copy('node_modules/sweetalert/dist/sweetalert.css', 'public/plugins/sweetalert/sweetalert.css')
    .sass('resources/assets/sass/dynamic.scss', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/admin-app.scss', 'public/css/admin/app.css');

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'public/js/jquery-ui.min.js',
    'node_modules/materialize-css/bin/materialize.js',
    'public/plugins/scrollbar/perfect-scrollbar.min.js'
], 'public/js/all.js');
