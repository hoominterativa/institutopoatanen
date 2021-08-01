const mix = require('laravel-mix');

var LiveReloadPlugin = require('webpack-livereload-plugin');



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

mix
//JS
    .js('resources/js/app.js', 'public/js')
    .js('resources/views/Admin/assets/js/app.min.js', 'public/admin/assets/js/app.min.js')
    .js('resources/views/Admin/assets/js/vendor.min.js', 'public/admin/assets/js/vendor.min.js')
    .js([
        'node_modules/parsleyjs/dist/parsley.min.js'
    ], 'public/admin/assets/libs/app.min.js')
    .js('resources/views/Admin/assets/js/pages/form-validation.init.js', 'public/admin/assets/js/pages/form-validation.init.js')

//CSS
.styles('resources/views/Admin/assets/css/config/bootstrap.min.css', 'public/admin/assets/css/config/bootstrap.min.css')
    .styles('resources/views/Admin/assets/css/config/app.min.css', 'public/admin/assets/css/config/app.min.css')
    .styles('resources/views/Admin/assets/css/config/bootstrap-dark.min.css', 'public/admin/assets/css/config/bootstrap-dark.min.css')
    .styles('resources/views/Admin/assets/css/config/app-dark.min.css', 'public/admin/assets/css/config/app-dark.min.css')
    .styles('resources/views/Admin/assets/css/icons.min.css', 'public/admin/assets/css/icons.min.css')

//SASS
.sass('resources/sass/app.scss', 'public/css')

//CONFIG
.autoload({
        'jquery': ['$', 'window.jQuery', 'jQuery']
    })
    .sourceMaps()
    .version()